<?php

namespace App\Livewire\Checkout;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Misi Berhasil - Kira.com')]
class Success extends Component
{
    public $order;

    public function mount($order)
    {
        // 1. Ambil Data Order
        $this->order = Order::with('items.variant.product')->findOrFail($order);

        // 2. Proteksi: Hanya pemilik order yang bisa melihat halaman ini
        if ($this->order->user_id !== Auth::id()) {
            abort(403, 'Akses Ditolak. Ini bukan wilayah Anda.');
        }

        // Simulasi update status menjadi PAID (karena kita bypass Fase 33)
        // Dalam skenario nyata, ini di-handle oleh Webhook Tripay
        if ($this->order->status === 'PENDING') {
            $this->order->update(['status' => 'PAID']);
        }
    }

    public function render()
    {
        return view('livewire.checkout.success');
    }
}
