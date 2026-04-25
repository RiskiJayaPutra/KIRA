<?php

namespace App\Livewire\Admin\Orders;

use Livewire\Component;
use App\Models\Order;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.admin')]
#[Title('Detail Pesanan - Admin')]
class Show extends Component
{
    public Order $order;
    public $awb = '';

    public function mount(Order $order)
    {
        $this->order = $order->load(['user', 'items.variant.product']);
        $this->awb = $this->order->awb_resi ?? '';
    }

    public function markAsPaid()
    {
        $this->order->update(['status' => 'PAID']);
        $this->dispatch('status-updated');
    }

    public function markAsShipped()
    {
        $this->validate([
            'awb' => 'required|string|min:5'
        ], [
            'awb.required' => 'Nomor resi (AWB) wajib diisi untuk status SHIPPED.',
            'awb.min' => 'Nomor resi terlalu pendek.'
        ]);

        $this->order->update([
            'status' => 'SHIPPED',
            'awb_resi' => $this->awb
        ]);
        
        $this->dispatch('status-updated');
    }

    public function markAsCompleted()
    {
        $this->order->update(['status' => 'COMPLETED']);
        
        // Di sini bisa ditambahkan logika mencairkan komisi afiliasi jika ada
        if ($this->order->affiliate_id) {
            // Logika Phase 40 nanti
        }
        
        $this->dispatch('status-updated');
    }

    public function render()
    {
        return view('livewire.admin.orders.show');
    }
}
