<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Kira.com - Premium Blindbox' }}</title>
    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;800;900&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="antialiased selection:bg-button-fomo selection:text-button-text">
    
    {{-- NAVBAR --}}
    <nav class="w-full bg-background border-b-4 border-stroke py-4 px-8 flex justify-between items-center sticky top-0 z-50">
        <div class="text-3xl font-black tracking-tighter text-headline cursor-pointer hover:scale-105 transition-transform">
            KIRA<span class="text-button-fomo" style="-webkit-text-stroke: 1px #272343;">.</span>
        </div>
        <div class="hidden md:flex items-center gap-8">
            <a href="{{ route('catalog') }}" wire:navigate class="font-bold text-headline hover:text-button-fomo hover:underline decoration-4 underline-offset-4 transition-all">Catalog</a>
            <a href="#" class="font-bold text-headline hover:text-button-fomo hover:underline decoration-4 underline-offset-4 transition-all">Drops</a>
            <a href="#" class="font-bold text-headline hover:text-button-fomo hover:underline decoration-4 underline-offset-4 transition-all">Affiliate</a>
            @auth
                <a href="{{ route('wishlist') }}" wire:navigate class="font-bold text-headline hover:text-button-fomo transition-all text-xl">❤️</a>
                <a href="{{ route('dashboard') }}" class="font-bold text-headline hover:text-button-fomo hover:underline decoration-4 underline-offset-4 transition-all" wire:navigate>Dashboard</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="btn-fomo py-2 px-6">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-fomo py-2 px-6" wire:navigate>Login</a>
            @endauth
        </div>
    </nav>

    <main>
        {{ $slot }}
    </main>

    @livewireScripts
    
    <!-- Alpine JS is loaded automatically via Livewire -->
    <!-- GSAP for Smooth Animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
</body>
</html>
