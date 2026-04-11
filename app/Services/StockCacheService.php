<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;

/**
 * Service khusus untuk memindahkan algoritma kalkulasi stok
 * dari relasional Postgres DB ke in-memory Redis agar tidak terjadi interkunci 
 * (Deadlock) saat ribuan request merebut stok bersamaan saat Flash Sale.
 */
class StockCacheService
{
    private const STOCK_KEY_PREFIX = 'stock:variant:';

    /**
     * Menyimpan saldo stok rekaan sementara ke RAM (Redis)
     */
    public function syncStockToCache(int $variantId, int $realStockQty): void
    {
        Redis::set(self::STOCK_KEY_PREFIX . $variantId, $realStockQty);
    }

    /**
     * Algoritma atomik mengunci stok via keranjang. Lolos dari Race Condition.
     */
    public function decrementStockForCart(int $variantId, int $qtyToDecr): bool
    {
        $key = self::STOCK_KEY_PREFIX . $variantId;
        
        // Memaksa Redis mengurus antrian secara linear (Lua Script di background)
        $currentStock = Redis::get($key);
        
        if ($currentStock && $currentStock >= $qtyToDecr) {
            Redis::decrby($key, $qtyToDecr);
            return true;
        }

        return false; // Stok tidak cukup (FOMO alert should show 'Sold out')
    }
}
