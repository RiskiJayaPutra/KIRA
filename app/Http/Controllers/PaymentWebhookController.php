<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PaymentGatewayService;
use App\Models\Order;
use App\Services\LoyaltyPointService;
use App\Services\AffiliateService;
use Illuminate\Support\Facades\Log;

class PaymentWebhookController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentGatewayService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Endpoint API Menerima Notifikasi dari Server Bank/Payment Gateway (Midtrans/Xendit).
     */
    public function handle(Request $request)
    {
        // 1. Tangkap Signature dari Header yang disisipkan oleh Server Bank
        $signature = $request->header('X-Callback-Signature') ?? $request->header('Midtrans-Signature');
        
        if (!$signature) {
            Log::alert('WEBHOOK HACK ATTEMPT: Tidak Ada Signature!', ['ip' => $request->ip()]);
            return response()->json(['message' => 'Unauthorized / Serangan Ditolak'], 401);
        }

        // 2. Verifikasi Keaslian Data (Anti-Spoofing)
        // Kita bandingkan body mentah dengan kunci rahasia server
        $isValid = $this->paymentService->verifySignature($request->getContent(), $signature);
        
        if (!$isValid) {
            Log::critical('WEBHOOK HACK ATTEMPT: Signature Palsu (Spoofed)!', ['ip' => $request->ip()]);
            return response()->json(['message' => 'Signature Mismatch! Anda dilaporkan.'], 403);
        }

        // 3. Proses Pembayaran yang Sah (Sudah Terverifikasi Bank)
        $orderId = $request->input('order_id');
        $transactionStatus = $request->input('transaction_status');

        $order = Order::find($orderId);
        if (!$order) {
            return response()->json(['message' => 'Pesanan Tidak Ditemukan'], 404);
        }

        // 4. Orkestrasi Penuh (Memanggil Fase 19 & Fase 20 secara bersamaan)
        if ($transactionStatus === 'settlement' || $transactionStatus === 'paid') {
            
            // Mencegah pencairan ganda jika Webhook terkirim dua kali oleh Bank (Idempotency)
            if ($order->status !== 'COMPLETED') {
                $order->update(['status' => 'COMPLETED']);

                // Orkestrasi 1: Cairkan Cashback Kira Poin (Fase 19)
                $loyalty = new LoyaltyPointService();
                $loyalty->awardPoints($order);

                // Orkestrasi 2: Cairkan Komisi Calo Afiliator (Fase 20)
                $affiliate = new AffiliateService();
                $affiliate->distributeCommission($order);

                Log::info("Transaksi Aman! Pesanan {$orderId} telah dibayar lunas. Komisi & Poin telah dibagikan.");
            }
        } elseif ($transactionStatus === 'expire' || $transactionStatus === 'cancel') {
            // Bebaskan kembali stok jika pembeli batal bayar (Fase 11)
            $order->update(['status' => 'CANCELLED']);
            // (Logika restock barang diabaikan untuk keringkasan controller ini)
            Log::info("Pesanan {$orderId} Batal/Kadaluarsa.");
        }

        // 5. Beri tahu Server Bank bahwa kita telah menerimanya
        return response()->json(['message' => 'Webhook Processed Successfully'], 200);
    }
}
