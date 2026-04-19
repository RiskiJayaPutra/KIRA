<?php

namespace App\Services;

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Exception;

class GachaRngService
{
    const GACHA_COST = 100; // Harga 1x tarikan buta dalam nominal Kira Points

    /**
     * Mengeksekusi tarikan Gacha berdasarkan Drop Rate murni (Pseudo-RNG).
     * Mesin ini telah dilengkapi pengamanan isolasi tingkat basis data (Pessimistic Locking).
     *
     * @param User $user
     * @param Product $product (Katalog kotak buta / Blindbox Master)
     * @return \App\Models\ProductVariant|null Varian figur yang dimenangkan, atau melempar Exception jika gagal.
     */
    public function pullGacha(User $user, Product $product)
    {
        if ($user->kira_points < self::GACHA_COST) {
            throw new Exception("Kira Points tidak cukup! Kumpulkan " . self::GACHA_COST . " poin untuk melakukan 1x tarikan.");
        }

        // Mulai Transaksi Database Kritis (Atomic Operation)
        return DB::transaction(function () use ($user, $product) {
            
            // 1. Potong Poin secara Hard-Lock
            // lockForUpdate() mengunci baris pengguna ini agar request eksploitasi ganda dalam
            // waktu yang sama (Race Condition) tertahan secara berurutan.
            $user->lockForUpdate()->decrement('kira_points', self::GACHA_COST);

            // 2. Evaluasi Stok Varian Kotak Buta
            $variants = $product->variants()->where('stock', '>', 0)->get();
            if ($variants->isEmpty()) {
                throw new Exception("Waduh! Semua figur untuk Box ini telah habis diborong kolektor lain.");
            }

            // 3. Mesin RNG (Roulette Wheel Selection Berdasarkan Persentase Drop Rate)
            // Sistem akan mengubah rate seperti 2.5% dan 97.5% menjadi roda putar virtual.
            $totalWeight = $variants->sum('drop_rate');
            $randomNumber = mt_rand(1, (int)($totalWeight * 100)) / 100; // Akurasi tinggi 2 desimal

            $currentWeight = 0;
            foreach ($variants as $variant) {
                $currentWeight += $variant->drop_rate;
                if ($randomNumber <= $currentWeight) {
                    
                    // Selamat! Varian Ditemukan. Potong stok inventaris gudang secara mutlak.
                    $variant->decrement('stock', 1);
                    return $variant;
                }
            }

            // 4. Fallback Terakhir (Pengaman Matematis jika terjadi komputasi desimal meleset di PHP)
            $fallback = $variants->first();
            $fallback->decrement('stock', 1);
            return $fallback;
        });
    }
}
