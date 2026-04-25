<div>
    <!-- Backdrop -->
    @if($isOpen)
        <div class="fixed inset-0 bg-background/80 backdrop-blur-sm z-40" wire:click="closeCart"></div>
    @endif

    <!-- Drawer -->
    <div class="fixed top-0 right-0 h-full w-full md:w-[450px] bg-background border-l-8 border-stroke z-50 transform transition-transform duration-500 ease-in-out {{ $isOpen ? 'translate-x-0' : 'translate-x-full' }} flex flex-col shadow-[-16px_0_0_0_#ffd803]">
        
        <!-- Header -->
        <div class="p-6 border-b-4 border-stroke flex justify-between items-center bg-headline text-background">
            <h2 class="text-3xl font-black uppercase tracking-tighter">THE CART.</h2>
            <button wire:click="closeCart" class="text-headline hover:scale-110 transition-transform"><x-heroicon-o-x-mark class="w-8 h-8" /></button>
        </div>

        <!-- Items Area -->
        <div class="flex-grow overflow-y-auto p-6 space-y-6">
            @if(count($cartItems) > 0)
                @foreach($cartItems as $item)
                    <div class="flex gap-4 border-4 border-stroke bg-secondary relative group">
                        
                        <button wire:click="removeItem({{ $item->id }})" class="absolute -top-3 -right-3 bg-tertiary text-headline w-8 h-8 rounded-full border-2 border-stroke font-black opacity-0 group-hover:opacity-100 transition-opacity flex justify-center items-center">
                            <x-heroicon-s-x-mark class="w-5 h-5 hover:scale-110 transition-transform" />
                        </button>

                        <!-- Image -->
                        <div class="w-24 bg-background border-r-4 border-stroke shrink-0">
                            <img src="{{ $item->variant->image_url ?? $item->variant->product->image_url }}" alt="{{ $item->variant->product->name }}" class="w-full h-full object-cover">
                        </div>

                        <!-- Details -->
                        <div class="py-2 pr-2 flex-grow flex flex-col justify-between">
                            <div>
                                <h4 class="font-black text-headline uppercase text-sm line-clamp-1">{{ $item->variant->product->name }}</h4>
                                <p class="text-xs font-bold text-paragraph uppercase">{{ $item->variant->variant_name }}</p>
                            </div>
                            
                            <div class="flex justify-between items-end mt-2">
                                <div class="font-black text-headline">
                                    Rp {{ number_format($item->variant->price, 0, ',', '.') }}
                                </div>
                                
                                <!-- Quantity Controls -->
                                <div class="flex items-center border-2 border-stroke bg-background">
                                    <button wire:click="decrementQuantity({{ $item->id }})" class="px-2 font-black hover:bg-stroke hover:text-background transition-colors">-</button>
                                    <span class="px-2 font-bold text-sm border-x-2 border-stroke">{{ $item->quantity }}</span>
                                    <button wire:click="incrementQuantity({{ $item->id }})" class="px-2 font-black hover:bg-stroke hover:text-background transition-colors">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="h-full flex flex-col justify-center items-center text-center opacity-50">
                    <x-heroicon-o-shopping-bag class="w-24 h-24 mb-4 text-stroke opacity-30 mx-auto" />
                    <p class="font-black text-xl uppercase">Keranjang Kosong</p>
                    <p class="font-bold text-paragraph">Target belum ditentukan.</p>
                </div>
            @endif
        </div>

        <!-- Footer / Checkout Area -->
        <div class="p-6 border-t-4 border-stroke bg-background">
            <div class="flex justify-between items-center mb-6">
                <span class="font-black text-headline uppercase text-xl">Subtotal</span>
                <span class="font-black text-headline text-3xl" style="text-shadow: 2px 2px 0 #ffd803;">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>
            <p class="text-sm font-bold text-paragraph mb-4">Belum termasuk ongkos kirim. Pengiriman akan dihitung di fase selanjutnya.</p>
            @if(count($cartItems) > 0)
                <a href="{{ route('checkout.delivery') }}" wire:navigate class="group w-full bg-button-fomo text-headline font-black text-2xl py-5 border-4 border-stroke hover:-translate-y-1 shadow-[6px_6px_0px_0px_#272343] active:translate-y-0 active:shadow-none transition-all flex justify-center items-center gap-4">
                    <span>CHECKOUT</span>
                    <x-heroicon-s-bolt class="w-8 h-8 group-hover:translate-x-2 transition-transform" />
                </a>
            @else
                <button disabled class="w-full bg-secondary text-paragraph font-black text-2xl py-5 border-4 border-stroke opacity-50 cursor-not-allowed transition-all flex justify-center items-center gap-4">
                    <span>CHECKOUT</span>
                </button>
            @endif
        </div>
    </div>
</div>
