<div class="w-full max-w-4xl mx-auto p-4 relative">
    {{-- Search Bar dengan Neo-Brutalism Style (Happy Hues Colors) --}}
    <div class="relative">
        <input 
            wire:model.live.debounce.300ms="search"
            type="text" 
            placeholder="Cari figur gacha impianmu (Min 2 huruf)..."
            class="w-full py-4 px-6 text-headline bg-background border-4 border-stroke rounded-xl shadow-[6px_6px_0px_0px_rgba(39,35,67,1)] focus:outline-none focus:translate-y-1 focus:shadow-[2px_2px_0px_0px_rgba(39,35,67,1)] transition-all font-bold text-lg"
        >
        <div class="absolute right-4 top-4 text-stroke">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>

    {{-- Loading Indicator (Otomatis ditangani oleh state Livewire) --}}
    <div wire:loading class="absolute right-16 top-5">
        <span class="animate-spin h-6 w-6 border-4 border-button-fomo border-t-stroke rounded-full inline-block"></span>
    </div>

    {{-- Hasil Pencarian Reaktif --}}
    @if(strlen($search) >= 2)
        <div class="mt-6 bg-secondary border-4 border-stroke rounded-xl p-6 shadow-[8px_8px_0px_0px_rgba(39,35,67,1)]">
            @if(count($products) > 0)
                <h3 class="text-headline font-black mb-4">Mungkin ini yang kamu cari:</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($products as $product)
                        <div class="card-premium p-4 flex justify-between items-center bg-background cursor-pointer hover:bg-tertiary transition-colors">
                            <div>
                                <h4 class="font-bold text-headline">{{ $product->name }}</h4>
                                <p class="text-sm text-paragraph truncate w-48">{{ $product->description ?? 'Figure eksklusif' }}</p>
                            </div>
                            <div>
                                @if($product->is_blindbox)
                                    <span class="badge-community bg-button-fomo text-stroke">BLINDBOX</span>
                                @else
                                    <span class="badge-community bg-tertiary text-stroke">STANDAR</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-headline font-bold text-xl">Waduh, Gacha figur "{{ $search }}" tidak ditemukan! 😭</p>
                </div>
            @endif
        </div>
    @endif
</div>
