<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Order History - Kira.com')]
class OrderHistory extends Component
{
    public function render()
    {
        $orders = Order::with('items.variant.product')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('livewire.profile.order-history', [
            'orders' => $orders
        ]);
    }
}
