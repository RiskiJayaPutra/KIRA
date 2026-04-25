<div class="container mx-auto px-4 py-12 max-w-7xl">
    <div class="mb-10">
        <h1 class="text-5xl font-black text-headline uppercase tracking-tighter" style="-webkit-text-stroke: 1px #272343;">CHECKOUT.</h1>
        <div class="flex items-center gap-4 mt-4 text-headline font-black">
            <span class="bg-button-fomo px-4 py-2 border-2 border-stroke shadow-[4px_4px_0px_0px_#272343]">1. LOGISTIK</span>
            <x-heroicon-s-chevron-right class="w-6 h-6 text-stroke opacity-50" />
            <span class="bg-background px-4 py-2 border-2 border-stroke opacity-50">2. PEMBAYARAN</span>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- Kiri: Pilih Alamat -->
        <div class="w-full lg:w-2/3">
            <div class="bg-background border-4 border-stroke p-8 shadow-[8px_8px_0px_0px_rgba(39,35,67,1)] h-full">
                <div class="flex justify-between items-end mb-6 border-b-4 border-stroke pb-4">
                    <h3 class="text-3xl font-black text-headline uppercase">Titik Pendaratan</h3>
                    <a href="{{ route('address.book') }}" target="_blank" class="font-bold text-button-fomo hover:text-headline hover:underline transition-colors">
                        + Kelola Alamat Buku
                    </a>
                </div>

                @error('selectedAddressId')
                    <div class="bg-button-fomo border-4 border-stroke p-4 mb-6 font-black text-headline">
                        ⚠️ {{ $message }}
                    </div>
                @enderror

                @if(count($addresses) > 0)
                    <div class="space-y-4">
                        @foreach($addresses as $address)
                            <label class="flex gap-4 p-5 border-4 cursor-pointer transition-all {{ $selectedAddressId == $address->id ? 'border-tertiary shadow-[4px_4px_0px_0px_#bae8e8] bg-secondary' : 'border-stroke bg-background opacity-70 hover:opacity-100' }}">
                                <div class="pt-1">
                                    <input type="radio" wire:model="selectedAddressId" value="{{ $address->id }}" class="w-6 h-6 border-4 border-stroke text-tertiary focus:ring-0 cursor-pointer">
                                </div>
                                <div class="flex-grow">
                                    <div class="flex justify-between items-start mb-2">
                                        <h4 class="text-xl font-black text-headline uppercase">
                                            {{ $address->recipient_name }}
                                            @if($address->is_primary)
                                                <span class="ml-2 text-xs bg-headline text-background px-2 py-1 align-middle">UTAMA</span>
                                            @endif
                                        </h4>
                                        <span class="font-bold text-paragraph">{{ $address->phone_number }}</span>
                                    </div>
                                    <p class="text-paragraph font-bold leading-tight">{{ $address->full_address }}</p>
                                    <p class="text-paragraph font-bold leading-tight">{{ $address->city }}, {{ $address->postal_code }}</p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                @else
                    <div class="bg-secondary border-4 border-stroke p-8 text-center">
                        <p class="text-xl font-bold text-headline mb-4 uppercase">Radar Tidak Menemukan Titik Pendaratan</p>
                        <a href="{{ route('address.book') }}" class="bg-button-fomo text-headline font-black px-6 py-3 border-4 border-stroke shadow-[4px_4px_0px_0px_#272343] inline-block hover:-translate-y-1 transition-transform">
                            TAMBAH ALAMAT SEKARANG
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Kanan: Ringkasan -->
        <div class="w-full lg:w-1/3">
            <div class="bg-secondary border-4 border-stroke p-8 sticky top-8 shadow-[8px_8px_0px_0px_rgba(39,35,67,1)]">
                <h3 class="text-2xl font-black text-headline uppercase border-b-4 border-stroke pb-4 mb-6">Radar Pesanan</h3>
                
                <!-- Items list -->
                <div class="space-y-4 mb-6 max-h-60 overflow-y-auto pr-2 border-b-4 border-stroke pb-6">
                    @foreach($cartItems as $item)
                        <div class="flex justify-between text-headline font-bold">
                            <div class="flex flex-col">
                                <span class="uppercase line-clamp-1">{{ $item->variant->product->name }}</span>
                                <span class="text-sm opacity-70">{{ $item->quantity }}x {{ $item->variant->variant_name }}</span>
                            </div>
                            <span class="whitespace-nowrap">Rp {{ number_format($item->quantity * $item->variant->price, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>

                <!-- Totals -->
                <div class="space-y-2 mb-8 font-bold text-headline">
                    <div class="flex justify-between">
                        <span>Subtotal Barang</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Biaya Ekspedisi KIRA</span>
                        <span>Rp {{ number_format($shippingFee, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-end pt-4 border-t-4 border-stroke mt-4">
                        <span class="text-xl font-black uppercase">Total Akhir</span>
                        <span class="text-3xl font-black text-button-fomo" style="-webkit-text-stroke: 1px #272343;">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Action -->
                <button wire:click="proceedToPayment" class="w-full bg-headline text-background font-black text-2xl py-5 border-4 border-stroke hover:-translate-y-1 shadow-[6px_6px_0px_0px_#ffd803] active:translate-y-0 active:shadow-none transition-all flex justify-center items-center gap-2">
                    PROCEED TO PAYMENT
                </button>
            </div>
        </div>

    </div>
</div>
