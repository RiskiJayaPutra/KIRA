<div class="container mx-auto px-4 py-12 max-w-7xl">
    
    <!-- Header / Hero Section -->
    <div class="mb-12 bg-headline border-4 border-stroke p-8 md:p-16 relative overflow-hidden shadow-[8px_8px_0px_0px_#ffd803]">
        <!-- Decorative bg -->
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-transparent border-8 border-button-fomo rounded-full opacity-50 gsap-spin"></div>
        <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-tertiary border-4 border-stroke rotate-12 opacity-80"></div>
        
        <h1 class="text-6xl md:text-8xl font-black text-background uppercase leading-none z-10 relative tracking-tighter" style="text-shadow: 6px 6px 0px #272343;">
            THE<br>ARMORY.
        </h1>
        <p class="text-xl md:text-2xl text-background font-bold mt-4 z-10 relative max-w-2xl">
            Eksplorasi koleksi blindbox dan premium figure kurasi tertinggi. Jangan sampai kehabisan.
        </p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- Sidebar Filters -->
        <div class="w-full lg:w-1/4">
            <div class="bg-background border-4 border-stroke p-6 sticky top-8 shadow-[4px_4px_0px_0px_rgba(39,35,67,1)]">
                <h3 class="text-2xl font-black text-headline uppercase mb-6 border-b-4 border-stroke pb-2">Filter</h3>

                <!-- Search -->
                <div class="mb-6">
                    <label class="block font-bold text-headline uppercase mb-2">Search Target</label>
                    <input wire:model.live.debounce.500ms="search" type="text" placeholder="Type here..." class="w-full bg-background border-4 border-stroke rounded-none px-4 py-3 font-bold focus:outline-none focus:-translate-y-1 transition-all">
                </div>

                <!-- Category -->
                <div class="mb-6">
                    <label class="block font-bold text-headline uppercase mb-2">Category</label>
                    <div class="space-y-3">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input wire:model.live="category" type="radio" value="all" class="w-6 h-6 border-4 border-stroke rounded-none text-headline focus:ring-0 checked:bg-button-fomo">
                            <span class="font-bold text-lg group-hover:text-button-fomo transition-colors">Semua Koleksi</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input wire:model.live="category" type="radio" value="blindbox" class="w-6 h-6 border-4 border-stroke rounded-none text-headline focus:ring-0 checked:bg-button-fomo">
                            <span class="font-bold text-lg group-hover:text-button-fomo transition-colors">Blindbox Saja</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input wire:model.live="category" type="radio" value="figure" class="w-6 h-6 border-4 border-stroke rounded-none text-headline focus:ring-0 checked:bg-button-fomo">
                            <span class="font-bold text-lg group-hover:text-button-fomo transition-colors">Premium Figures</span>
                        </label>
                    </div>
                </div>

                <!-- Sorting -->
                <div class="mb-6">
                    <label class="block font-bold text-headline uppercase mb-2">Sort Order</label>
                    <select wire:model.live="sort" class="w-full bg-background border-4 border-stroke rounded-none px-4 py-3 font-bold appearance-none cursor-pointer focus:outline-none focus:-translate-y-1 transition-all">
                        <option value="newest">Paling Baru Rilis</option>
                        <option value="price_low">Harga: Rendah ke Tinggi</option>
                        <option value="price_high">Harga: Tinggi ke Rendah</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="w-full lg:w-3/4">
            
            <div class="flex justify-between items-end mb-6">
                <h2 class="text-3xl font-black text-headline uppercase">Results</h2>
                <div wire:loading class="text-button-fomo font-black uppercase animate-pulse">
                    Scanning...
                </div>
            </div>

            @if($products->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                    @foreach($products as $product)
                        @php
                            $basePrice = $product->variants->min('price');
                        @endphp
                        
                        <!-- Product Card -->
                        <div class="group bg-background border-4 border-stroke flex flex-col h-full hover:-translate-y-2 hover:shadow-[8px_8px_0px_0px_#272343] transition-all duration-300 relative">
                            
                            <!-- Badges -->
                            <div class="absolute top-4 left-4 z-10 flex flex-col gap-2">
                                @if($product->is_blindbox)
                                    <span class="bg-button-fomo text-headline font-black text-sm px-3 py-1 border-2 border-stroke shadow-[2px_2px_0px_0px_#272343]">BLINDBOX</span>
                                @else
                                    <span class="bg-tertiary text-headline font-black text-sm px-3 py-1 border-2 border-stroke shadow-[2px_2px_0px_0px_#272343]">FIGURE</span>
                                @endif
                                
                                @if(now()->diffInDays($product->release_date) <= 7)
                                    <span class="bg-headline text-background font-black text-sm px-3 py-1 border-2 border-stroke shadow-[2px_2px_0px_0px_#ffd803] animate-pulse">NEW DROP</span>
                                @endif
                            </div>

                            <!-- Image -->
                            <div class="aspect-[4/5] border-b-4 border-stroke overflow-hidden bg-secondary relative">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                
                                <!-- Hover Quick Actions -->
                                <div class="absolute inset-0 bg-headline/80 flex flex-col justify-center items-center gap-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <a href="{{ route('product.detail', $product->slug) }}" wire:navigate class="bg-button-fomo text-headline font-black px-6 py-3 border-4 border-stroke hover:scale-105 transition-transform w-3/4 text-center block">
                                        QUICK VIEW
                                    </a>
                                    <livewire:catalog.wishlist-button :product-id="$product->id" style="grid" wire:key="wishlist-grid-{{ $product->id }}" />
                                </div>
                            </div>

                            <!-- Details -->
                            <div class="p-5 flex flex-col flex-grow bg-background">
                                <h3 class="text-xl font-black text-headline leading-tight mb-2 uppercase line-clamp-2">{{ $product->name }}</h3>
                                <p class="text-paragraph font-bold text-sm mb-4 line-clamp-2 flex-grow">{{ $product->description }}</p>
                                
                                <div class="mt-auto pt-4 border-t-4 border-stroke flex justify-between items-center">
                                    <div>
                                        <span class="text-sm font-bold text-paragraph block">Start from</span>
                                        <span class="text-2xl font-black text-headline">Rp {{ number_format($basePrice, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-12 brutal-pagination">
                    {{ $products->links() }}
                </div>
            @else
                <div class="bg-secondary border-4 border-stroke p-16 text-center shadow-[8px_8px_0px_0px_rgba(39,35,67,1)]">
                    <h3 class="text-4xl font-black text-headline mb-4 uppercase">Target Lost</h3>
                    <p class="text-xl font-bold text-paragraph">Tidak ada produk yang cocok dengan radar pencarian Anda.</p>
                    <button wire:click="$set('search', '')" class="mt-8 bg-button-fomo text-headline font-black px-8 py-4 border-4 border-stroke hover:-translate-y-1 transition-all">
                        RESET RADAR
                    </button>
                </div>
            @endif

        </div>
    </div>
</div>

<!-- Add simple GSAP animation for decorative element -->
<script>
    document.addEventListener('livewire:navigated', () => {
        if(typeof gsap !== 'undefined') {
            gsap.to('.gsap-spin', { rotation: 360, duration: 20, repeat: -1, ease: "linear" });
        }
    });
</script>

<style>
/* Custom styling for Laravel pagination to fit Neo-Brutalism */
.brutal-pagination nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.brutal-pagination span, .brutal-pagination a {
    font-weight: 900;
    border: 4px solid #272343 !important;
    color: #272343;
    text-transform: uppercase;
}
.brutal-pagination .active span {
    background-color: #ffd803 !important;
    color: #272343 !important;
}
</style>
