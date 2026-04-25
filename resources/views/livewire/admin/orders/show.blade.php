<div>
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('admin.orders.index') }}" wire:navigate class="bg-background text-headline p-3 border-4 border-stroke hover:bg-secondary transition-colors">
            <x-heroicon-s-arrow-left class="w-6 h-6" />
        </a>
        <div>
            <h2 class="text-4xl font-black text-headline uppercase tracking-tighter" style="-webkit-text-stroke: 1px #272343;">DETAIL PESANAN</h2>
            <p class="text-xl font-bold text-paragraph">#KIRA-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
        </div>
        
        <!-- Status Badge -->
        @php
            $statusColor = match($order->status) {
                'PENDING' => 'bg-button-fomo text-headline',
                'PAID' => 'bg-tertiary text-headline',
                'SHIPPED' => 'bg-orange-400 text-headline',
                'COMPLETED' => 'bg-green-400 text-headline',
                'DISPUTED' => 'bg-red-500 text-background',
                default => 'bg-background text-headline'
            };
        @endphp
        <div class="ml-auto {{ $statusColor }} border-4 border-stroke px-6 py-3 shadow-[4px_4px_0px_0px_rgba(39,35,67,1)]">
            <span class="font-black text-xl uppercase">{{ $order->status }}</span>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Kolom Kiri: Info Pesanan -->
        <div class="w-full lg:w-2/3 space-y-8">
            
            <!-- Info Pembeli -->
            <div class="bg-background border-4 border-stroke p-6 shadow-[8px_8px_0px_0px_rgba(39,35,67,1)]">
                <h3 class="text-2xl font-black text-headline uppercase border-b-4 border-stroke pb-2 mb-4">Informasi Operasi</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs font-bold text-paragraph uppercase">Pembeli</p>
                        <p class="text-lg font-black text-headline uppercase">{{ $order->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-paragraph uppercase">Email</p>
                        <p class="text-lg font-black text-headline">{{ $order->user->email }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-xs font-bold text-paragraph uppercase">Alamat Pengiriman</p>
                        <p class="text-lg font-bold text-headline">{{ $order->shipping_address }}</p>
                    </div>
                </div>
            </div>

            <!-- Item Pesanan -->
            <div class="bg-secondary border-4 border-stroke p-6 shadow-[8px_8px_0px_0px_rgba(39,35,67,1)]">
                <h3 class="text-2xl font-black text-headline uppercase border-b-4 border-stroke pb-2 mb-4">Objek Terakuisisi</h3>
                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex items-center gap-4 bg-background border-4 border-stroke p-4">
                            <div class="w-16 h-16 bg-tertiary border-2 border-stroke shrink-0">
                                <img src="{{ $item->variant->image_url ?? $item->variant->product->image_url }}" alt="" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-grow">
                                <p class="font-black text-headline uppercase text-lg line-clamp-1">{{ $item->variant->product->name }}</p>
                                <p class="text-sm font-bold text-paragraph uppercase">{{ $item->variant->variant_name }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-paragraph">{{ $item->quantity }}x</p>
                                <p class="font-black text-headline">Rp {{ number_format($item->price_at_time, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
        </div>

        <!-- Kolom Kanan: Aksi & Rincian Harga -->
        <div class="w-full lg:w-1/3 space-y-8">
            
            <!-- Rincian Harga -->
            <div class="bg-headline text-background border-4 border-stroke p-6 shadow-[8px_8px_0px_0px_#bae8e8]">
                <h3 class="text-xl font-black uppercase border-b-2 border-stroke pb-2 mb-4">Anggaran</h3>
                <div class="space-y-2 mb-4 font-bold">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Logistik</span>
                        <span>Rp {{ number_format($order->shipping_fee, 0, ',', '.') }}</span>
                    </div>
                </div>
                <div class="flex justify-between border-t-2 border-stroke pt-4 font-black text-2xl text-button-fomo">
                    <span>TOTAL</span>
                    <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Panel Aksi Eksekusi -->
            <div class="bg-background border-4 border-stroke p-6 shadow-[8px_8px_0px_0px_rgba(39,35,67,1)] sticky top-8">
                <h3 class="text-xl font-black text-headline uppercase border-b-4 border-stroke pb-2 mb-6">Konsol Aksi</h3>
                
                @if($order->status === 'PENDING')
                    <div class="mb-4 p-4 border-2 border-stroke bg-secondary text-sm font-bold">
                        Pesanan belum lunas. Tunggu verifikasi sistem pembayaran.
                    </div>
                    <button wire:click="markAsPaid" class="w-full bg-headline text-background font-black py-4 border-4 border-stroke shadow-[4px_4px_0px_0px_#bae8e8] hover:-translate-y-1 transition-transform flex justify-center items-center gap-2">
                        <x-heroicon-s-check-circle class="w-6 h-6" />
                        TANDAI LUNAS (BYPASS)
                    </button>
                @elseif($order->status === 'PAID')
                    <div class="mb-6">
                        <label class="block text-headline font-black uppercase mb-2">Input Nomor Resi (AWB)</label>
                        <input type="text" wire:model="awb" class="w-full bg-secondary border-4 border-stroke p-4 font-bold text-headline focus:outline-none focus:bg-background" placeholder="KIRA-EXP-12345">
                        @error('awb') <span class="text-button-fomo text-sm font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <button wire:click="markAsShipped" class="w-full bg-orange-400 text-headline font-black py-4 border-4 border-stroke shadow-[4px_4px_0px_0px_#272343] hover:-translate-y-1 transition-transform flex justify-center items-center gap-2">
                        <x-heroicon-s-truck class="w-6 h-6" />
                        EKSPEDISI DIMULAI
                    </button>
                @elseif($order->status === 'SHIPPED')
                    <div class="mb-6 p-4 border-4 border-stroke bg-tertiary">
                        <p class="text-xs font-bold text-paragraph uppercase">Nomor Resi Aktif</p>
                        <p class="text-xl font-black text-headline uppercase tracking-widest">{{ $order->awb_resi }}</p>
                    </div>
                    <button wire:click="markAsCompleted" class="w-full bg-green-400 text-headline font-black py-4 border-4 border-stroke shadow-[4px_4px_0px_0px_#272343] hover:-translate-y-1 transition-transform flex justify-center items-center gap-2">
                        <x-heroicon-s-flag class="w-6 h-6" />
                        MISI SELESAI
                    </button>
                @elseif($order->status === 'COMPLETED')
                    <div class="text-center p-6 border-4 border-stroke bg-background opacity-50">
                        <x-heroicon-o-lock-closed class="w-12 h-12 mx-auto mb-2" />
                        <p class="font-black uppercase">Siklus Tertutup</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
