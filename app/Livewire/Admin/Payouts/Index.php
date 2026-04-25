<?php

namespace App\Livewire\Admin\Payouts;

use Livewire\Component;
use App\Models\PayoutRequest;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.admin')]
#[Title('Pencairan Afiliasi - Admin')]
class Index extends Component
{
    public function approve($id)
    {
        $request = PayoutRequest::findOrFail($id);
        
        if ($request->status === 'PENDING') {
            $request->update(['status' => 'APPROVED']);
        }
    }

    public function reject($id)
    {
        $request = PayoutRequest::findOrFail($id);
        
        if ($request->status === 'PENDING') {
            DB::transaction(function () use ($request) {
                // Tolak permintaan
                $request->update(['status' => 'REJECTED']);
                
                // Kembalikan dana ke user
                $request->user->increment('affiliate_balance', $request->amount);
            });
        }
    }

    public function render()
    {
        $payouts = PayoutRequest::with('user')->latest()->get();

        return view('livewire.admin.payouts.index', [
            'payouts' => $payouts
        ]);
    }
}
