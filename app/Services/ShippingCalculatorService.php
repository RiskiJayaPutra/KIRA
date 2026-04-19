<?php

namespace App\Services;

class ShippingCalculatorService
{
    /**
     * Mesin Kalkulasi Ongkos Kirim Dinamis.
     * Menggunakan metode abstraksi agar bisa dicolok (di-inject)
     * ke API Pihak Ketiga (RajaOngkir / Kurir Ekspedisi Lainnya) di Fase Integrasi Eksternal kelak.
     *
     * @param string $destinationCityId ID Kota Tujuan pengiriman
     * @param int $totalWeightGrams Berat total mainan / kardus blindbox dalam gram
     * @param string $courier Kode Kurir pilihan (misal: jne, jnt, sicepat)
     * @return float
     */
    public function calculateFee(string $destinationCityId, int $totalWeightGrams, string $courier = 'jne'): float
    {
        // TODO: (Fase 21+) Lakukan HTTP Request sesungguhnya ke Gateway Logistik.
        // Di fase Blueprint ini, kita merancang struktur asimetris untuk menahan kesalahan.
        
        $baseRatePerKg = 15000.00; // Asumsi harga Rp 15.000 per Kg (Reguler).
        $kg = ceil($totalWeightGrams / 1000);
        
        // Asuransi Kegagalan: Jika API eror/memasukkan 0 gram, sistem tetap menagih ongkos kirim minimum 1 Kg
        // Hal ini penting untuk mencegah eksploitasi pembobolan subsidi ongkir silang.
        if ($kg < 1) {
            $kg = 1;
        }

        // Proses kalkulasi dinamis
        $calculatedFee = $kg * $baseRatePerKg;

        return (float) $calculatedFee;
    }
}
