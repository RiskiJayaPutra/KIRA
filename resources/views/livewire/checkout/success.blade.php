<div class="container mx-auto px-4 py-16 max-w-4xl">
    <div class="bg-background border-8 border-stroke p-8 md:p-16 shadow-[16px_16px_0px_0px_rgba(39,35,67,1)] relative overflow-hidden">
        
        <!-- Decorative Elements -->
        <div class="absolute -top-10 -left-10 w-40 h-40 bg-button-fomo border-4 border-stroke rotate-12 opacity-50 z-0"></div>
        <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-tertiary border-4 border-stroke -rotate-12 opacity-50 z-0"></div>
        
        <div class="relative z-10 flex flex-col items-center text-center">
            
            <!-- Success Icon -->
            <div class="w-32 h-32 bg-button-fomo border-4 border-stroke flex items-center justify-center rounded-full mb-8 shadow-[8px_8px_0px_0px_#272343] animate-[bounce_2s_infinite]">
                <x-heroicon-s-check-badge class="w-20 h-20 text-headline" />
            </div>

            <!-- Headlines -->
            <h1 class="text-5xl md:text-7xl font-black text-headline uppercase tracking-tighter mb-4" style="-webkit-text-stroke: 1px #272343;">
                MISSION ACCOMPLISHED
            </h1>
            <p class="text-xl md:text-2xl font-bold text-paragraph max-w-2xl mx-auto mb-10">
                Pendaratan sukses! Pembayaran Anda telah kami terima dan pasukan logistik KIRA sedang mempersiapkan barang incaran Anda.
            </p>

            <!-- Order Intelligence Box -->
            <div class="w-full bg-secondary border-4 border-stroke p-6 mb-10 text-left">
                <h3 class="text-2xl font-black text-headline border-b-4 border-stroke pb-2 mb-4 uppercase flex items-center gap-2">
                    <x-heroicon-o-document-text class="w-8 h-8" />
                    Dokumen Operasi
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm font-bold text-paragraph uppercase">Kode Misi (Order ID)</p>
                        <p class="text-2xl font-black text-headline">#KIRA-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-paragraph uppercase">Status Saat Ini</p>
                        <div class="inline-block bg-tertiary border-2 border-stroke px-3 py-1 font-black text-headline uppercase text-lg mt-1">
                            {{ $order->status }}
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-paragraph uppercase">Waktu Eksekusi</p>
                        <p class="text-lg font-bold text-headline">{{ $order->created_at->format('d M Y - H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-paragraph uppercase">Total Anggaran</p>
                        <p class="text-2xl font-black text-button-fomo" style="-webkit-text-stroke: 1px #272343;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="w-full flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('dashboard') }}" class="group flex-1 bg-headline text-background font-black text-xl py-5 border-4 border-stroke shadow-[6px_6px_0px_0px_#bae8e8] hover:-translate-y-1 active:translate-y-0 active:shadow-none transition-all flex justify-center items-center gap-2">
                    <x-heroicon-o-radar class="w-8 h-8 group-hover:animate-ping" />
                    <span>PANTAU RADAR</span>
                </a>
                
                <a href="{{ route('catalog') }}" wire:navigate class="group flex-1 bg-button-fomo text-headline font-black text-xl py-5 border-4 border-stroke shadow-[6px_6px_0px_0px_#272343] hover:-translate-y-1 active:translate-y-0 active:shadow-none transition-all flex justify-center items-center gap-2">
                    <span>KEMBALI KE MEDAN</span>
                    <x-heroicon-o-arrow-right class="w-8 h-8 group-hover:translate-x-2 transition-transform" />
                </a>
            </div>

        </div>
    </div>
</div>
