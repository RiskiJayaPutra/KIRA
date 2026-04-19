<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('My Dashboard - Kira.com')]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.profile.dashboard');
    }
}
