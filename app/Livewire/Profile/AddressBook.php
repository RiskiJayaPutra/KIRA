<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Address;

#[Layout('components.layouts.app')]
#[Title('Address Book - Kira.com')]
class AddressBook extends Component
{
    public $addresses;
    
    // Form fields
    public $label = '';
    public $recipient_name = '';
    public $phone_number = '';
    public $full_address = '';
    public $city = '';
    public $postal_code = '';
    
    public $showAddForm = false;

    public function mount()
    {
        $this->loadAddresses();
    }

    public function loadAddresses()
    {
        $this->addresses = auth()->user()->addresses()->orderByDesc('is_primary')->latest()->get();
    }

    public function toggleForm()
    {
        $this->showAddForm = !$this->showAddForm;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['label', 'recipient_name', 'phone_number', 'full_address', 'city', 'postal_code']);
    }

    public function saveAddress()
    {
        $this->validate([
            'label' => 'required|string|max:50',
            'recipient_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'full_address' => 'required|string',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
        ]);

        $isFirst = $this->addresses->count() === 0;

        auth()->user()->addresses()->create([
            'label' => $this->label,
            'recipient_name' => $this->recipient_name,
            'phone_number' => $this->phone_number,
            'full_address' => $this->full_address,
            'city' => $this->city,
            'postal_code' => $this->postal_code,
            'is_primary' => $isFirst, // Auto set primary if it's the first one
        ]);

        $this->loadAddresses();
        $this->toggleForm();
    }

    public function setPrimary($id)
    {
        $address = auth()->user()->addresses()->findOrFail($id);
        
        // Remove primary from all others
        auth()->user()->addresses()->update(['is_primary' => false]);
        
        // Set this one to primary
        $address->update(['is_primary' => true]);
        
        $this->loadAddresses();
    }

    public function deleteAddress($id)
    {
        $address = auth()->user()->addresses()->findOrFail($id);
        
        // If we delete a primary address, make another one primary if exists
        $wasPrimary = $address->is_primary;
        $address->delete();
        
        if ($wasPrimary) {
            $nextPrimary = auth()->user()->addresses()->first();
            if ($nextPrimary) {
                $nextPrimary->update(['is_primary' => true]);
            }
        }
        
        $this->loadAddresses();
    }

    public function render()
    {
        return view('livewire.profile.address-book');
    }
}
