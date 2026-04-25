<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Kira Admin Command Center' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-background text-headline font-sans antialiased min-h-screen flex selection:bg-tertiary selection:text-headline">

    <!-- Sidebar Admin -->
    <aside class="w-64 bg-headline text-background border-r-4 border-stroke shrink-0 flex flex-col hidden md:flex sticky top-0 h-screen overflow-y-auto">
        <div class="p-6 border-b-4 border-stroke bg-button-fomo text-headline flex items-center gap-3">
            <x-heroicon-s-command-line class="w-8 h-8" />
            <h1 class="text-2xl font-black uppercase tracking-tighter">KIRA ADMIN</h1>
        </div>
        
        <nav class="flex-grow py-6 flex flex-col font-bold">
            <a href="#" class="px-6 py-4 border-b-2 border-stroke opacity-50 cursor-not-allowed flex items-center gap-3">
                <x-heroicon-o-chart-bar-square class="w-6 h-6" /> Overview
            </a>
            <a href="{{ route('admin.products.index') }}" wire:navigate class="px-6 py-4 border-b-2 border-stroke transition-colors flex items-center gap-3 {{ request()->routeIs('admin.products.*') ? 'bg-tertiary text-headline' : 'hover:bg-secondary hover:text-headline' }}">
                <x-heroicon-o-cube class="w-6 h-6" /> Manajemen Katalog
            </a>
            <a href="{{ route('admin.orders.index') }}" wire:navigate class="px-6 py-4 border-b-2 border-stroke transition-colors flex items-center gap-3 {{ request()->routeIs('admin.orders.*') ? 'bg-tertiary text-headline' : 'hover:bg-secondary hover:text-headline' }}">
                <x-heroicon-o-clipboard-document-check class="w-6 h-6" /> Pemrosesan Pesanan
            </a>
            <a href="{{ route('admin.payouts.index') }}" wire:navigate class="px-6 py-4 border-b-2 border-stroke transition-colors flex items-center gap-3 {{ request()->routeIs('admin.payouts.*') ? 'bg-tertiary text-headline' : 'hover:bg-secondary hover:text-headline' }}">
                <x-heroicon-o-banknotes class="w-6 h-6" /> Pencairan Afiliasi
            </a>
            <a href="{{ route('dashboard') }}" wire:navigate class="px-6 py-4 border-b-2 border-stroke hover:bg-secondary hover:text-headline transition-colors flex items-center gap-3 mt-auto">
                <x-heroicon-o-arrow-left-on-rectangle class="w-6 h-6" /> Keluar ke Portal Web
            </a>
        </nav>
    </aside>

    <!-- Main Content Wrapper -->
    <main class="flex-grow flex flex-col min-w-0">
        <!-- Top Navbar (Mobile) -->
        <header class="md:hidden bg-button-fomo border-b-4 border-stroke p-4 flex justify-between items-center text-headline sticky top-0 z-50">
            <div class="flex items-center gap-2">
                <x-heroicon-s-command-line class="w-6 h-6" />
                <h1 class="text-xl font-black uppercase tracking-tighter">KIRA ADMIN</h1>
            </div>
            <!-- Simple menu toggle just for show, in a real app would use Alpine -->
            <button class="focus:outline-none">
                <x-heroicon-o-bars-3 class="w-8 h-8" />
            </button>
        </header>

        <!-- Slot Content -->
        <div class="flex-grow p-6 md:p-10 bg-background overflow-x-hidden">
            {{ $slot }}
        </div>
    </main>

    <livewire:scripts />
</body>
</html>
