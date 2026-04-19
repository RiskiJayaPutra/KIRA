<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Operasi Penetrasi Darat (Hardening):
     * Menyuntikkan tameng pelindung tingkat HTTP Header ke setiap respon server.
     * Mencegah metode peretasan paling umum: Clickjacking, XSS, dan MIME-Sniffing.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // 1. Anti-Clickjacking (Hacker mencoba membungkus situs kita di iFrame tak kasat mata)
        $response->headers->set('X-Frame-Options', 'DENY'); 
        
        // 2. Filter XSS Bawaan Peramban
        $response->headers->set('X-XSS-Protection', '1; mode=block'); 
        
        // 3. Mencegah browser menebak-nebak tipe file (MIME-Sniffing)
        $response->headers->set('X-Content-Type-Options', 'nosniff'); 
        
        // 4. Perlindungan Data Referrer saat berpindah situs
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        
        // 5. Enkripsi Paksa Jaringan (HSTS)
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');

        // 6. Content Security Policy (CSP)
        // Membatasi dari mana saja script (GSAP/Tailwind) boleh dimuat.
        $csp = "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdnjs.cloudflare.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' data: https:;";
        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
