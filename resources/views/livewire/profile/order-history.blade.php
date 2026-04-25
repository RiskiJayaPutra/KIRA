<div class="container mx-auto px-4 py-12 max-w-6xl">
    <div class="mb-10">
        <h1 class="text-5xl font-black text-headline uppercase" style="-webkit-text-stroke: 1px #272343;">ORDER HISTORY.</h1>
        <p class="text-paragraph text-xl font-bold mt-2">Pusat pemantauan logistik pesanan Anda.</p>
    </div>

    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar -->
        <x-profile-sidebar />

        <!-- Main Content -->
        <div class="w-full md:w-3/4">
            
            <div class="bg-background border-4 border-stroke p-8 shadow-[8px_8px_0px_0px_rgba(39,35,67,1)] min-h-[500px]">
                <h3 class="text-3xl font-black text-headline mb-8 uppercase border-b-4 border-stroke pb-4">Dokumen Ekspedisi</h3>
                
                @if($orders->count() > 0)
                    <div class="space-y-8">
                        @foreach($orders as $order)
                            <div class="border-4 border-stroke bg-secondary overflow-hidden">
                                <!-- Header Panel -->
                                <div class="bg-headline text-background p-4 flex flex-col md:flex-row justify-between items-start md:items-center border-b-4 border-stroke gap-4">
                                    <div>
                                        <p class="text-sm font-bold opacity-80 uppercase">Order ID</p>
                                        <p class="text-xl font-black">#KIRA-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold opacity-80 uppercase">Tanggal</p>
                                        <p class="text-xl font-black">{{ $order->created_at->format('d M Y') }}</p>
                                    </div>
                                    <div class="text-right w-full md:w-auto flex flex-row md:flex-col justify-between md:justify-end items-center md:items-end">
                                        <p class="text-sm font-bold opacity-80 uppercase">Total</p>
                                        <p class="text-xl font-black text-button-fomo" style="-webkit-text-stroke: 1px #272343;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                <!-- Body Panel -->
                                <div class="p-6">
                                    <div class="flex justify-between items-center mb-6">
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-paragraph uppercase">Status:</span>
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
                                            <span class="{{ $statusColor }} font-black px-3 py-1 border-2 border-stroke uppercase text-sm shadow-[2px_2px_0px_0px_#272343]">
                                                {{ $order->status }}
                                            </span>
                                        </div>
                                        @if($order->status === 'SHIPPED' && $order->awb_resi)
                                            <div class="flex items-center gap-2">
                                                <x-heroicon-o-truck class="w-6 h-6 text-headline" />
                                                <span class="font-black text-headline uppercase">{{ $order->awb_resi }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Items List -->
                                    <div class="space-y-4">
                                        @foreach($order->items as $item)
                                            <div class="flex items-center gap-4 bg-background border-2 border-stroke p-3">
                                                <div class="w-16 h-16 bg-secondary border-2 border-stroke shrink-0">
                                                    <img src="{{ $item->variant->image_url ?? $item->variant->product->image_url }}" alt="{{ $item->variant->product->name }}" class="w-full h-full object-cover">
                                                </div>
                                                <div class="flex-grow">
                                                    <a href="{{ route('product.detail', $item->variant->product->slug) }}" wire:navigate class="font-black text-headline hover:text-button-fomo transition-colors uppercase line-clamp-1">
                                                        {{ $item->variant->product->name }}
                                                    </a>
                                                    <p class="text-sm font-bold text-paragraph uppercase">{{ $item->variant->variant_name }}</p>
                                                </div>
                                                <div class="text-right shrink-0">
                                                    <p class="font-bold text-paragraph text-sm">{{ $item->quantity }}x</p>
                                                    <p class="font-black text-headline">Rp {{ number_format($item->price_at_time, 0, ',', '.') }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    @if($order->status === 'PENDING')
                                        <div class="mt-6 flex justify-end">
                                            <a href="{{ route('checkout.payment', $order->id) }}" class="bg-button-fomo text-headline font-black px-6 py-3 border-4 border-stroke shadow-[4px_4px_0px_0px_#272343] hover:-translate-y-1 transition-transform flex items-center gap-2">
                                                <span>LANJUTKAN PEMBAYARAN</span>
                                                <x-heroicon-s-arrow-right class="w-5 h-5" />
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <x-heroicon-o-archive-box class="w-24 h-24 mb-4 text-stroke opacity-30 mx-auto" />
                        <h4 class="text-2xl font-black text-headline uppercase mb-2">Belum Ada Riwayat</h4>
                        <p class="text-paragraph font-bold mb-6">Gudang kosong. Mulai penuhi koleksi Anda sekarang.</p>
                        <a href="{{ route('catalog') }}" wire:navigate class="bg-button-fomo text-headline font-black px-8 py-4 border-4 border-stroke shadow-[4px_4px_0px_0px_#272343] hover:-translate-y-1 hover:shadow-[6px_6px_0px_0px_#272343] transition-all inline-block">
                            EXPLORE CATALOG
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
