<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Tembok Pertahanan DDoS (Rate Limiting) pada Rute Kritis (Fase 24)
        // Jika ada IP yang mencoba menembak API lebih dari 5 kali per menit, Sistem akan menguncinya!
        \Illuminate\Support\Facades\RateLimiter::for('critical-throttle', function (\Illuminate\Http\Request $request) {
            return \Illuminate\Cache\RateLimiting\Limit::perMinute(5)->by($request->user()?->id ?: $request->ip())
                ->response(function () {
                    return response('Akses Ditolak: Anda terdeteksi menggunakan Bot/Auto-Clicker (DDoS Protection).', 429);
                });
        });
    }
}
