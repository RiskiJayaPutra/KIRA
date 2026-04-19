<div class="container mx-auto px-4 py-12 max-w-6xl">
    <div class="mb-10">
        <h1 class="text-5xl font-black text-headline uppercase" style="-webkit-text-stroke: 1px #272343;">COMMAND CENTER.</h1>
        <p class="text-paragraph text-xl font-bold mt-2">Pusat kendali akun kolektor Anda.</p>
    </div>

    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar -->
        <x-profile-sidebar />

        <!-- Main Content -->
        <div class="w-full md:w-3/4">
            <div class="bg-tertiary border-4 border-stroke p-8 mb-8 shadow-[8px_8px_0px_0px_rgba(39,35,67,1)] relative overflow-hidden">
                <!-- Decorative -->
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-button-fomo rounded-full border-4 border-stroke opacity-50"></div>
                
                <h3 class="text-3xl font-black text-headline mb-2 relative z-10">KIRA POINTS</h3>
                <div class="text-6xl font-black text-background mb-4 relative z-10" style="text-shadow: 4px 4px 0 #272343;">
                    {{ number_format(auth()->user()->kira_points ?? 0) }} <span class="text-2xl">KP</span>
                </div>
                <p class="text-headline font-bold relative z-10">Kumpulkan poin untuk mendapatkan potongan harga eksklusif di drop selanjutnya.</p>
            </div>

            <div class="bg-background border-4 border-stroke p-8 shadow-[8px_8px_0px_0px_rgba(39,35,67,1)]">
                <h3 class="text-2xl font-black text-headline mb-4 uppercase">Recent Drops</h3>
                <p class="text-paragraph font-bold">Anda belum memesan item apapun. Segera buru koleksi terbaru di Katalog!</p>
                <a href="/" wire:navigate class="inline-block mt-4 bg-headline text-background font-black px-6 py-3 border-2 border-stroke hover:-translate-y-1 hover:shadow-[4px_4px_0px_0px_#ffd803] transition-all">
                    EXPLORE CATALOG
                </a>
            </div>
        </div>
    </div>
</div>
