<div class="container mx-auto px-4 py-12 max-w-7xl">
    <div class="flex flex-col lg:flex-row gap-12">
        
        <!-- Left: Product Image (Sticky) -->
        <div class="w-full lg:w-1/2">
            <div class="sticky top-12 bg-secondary border-8 border-stroke p-4 shadow-[12px_12px_0px_0px_rgba(39,35,67,1)] relative group">
                <!-- Badges -->
                <div class="absolute top-8 left-8 z-10 flex flex-col gap-3">
                    @if($product->is_blindbox)
                        <span class="bg-button-fomo text-headline font-black text-lg px-4 py-2 border-4 border-stroke shadow-[4px_4px_0px_0px_#272343] rotate-[-5deg]">BLINDBOX SERIES</span>
                    @else
                        <span class="bg-tertiary text-headline font-black text-lg px-4 py-2 border-4 border-stroke shadow-[4px_4px_0px_0px_#272343] rotate-[5deg]">PREMIUM FIGURE</span>
                    @endif
                    
                    @if(now()->diffInDays($product->release_date) <= 7)
                        <span class="bg-headline text-background font-black text-lg px-4 py-2 border-4 border-stroke shadow-[4px_4px_0px_0px_#ffd803] animate-pulse">NEW DROP</span>
                    @endif
                </div>

                <!-- Main Image -->
                <div class="aspect-[3/4] bg-background border-4 border-stroke overflow-hidden relative">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                </div>
            </div>
        </div>

        <!-- Right: Product Details -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center py-8">
            <h1 class="text-5xl md:text-7xl font-black text-headline uppercase leading-none mb-6 tracking-tighter" style="-webkit-text-stroke: 2px #272343; color: transparent;">
                {{ $product->name }}
            </h1>

            <div class="bg-background border-l-8 border-tertiary pl-6 py-2 mb-8">
                <p class="text-paragraph text-xl font-bold leading-relaxed">
                    {{ $product->description }}
                </p>
            </div>

            <!-- Pricing Area -->
            <div class="mb-10">
                @php
                    $basePrice = $product->variants->min('price');
                @endphp
                <p class="text-headline font-black text-2xl uppercase opacity-50 mb-1">Base Price</p>
                <p class="text-6xl font-black text-headline mb-2" style="text-shadow: 4px 4px 0 #ffd803;">
                    Rp {{ number_format($basePrice, 0, ',', '.') }}
                </p>
                <p class="text-paragraph font-bold">Belum termasuk ongkos kirim. Harga dapat bervariasi bergantung varian.</p>
            </div>

            <!-- Variant Section -->
            <div class="mb-10">
                <h3 class="text-3xl font-black text-headline uppercase mb-4 border-b-4 border-stroke pb-2">Availability & Drop Rates</h3>
                
                @if($product->is_blindbox)
                    <div class="bg-headline text-background p-6 border-4 border-stroke shadow-[8px_8px_0px_0px_#ffd803] mb-6">
                        <p class="font-bold text-lg mb-4">⚠️ ATTENTION: GACHA MECHANICS</p>
                        <p class="opacity-90 font-medium">Anda hanya dapat membeli "Regular Drop". Karakter yang dikirim akan dipilih secara acak oleh sistem RNG kami. Dapatkan peluang memenangkan Secret Variant!</p>
                    </div>

                    <div class="space-y-4">
                        @foreach($product->variants as $variant)
                            <div class="flex items-center justify-between p-4 border-4 {{ Str::contains($variant->variant_name, 'SECRET') ? 'border-button-fomo bg-background' : 'border-stroke bg-secondary' }}">
                                <div>
                                    <h4 class="text-xl font-black text-headline uppercase {{ Str::contains($variant->variant_name, 'SECRET') ? 'text-button-fomo' : '' }}">{{ $variant->variant_name }}</h4>
                                    <p class="text-sm font-bold text-paragraph">Drop Rate: <span class="text-headline font-black text-lg">{{ $variant->drop_rate }}%</span></p>
                                </div>
                                <div class="text-right">
                                    <span class="block text-sm font-bold text-paragraph">Est. Value</span>
                                    <span class="text-xl font-black text-headline">Rp {{ number_format($variant->price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- For normal figures -->
                    <div class="space-y-4">
                        @foreach($product->variants as $variant)
                            <label class="flex items-center justify-between p-4 border-4 cursor-pointer transition-all {{ $selectedVariant === $variant->id ? 'border-tertiary shadow-[4px_4px_0px_0px_#bae8e8] bg-background' : 'border-stroke bg-secondary opacity-70 hover:opacity-100' }}">
                                <div class="flex items-center gap-4">
                                    <input type="radio" wire:model="selectedVariant" wire:click="selectVariant({{ $variant->id }})" value="{{ $variant->id }}" class="w-6 h-6 border-4 border-stroke text-tertiary focus:ring-0 cursor-pointer">
                                    <div>
                                        <h4 class="text-xl font-black text-headline uppercase">{{ $variant->variant_name }}</h4>
                                        <p class="text-sm font-bold text-paragraph">Stock: {{ $variant->stock }} units</p>
                                    </div>
                                </div>
                                <div class="text-xl font-black text-headline">
                                    Rp {{ number_format($variant->price, 0, ',', '.') }}
                                </div>
                            </label>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Call to Actions -->
            <div class="flex flex-col gap-4">
                <!-- Add to Cart (Fase 31) -->
                <button wire:click="addToCart" class="w-full bg-headline text-background font-black text-3xl py-6 border-4 border-stroke shadow-[8px_8px_0px_0px_#ffd803] hover:-translate-y-2 hover:shadow-[12px_12px_0px_0px_#ffd803] active:translate-y-0 active:shadow-none transition-all flex justify-center items-center gap-4">
                    <span>ADD TO CART</span>
                    <span class="text-4xl">🛒</span>
                </button>
                
                <!-- Add to Wishlist (Fase 30) -->
                @if($selectedVariant)
                    <livewire:catalog.wishlist-button :variant-id="$selectedVariant" style="full" wire:key="wishlist-detail-{{ $selectedVariant }}" />
                @endif
            </div>
            
        </div>
    </div>
</div>
