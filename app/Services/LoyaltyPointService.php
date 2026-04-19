<?php

namespace App\Services;

use App\Models\User;
use App\Models\Order;
use Exception;

class LoyaltyPointService
{
    const CASHBACK_PERCENTAGE = 0.05; // 5% dari total harga belanja dikonversi menjadi Poin
    const POINT_TO_IDR_RATE = 100; // 1 Kira Poin bernilai diskon Rp 100

    /**
     * Memberikan Cashback Poin saat pesanan fisik telah sampai dan selesai.
     *
     * @param Order $order
     * @return int Jumlah poin yang didapatkan
     */
    public function awardPoints(Order $order): int
    {
        if ($order->status !== 'COMPLETED') {
            throw new Exception("Poin hanya diberikan untuk pesanan yang telah selesai/sampai.");
        }

        $pointsEarned = (int) floor($order->total_price * self::CASHBACK_PERCENTAGE);
        
        $user = $order->user;
        if ($user) {
            $user->increment('kira_points', $pointsEarned);
        }

        return $pointsEarned;
    }

    /**
     * Mengkalkulasi nilai potongan harga (Rupiah) berdasarkan Poin yang ingin dipakai.
     */
    public function calculateDiscount(int $pointsToUse): float
    {
        return (float) ($pointsToUse * self::POINT_TO_IDR_RATE);
    }

    /**
     * Memotong Poin pengguna secara ketat saat Checkout untuk dijadikan Diskon.
     */
    public function redeemPoints(User $user, int $pointsToUse): float
    {
        if ($user->kira_points < $pointsToUse) {
            throw new Exception("Saldo Kira Poin tidak mencukupi untuk ditukar!");
        }

        // Penguncian Atomik: Mencegah serangan Double-Spend (Race Condition) 
        // di mana pembeli mencoba menekan tombol diskon di 2 tab browser secara bersamaan.
        $user->lockForUpdate()->decrement('kira_points', $pointsToUse);
        
        return $this->calculateDiscount($pointsToUse);
    }
}
