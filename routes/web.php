<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/catalog', \App\Livewire\Catalog\ProductGrid::class)->name('catalog');
Route::get('/product/{slug}', \App\Livewire\Catalog\ProductDetail::class)->name('product.detail');

Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', \App\Livewire\Profile\Dashboard::class)->name('dashboard');
    Route::get('/dashboard/addresses', \App\Livewire\Profile\AddressBook::class)->name('address.book');
    Route::get('/dashboard/wishlist', \App\Livewire\Profile\WishlistPage::class)->name('wishlist');
    
    Route::post('/logout', function () {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});
