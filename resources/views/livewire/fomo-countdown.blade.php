<div wire:poll.10s="refreshFomoState" class="w-full max-w-sm mx-auto">
    {{-- Card FOMO Premium Neo-Brutalism (Kebalikan Palet Normal untuk Menciptakan Kedaruratan) --}}
    <div class="card-premium bg-headline p-6 text-background border-4 border-stroke shadow-[6px_6px_0px_0px_rgba(255,216,3,1)] relative overflow-hidden group">
        
        {{-- Animasi Latar Belakang (Pulse Mengancam) --}}
        <div class="absolute -right-10 -top-10 w-32 h-32 bg-button-fomo rounded-full opacity-20 group-hover:scale-150 transition-transform duration-700 ease-in-out"></div>

        @if(!$isReleased && $countdownString)
            {{-- State 1: Belum Rilis (Countdown Aktif) --}}
            <div class="relative z-10 fomo-timer-container">
                <p class="text-tertiary font-bold mb-2 uppercase tracking-widest text-sm flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-button-fomo animate-ping"></span>
                    Rilis Dalam
                </p>
                {{-- Angka Digital Berdetak --}}
                <div class="text-5xl md:text-6xl font-black tracking-tighter text-button-fomo fomo-digits" style="text-shadow: 3px 3px 0 #272343;">
                    {{ $countdownString }}
                </div>
            </div>
        @else
            {{-- State 2: Sudah Rilis (Status Stok Perang) --}}
            <div class="relative z-10">
                <p class="text-tertiary font-bold mb-2 uppercase tracking-widest text-sm">Status Ketersediaan</p>
                <div class="text-2xl font-black {{ str_contains($scarcityAlert, 'HABIS') || str_contains($scarcityAlert, 'SOLD') ? 'text-red-400 animate-pulse' : 'text-button-fomo' }}">
                    {{ $scarcityAlert }}
                </div>
                
                @if(!str_contains($scarcityAlert, 'SOLD'))
                    <button class="mt-4 w-full bg-button-fomo text-headline font-black py-3 rounded-lg border-2 border-background hover:scale-105 active:scale-95 transition-transform shadow-[4px_4px_0px_0px_rgba(255,255,254,1)]">
                        AMANKAN SEKARANG ⚡
                    </button>
                @endif
            </div>
        @endif
    </div>

    {{-- Script GSAP untuk Interaksi Micro-Animation --}}
    @script
    <script>
        document.addEventListener('livewire:initialized', () => {
            // Efek detak jantung pada angka saat komponen baru dimuat atau di-refresh oleh Livewire
            Livewire.hook('morph.updated', () => {
                gsap.fromTo('.fomo-digits', 
                    { scale: 1.1, opacity: 0.5 },
                    { scale: 1, opacity: 1, duration: 0.4, ease: "back.out(2)" }
                );
            });
            
            // Animasi masuk (Entrance) untuk seluruh card dari bawah
            gsap.from('.fomo-timer-container', {
                y: 20,
                opacity: 0,
                duration: 0.6,
                ease: "power2.out"
            });
        });
    </script>
    @endscript
</div>
