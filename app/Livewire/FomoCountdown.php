<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Services\FomoEngineService;

class FomoCountdown extends Component
{
    public $productId;
    public $variantId;
    
    // State Penyimpanan
    public $countdownString = null;
    public $scarcityAlert = null;
    public $isReleased = false;

    public function mount($productId, $variantId)
    {
        $this->productId = $productId;
        $this->variantId = $variantId;
        $this->refreshFomoState();
    }

    /**
     * Metode Asinkronus untuk menyegarkan angka sisa rilis dan stok dari Database
     * Fungsi ini di-trigger secara atomik menggunakan "wire:poll" di view.
     */
    public function refreshFomoState()
    {
        $product = Product::find($this->productId);
        $variant = ProductVariant::find($this->variantId);

        if ($product && $variant) {
            $fomoEngine = new FomoEngineService();
            
            // Tarik Hitung Mundur Rilis
            $this->countdownString = $fomoEngine->getReleaseCountdown($product);
            
            // Tarik Level Kelangkaan (Stock Threshold)
            $this->scarcityAlert = $fomoEngine->getScarcityAlert($variant);
            
            if (!$this->countdownString) {
                $this->isReleased = true;
            }
        }
    }

    public function render()
    {
        return view('livewire.fomo-countdown');
    }
}
