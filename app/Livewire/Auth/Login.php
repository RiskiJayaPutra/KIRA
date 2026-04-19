<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\RateLimiter;

#[Layout('components.layouts.app')]
#[Title('Sign In - Kira.com')]
class Login extends Component
{
    public $email = '';
    public $password = '';

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $throttleKey = strtolower($this->email).'|'.request()->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            throw ValidationException::withMessages([
                'email' => "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik.",
            ]);
        }

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], true)) {
            RateLimiter::clear($throttleKey);
            session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        RateLimiter::hit($throttleKey);

        throw ValidationException::withMessages([
            'email' => 'Email atau password tidak valid.',
        ]);
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
