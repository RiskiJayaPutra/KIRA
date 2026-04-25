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

    public function mount()
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
            // Generate kode unik, contoh: KIRA-USR3-A8F2
            $randomString = strtoupper(substr(md5(time() . $user->id), 0, 4));
            $code = "KIRA-USR{$user->id}-{$randomString}";
            
            $user->update([
                'affiliate_code' => $code
            ]);

            $this->affiliateCode = $code;
            
            // Opsional: Beri bonus poin karena telah mendaftar afiliasi
            if ($user->kira_points == 0) {
                $user->increment('kira_points', 100);
                $this->kiraPoints = 100;
            }
        }
    }

    public function render()
    {
        return view('livewire.profile.my-wallet');
    }
}
