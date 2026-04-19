<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\User;
use App\Models\ProductVariant;
use Carbon\Carbon;

class AdminDashboard extends Component
{
    /**
     * Mesin Penggerak Dashboard Intelijen E-Commerce (Satelit).
     * 
     * Catatan: Untuk Fase ini (Tahap Prototype), fungsi Auth Middlewares 
     * Spatie (RBAC - Role Super Admin) diabaikan sementara agar visual 
     * komponen dapat diuji secara mandiri terlebih dahulu.
     */
    public function render()
    {
        // 1. Radar Pendapatan: Menarik aliran uang masuk (Settled) hari ini saja.
        $todaySales = Order::whereDate('created_at', Carbon::today())
            ->where('status', 'COMPLETED')
            ->sum('total_price');

        // 2. Radar Komunitas: Menghitung berapa banyak KOL/Youtuber yang menyebarkan link kita (Fase 20).
        // Parameter: Siapapun user yang memiliki affiliate_code terisi.
        $totalAffiliates = User::whereNotNull('affiliate_code')->count();

        // 3. Sensor Kelangkaan (Scarcity Detector): Mengintai isi gudang (Fase 17).
        // Kita butuh data Varian (Secret Character) yang stoknya sekarat (<=5 Pcs).
        $criticalStocks = ProductVariant::where('stock', '<=', 5)
            ->with('product') // Relasi Eager Loading ke Product Master
            ->get();

        // 4. Analitik Psikologi Pembeli (Conversion Rate)
        $conversionRate = [
            'success' => Order::where('status', 'COMPLETED')->count(),
            'failed'  => Order::whereIn('status', ['CANCELLED', 'EXPIRED'])->count(),
        ];

        return view('livewire.admin-dashboard', [
            'todaySales' => $todaySales,
            'totalAffiliates' => $totalAffiliates,
            'criticalStocks' => $criticalStocks,
            'conversionRate' => $conversionRate,
        ])->layout('components.layouts.app'); // Gunakan Layout Neo-Brutalism dari Fase 13
    }
}
