<?php

namespace App\Services;

class PaymentGatewayService
{
    private $serverKey;

    public function __construct()
    {
        // Secret Key dari Dashboard Midtrans / Xendit (Disembunyikan di .env)
        // Kunci ini hanya diketahui oleh Server kita dan Server Bank.
        $this->serverKey = config('services.payment.server_key', 'RAHASIA-KIRA-12345');
    }

    /**
     * Memverifikasi keaslian Webhook (Notifikasi Pembayaran) dari ancaman Hacker.
     * Hacker peretas sering mengirim payload palsu {"status": "paid"} agar barang dikirim tanpa bayar.
     * Fungsi ini memastikan payload murni dan belum dirubah di tengah jalan (Man-in-the-Middle Attack).
     *
     * @param string $payloadData Data mentah JSON dari request
     * @param string $receivedSignature Tanda Tangan Kriptografi dari header Bank
     * @return bool
     */
    public function verifySignature(string $payloadData, string $receivedSignature): bool
    {
        // Menggunakan SHA-512 standar industri perbankan untuk membuat Tanda Tangan Digital (HMAC)
        $calculatedSignature = hash_hmac('sha512', $payloadData, $this->serverKey);
        
        // Menggunakan hash_equals ketimbang operator == untuk mencegah Timing Attack
        return hash_equals($calculatedSignature, $receivedSignature);
    }
}
