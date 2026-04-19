<?php

namespace App\Services;

use App\Models\User;
use App\Models\Order;
use Exception;
use Illuminate\Support\Str;

class AffiliateService
{
    const COMMISSION_RATE = 0.02; // Komisi 2% dari total pesanan untuk Influencer / KOL

    /**
     * Mendaftarkan Pelanggan biasa menjadi Tenaga Penjual (Affiliator)
     * dan meracik Kode Referral unik secara otomatis.
     */
    public function registerAffiliate(User $user): string
    {
        if ($user->affiliate_code) {
            throw new Exception("Pengguna ini sudah terdaftar di Pasukan Penjual Kira.com.");
        }

        // Cetak kode unik (Contoh: KIRA-BUDI99)
        $code = 'KIRA-' . strtoupper(Str::slug($user->name, '')) . rand(10, 99);
        
        $user->update([
            'affiliate_code' => $code
        ]);

        // Menyuntikkan RBAC Spatie (Dari Fase 7)
        if (!$user->hasRole('Affiliator')) {
            $user->assignRole('Affiliator');
        }

        return $code;
    }

    /**
     * Mendistribusikan aliran uang komisi kepada sang Affiliator.
     * Logika ini harus dipanggil setelah paket fisik diterima pembeli (Status COMPLETED).
     */
    public function distributeCommission(Order $order): float
    {
        if ($order->status !== 'COMPLETED') {
            throw new Exception("Komisi ditahan! Paket belum tuntas dikirim.");
        }

        if (!$order->affiliate_id) {
            return 0; // Transaksi organik (Tanpa calo)
        }

        $affiliator = User::find($order->affiliate_id);
        
        if (!$affiliator) {
            return 0; // Akun affiliator mungkin sudah dihapus
        }

        $commission = (float) ($order->total_price * self::COMMISSION_RATE);
        
        // PENGUNCIAN ATOMIK TINGKAT KERNEL:
        // Mencegah eksploitasi ganda di mana komisi cair dua kali pada waktu yang bersamaan.
        $affiliator->lockForUpdate()->increment('affiliate_balance', $commission);

        return $commission;
    }
}
