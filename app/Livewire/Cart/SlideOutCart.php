<?php

namespace App\Livewire\Cart;

use Livewire\Component;
use App\Models\Cart;
use App\Models\CartItem;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class SlideOutCart extends Component
{
    public $isOpen = false;

    // Get current cart dynamically
    public function getCartProperty()
    {
        if (Auth::check()) {
            return Cart::with(['items.variant.product'])->firstOrCreate(
                ['user_id' => Auth::id()]
            );
        } else {
            return Cart::with(['items.variant.product'])->firstOrCreate(
                ['session_id' => session()->getId()]
            );
        }
    }

    #[On('open-cart')]
    public function openCart()
    {
        $this->isOpen = true;
    }

    public function closeCart()
    {
        $this->isOpen = false;
    }

    #[On('add-to-cart')]
    public function addToCart($variantId)
    {
        $cart = $this->cart;

        $cartItem = CartItem::where('cart_id', $cart->id)
                            ->where('product_variant_id', $variantId)
                            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_variant_id' => $variantId,
                'quantity' => 1
            ]);
        }

        $this->isOpen = true;
    }

    public function incrementQuantity($itemId)
    {
        $item = CartItem::where('id', $itemId)->where('cart_id', $this->cart->id)->first();
        if ($item) {
            $item->increment('quantity');
        }
    }

    public function decrementQuantity($itemId)
    {
        $item = CartItem::where('id', $itemId)->where('cart_id', $this->cart->id)->first();
        if ($item) {
            if ($item->quantity > 1) {
                $item->decrement('quantity');
            } else {
                $item->delete();
            }
        }
    }

    public function removeItem($itemId)
    {
        CartItem::where('id', $itemId)->where('cart_id', $this->cart->id)->delete();
    }

    public function render()
    {
        $cart = $this->cart;
        $subtotal = 0;
        
        if ($cart && $cart->items) {
            foreach ($cart->items as $item) {
                $subtotal += $item->quantity * $item->variant->price;
            }
        }

        return view('livewire.cart.slide-out-cart', [
            'cartItems' => $cart ? $cart->items : [],
            'subtotal' => $subtotal
        ]);
    }
}
