<?php

namespace App\Livewire\Catalog;

use Livewire\Component;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistButton extends Component
{
    public $variantId;
    public $productId; // Opsional: jika dipanggil dari grid dan hanya melempar product ID
    public $style = 'full'; // 'full' (teks + icon) atau 'icon' (hanya icon)
    public $isWishlisted = false;

    public function mount($variantId = null, $productId = null, $style = 'full')
    {
        $this->style = $style;
        
        if ($variantId) {
            $this->variantId = $variantId;
        } elseif ($productId) {
            // Jika hanya diberi product_id, cari varian default (paling umum / murah)
            $product = Product::with('variants')->find($productId);
            if ($product && $product->variants->count() > 0) {
                // Prioritaskan drop rate tertinggi (Regular Drop) atau harga termurah
                $defaultVariant = $product->variants->sortByDesc('drop_rate')->first();
                $this->variantId = $defaultVariant->id;
            }
        }

        $this->checkWishlistStatus();
    }

    public function checkWishlistStatus()
    {
        if (Auth::check() && $this->variantId) {
            $this->isWishlisted = Wishlist::where('user_id', Auth::id())
                ->where('product_variant_id', $this->variantId)
                ->exists();
        } else {
            $this->isWishlisted = false;
        }
    }

    public function toggleWishlist()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!$this->variantId) return;

        if ($this->isWishlisted) {
            Wishlist::where('user_id', Auth::id())
                ->where('product_variant_id', $this->variantId)
                ->delete();
            $this->isWishlisted = false;
        } else {
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_variant_id' => $this->variantId
            ]);
            $this->isWishlisted = true;
        }
    }

    public function render()
    {
        return view('livewire.catalog.wishlist-button');
    }
}
