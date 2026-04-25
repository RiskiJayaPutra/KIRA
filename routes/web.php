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
    Route::get('/dashboard/orders', \App\Livewire\Profile\OrderHistory::class)->name('orders');
    Route::get('/dashboard/wallet', \App\Livewire\Profile\MyWallet::class)->name('wallet');
    Route::get('/checkout/delivery', \App\Livewire\Checkout\Delivery::class)->name('checkout.delivery');
    
    // Placeholder untuk Fase 33 (Tripay)
    Route::get('/checkout/payment/{order}', function ($order) {
        return "
        <div style='font-family: sans-serif; text-align: center; padding-top: 50px;'>
            <h1>Fase 33: Simulasi Gateway Pembayaran</h1>
            <p>Order ID: {$order}</p>
            <p>Anggap saja Anda sudah membayar menggunakan Tripay.</p>
            <a href='" . route('checkout.success', $order) . "' style='display: inline-block; padding: 15px 30px; background: #272343; color: white; text-decoration: none; font-weight: bold; font-size: 20px; border: 4px solid #bae8e8; box-shadow: 4px 4px 0px 0px #bae8e8;'>SIMULASIKAN PEMBAYARAN BERHASIL</a>
        </div>
        ";
    })->name('checkout.payment');

    Route::get('/checkout/success/{order}', \App\Livewire\Checkout\Success::class)->name('checkout.success');
    
    Route::post('/logout', function () {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});
