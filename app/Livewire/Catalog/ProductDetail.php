<?php

namespace App\Livewire\Catalog;

use Livewire\Component;
use App\Models\Product;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class ProductDetail extends Component
{
    public $product;
    public $selectedVariant = null;

    public function mount($slug)
    {
        $this->product = Product::with('variants')->where('slug', $slug)->firstOrFail();
        
        // If it's a regular figure, default to the standard edition variant
        if (!$this->product->is_blindbox && $this->product->variants->count() > 0) {
            $this->selectedVariant = $this->product->variants->first()->id;
        }
    }

    public function selectVariant($variantId)
    {
        $this->selectedVariant = $variantId;
    }

    public function addToCart()
    {
        if ($this->selectedVariant) {
            $this->dispatch('add-to-cart', variantId: $this->selectedVariant);
        }
    }

    public function render()
    {
        return view('livewire.catalog.product-detail')
            ->title($this->product->name . ' - Kira.com');
    }
}
