<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('My Wallet - Kira.com')]
class MyWallet extends Component
{
    public $kiraPoints = 0;
    public $affiliateBalance = 0;
    public $affiliateCode = null;

    public $showPayoutForm = false;
    public $payoutAmount;
    public $bankDetails;

    public function mount()
    {
        $this->refreshData();
    }

    public function refreshData()
    {
        $user = Auth::user();
        $this->kiraPoints = $user->kira_points;
        $this->affiliateBalance = $user->affiliate_balance;
        $this->affiliateCode = $user->affiliate_code;
    }

    public function activateAffiliate()
    {
        $user = Auth::user();
        
        if (!$user->affiliate_code) {
            $randomString = strtoupper(substr(md5(time() . $user->id), 0, 4));
            $code = "KIRA-USR{$user->id}-{$randomString}";
            
            $user->update([
                'affiliate_code' => $code
            ]);

            $this->affiliateCode = $code;
            
            if ($user->kira_points == 0) {
                $user->increment('kira_points', 100);
            }
            
            $this->refreshData();
        }
    }

    public function togglePayoutForm()
    {
        $this->showPayoutForm = !$this->showPayoutForm;
    }

    public function requestPayout()
    {
        $this->validate([
            'payoutAmount' => 'required|numeric|min:50000|max:' . $this->affiliateBalance,
            'bankDetails' => 'required|string|min:10',
        ], [
            'payoutAmount.min' => 'Minimal pencairan adalah Rp 50.000',
            'payoutAmount.max' => 'Saldo tidak mencukupi.',
            'bankDetails.required' => 'Detail rekening wajib diisi.',
            'bankDetails.min' => 'Detail rekening terlalu singkat.',
        ]);

        $user = Auth::user();

        // Buat Request
        \App\Models\PayoutRequest::create([
            'user_id' => $user->id,
            'amount' => $this->payoutAmount,
            'bank_details' => $this->bankDetails,
        ]);

        // Kurangi saldo sementara
        $user->decrement('affiliate_balance', $this->payoutAmount);

        $this->showPayoutForm = false;
        $this->payoutAmount = null;
        $this->bankDetails = null;
        $this->refreshData();
        
        session()->flash('payout_success', 'Permintaan penarikan dana berhasil dikirim ke Markas Besar KIRA. Harap tunggu verifikasi.');
    }

    public function render()
    {
        return view('livewire.profile.my-wallet');
    }
}
