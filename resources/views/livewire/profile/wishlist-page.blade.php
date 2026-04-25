<div class="container mx-auto px-4 py-12 max-w-6xl">
    <div class="mb-10">
        <h1 class="text-5xl font-black text-headline uppercase" style="-webkit-text-stroke: 1px #272343;">WISHLIST.</h1>
        <p class="text-paragraph text-xl font-bold mt-2">Daftar incaran rahasia Anda.</p>
    </div>

    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar -->
        <x-profile-sidebar />

        <!-- Main Content -->
        <div class="w-full md:w-3/4">
            
            <div class="bg-background border-4 border-stroke p-8 shadow-[8px_8px_0px_0px_rgba(39,35,67,1)] min-h-[500px]">
                <h3 class="text-3xl font-black text-headline mb-8 uppercase border-b-4 border-stroke pb-4">TARGET ACQUIRED</h3>
                
                @if($wishlists->count() > 0)
                    <div class="flex flex-col gap-6">
                        @foreach($wishlists as $item)
                            <!-- Wishlist Item Card -->
                            <div class="flex flex-col sm:flex-row border-4 border-stroke bg-secondary overflow-hidden group">
                                <!-- Image -->
                                <div class="w-full sm:w-1/4 aspect-square sm:aspect-auto sm:h-32 bg-background border-b-4 sm:border-b-0 sm:border-r-4 border-stroke shrink-0 relative">
                                    <img src="{{ $item->variant->image_url ?? $item->variant->product->image_url }}" alt="{{ $item->variant->product->name }}" class="w-full h-full object-cover">
                                </div>
                                
                                <!-- Details -->
                                <div class="p-4 flex-grow flex flex-col justify-between">
                                    <div>
                                        <a href="{{ route('product.detail', $item->variant->product->slug) }}" wire:navigate class="text-xl font-black text-headline hover:text-button-fomo transition-colors uppercase line-clamp-1">
                                            {{ $item->variant->product->name }}
                                        </a>
                                        <p class="text-sm font-bold text-paragraph mb-2 uppercase">{{ $item->variant->variant_name }}</p>
                                    </div>
                                    <div class="text-2xl font-black text-headline">
                                        Rp {{ number_format($item->variant->price, 0, ',', '.') }}
                                    </div>
                                </div>
                                
                                <!-- Actions -->
                                <div class="w-full sm:w-1/5 flex sm:flex-col border-t-4 sm:border-t-0 sm:border-l-4 border-stroke shrink-0">
                                    <!-- Remove Button -->
                                    <button wire:click="removeWishlist({{ $item->id }})" class="group/btn flex-1 bg-tertiary text-headline font-black p-2 hover:bg-background transition-colors flex justify-center items-center gap-2 border-r-4 sm:border-r-0 sm:border-b-4 border-stroke">
                                        <x-heroicon-o-trash class="w-7 h-7 group-hover/btn:scale-110 transition-transform" />
                                        <span class="sm:hidden">HAPUS</span>
                                    </button>
                                    <!-- View/Cart Button -->
                                    <a href="{{ route('product.detail', $item->variant->product->slug) }}" wire:navigate class="group/btn flex-1 bg-button-fomo text-headline font-black p-2 hover:bg-headline hover:text-button-fomo transition-colors flex justify-center items-center gap-2">
                                        <x-heroicon-o-eye class="w-7 h-7 group-hover/btn:scale-110 transition-transform" />
                                        <span class="sm:hidden">LIHAT</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <x-heroicon-o-sparkles class="w-24 h-24 mb-4 text-stroke opacity-30 mx-auto" />
                        <h4 class="text-2xl font-black text-headline uppercase mb-2">Radar Kosong</h4>
                        <p class="text-paragraph font-bold mb-6">Belum ada target incaran di daftar wishlist Anda.</p>
                        <a href="{{ route('catalog') }}" wire:navigate class="bg-button-fomo text-headline font-black px-8 py-4 border-4 border-stroke shadow-[4px_4px_0px_0px_#272343] hover:-translate-y-1 hover:shadow-[6px_6px_0px_0px_#272343] transition-all inline-block">
                            BURU SEKARANG
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
