<?php

namespace App\Livewire\Admin\Orders;

use Livewire\Component;
use App\Models\Order;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.admin')]
#[Title('Pemrosesan Pesanan - Admin')]
class Index extends Component
{
    public function render()
    {
        $orders = Order::with(['user'])->latest()->get();

        return view('livewire.admin.orders.index', [
            'orders' => $orders
        ]);
    }
}
