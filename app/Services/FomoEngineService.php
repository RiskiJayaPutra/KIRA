<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Carbon;

class FomoEngineService
{
    /**
     * Menghitung sisa waktu rilis (Countdown Timer) secara absolut.
     * Digunakan untuk memicu kepanikan positif (Adrenalin Rush) sebelum tombol Buy dibuka.
     *
     * @param Product $product
     * @return string|null Mengembalikan format HH:MM:SS atau null jika sudah rilis.
     */
    public function getReleaseCountdown(Product $product): ?string
    {
        // Pastikan atribut release_date di-cast sebagai datetime di model Product
        $releaseDate = Carbon::parse($product->release_date);

        if (!$releaseDate || $releaseDate->isPast()) {
            return null; // Bebas dibeli (Sudah rilis)
        }

        $diff = now()->diff($releaseDate);
        return sprintf('%02d:%02d:%02d', $diff->h + ($diff->days * 24), $diff->i, $diff->s);
    }

    /**
     * Menghitung indikator kelangkaan (Scarcity) berdasarkan persediaan gudang.
     * Jika stok tinggal sedikit, kita keluarkan teks agresif untuk mendorong konversi.
     *
     * @param ProductVariant $variant
     * @return string
     */
    public function getScarcityAlert(ProductVariant $variant): string
    {
        if ($variant->stock === 0) {
            return 'SOLD OUT ☠️'; // Menciptakan penyesalan bagi yang telat
        }

        if ($variant->stock <= 5) {
            return "HAMPIR HABIS! Sisa {$variant->stock} Pcs 🔥"; // Trigger utama FOMO
        }

        if ($variant->stock <= 20) {
            return 'Stok Menipis 👀';
        }

        return 'Tersedia';
    }
}
