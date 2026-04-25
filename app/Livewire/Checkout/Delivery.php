<?php

namespace App\Livewire\Checkout;

use Livewire\Component;
use App\Models\Cart;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Pengiriman - Kira.com')]
class Delivery extends Component
{
    public $cartItems = [];
    public $addresses = [];
    public $selectedAddressId = null;
    
    public $subtotal = 0;
    public $shippingFee = 25000; // Hardcoded flat rate for now
    public $total = 0;

    public function mount()
    {
        // 1. Ambil Keranjang
        $cart = Cart::with(['items.variant.product'])
            ->where('user_id', Auth::id())
            ->first();

        if (!$cart || $cart->items->count() === 0) {
            return redirect()->route('catalog');
        }

        $this->cartItems = $cart->items;

        // 2. Kalkulasi Harga
        foreach ($this->cartItems as $item) {
            $this->subtotal += ($item->quantity * $item->variant->price);
        }
        $this->total = $this->subtotal + $this->shippingFee;

        // 3. Load Address Book
        $this->addresses = Auth::user()->addresses()->get();
        
        if ($this->addresses->count() > 0) {
            $primary = $this->addresses->where('is_primary', true)->first();
            $this->selectedAddressId = $primary ? $primary->id : $this->addresses->first()->id;
        }
    }

    public function proceedToPayment()
    {
        $this->validate([
            'selectedAddressId' => 'required|exists:addresses,id'
        ], [
            'selectedAddressId.required' => 'Pilih titik pendaratan (alamat pengiriman) terlebih dahulu.'
        ]);

        $selectedAddress = Address::find($this->selectedAddressId);
        $formattedAddress = "{$selectedAddress->recipient_name} | {$selectedAddress->phone_number}\n{$selectedAddress->full_address}, {$selectedAddress->city}, {$selectedAddress->postal_code}";

        // Gunakan Database Transaction agar aman
        $orderId = DB::transaction(function () use ($formattedAddress) {
            
            // 1. Buat Order
            $order = Order::create([
                'user_id' => Auth::id(),
                'shipping_address' => $formattedAddress,
                'status' => 'PENDING',
                'subtotal' => $this->subtotal,
                'shipping_fee' => $this->shippingFee,
                'total_price' => $this->total,
            ]);

            // 2. Pindahkan item dari keranjang ke Order Item
            foreach ($this->cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_variant_id' => $item->product_variant_id,
                    'quantity' => $item->quantity,
                    'price_at_time' => $item->variant->price, // Kunci harga saat ini
                ]);
            }

            // 3. Kosongkan keranjang
            $cart = Cart::where('user_id', Auth::id())->first();
            if ($cart) {
                $cart->items()->delete();
            }

            return $order->id;
        });

        // Redirect ke halaman placeholder pembayaran
        return redirect()->route('checkout.payment', ['order' => $orderId]);
    }

    public function render()
    {
        return view('livewire.checkout.delivery');
    }
}
