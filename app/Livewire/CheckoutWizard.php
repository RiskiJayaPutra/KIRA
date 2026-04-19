<?php

namespace App\Livewire;

use Livewire\Component;

class CheckoutWizard extends Component
{
    public $currentStep = 1;
    public $totalSteps = 3;

    // Data Binding (Asinkronus paralel antar step)
    public $shippingAddress = '';
    public $courier = 'jne';
    public $paymentMethod = 'qris';

    public function nextStep()
    {
        // Validasi Paralel: Setiap Step divalidasi langsung ke server tanpa refresh
        if ($this->currentStep == 1) {
            $this->validate(['shippingAddress' => 'required|min:10'], [
                'shippingAddress.min' => 'Alamat harus jelas agar barang Gacha Anda tidak nyasar!'
            ]);
        } elseif ($this->currentStep == 2) {
            $this->validate(['courier' => 'required']);
        }
        
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function processCheckout()
    {
        // Final Validasi Payment Gateway Intention
        $this->validate(['paymentMethod' => 'required']);
        
        // TODO: (Fase 21+) Integrasi Payment Gateway API Midtrans / Xendit.
        // Di fase ini, mesin hanya bertugas mengoper lemparan state (alamat, kurir, bank)
        // ke tabel Orders (Fase 11) dan mengunci item.
        
        session()->flash('message', 'Pesanan Blindbox Anda Berhasil Diamankan! Segera lakukan pembayaran agar tidak di-cancel.');
        return redirect()->to('/');
    }

    public function render()
    {
        return view('livewire.checkout-wizard');
    }
}
