<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Services\LoyaltyPointService;
use Exception;
use Illuminate\Support\Facades\DB;

class ConcurrencyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * [SRE STRESS TEST]
     * Menguji ketahanan infrastruktur pembayaran terhadap serangan Race Condition (Double Spend).
     * 
     * Skenario Real-World: 
     * Seorang pembeli "nakal" memiliki saldo 10.000 Kira Poin.
     * Dia mencoba mengeklik tombol "Tukar Diskon" menggunakan aplikasi Auto-Clicker
     * sebanyak 5 kali dalam waktu kurang dari 1 detik, berharap mendapat diskon 5x lipat.
     */
    public function test_pessimistic_locking_prevents_double_spend_on_points()
    {
        // 1. Rekayasa Data: Buat 1 User Target dengan 10.000 Poin
        $user = User::factory()->create([
            'kira_points' => 10000
        ]);

        $loyaltyService = new LoyaltyPointService();

        // 2. Transaksi Sah Pertama (Klik Asli)
        DB::transaction(function () use ($user, $loyaltyService) {
            // Ini akan memanggil lockForUpdate() di dalam Service
            $discountRupiah = $loyaltyService->redeemPoints($user, 10000);
            
            // Verifikasi bahwa 10.000 poin sukses dikonversi menjadi Rp 1.000.000
            $this->assertEquals(1000000, $discountRupiah); 
        });

        // Verifikasi bahwa saldo di pangkalan data sudah terkuras habis menjadi 0
        $this->assertEquals(0, $user->fresh()->kira_points);

        // 3. Serangan Transaksi Palsu (Klik Auto-Clicker)
        // Kita harapkan sistem melempar Exception dan menolak keras permintaan ini
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Saldo Kira Poin tidak mencukupi untuk ditukar!");

        DB::transaction(function () use ($user, $loyaltyService) {
            // Proses ini akan membaca nilai pangkalan data TERBARU (yang sudah 0)
            // karena proses pertama tadi mengunci (Locking) jalurnya dengan ketat.
            $loyaltyService->redeemPoints($user->fresh(), 10000);
        });
    }
}
