<div>
    <div class="mb-8">
        <h2 class="text-4xl font-black text-headline uppercase tracking-tighter" style="-webkit-text-stroke: 1px #272343;">PEMROSESAN PESANAN</h2>
        <p class="text-xl font-bold text-paragraph">Stasiun pemantauan jalur logistik.</p>
    </div>

    <div class="bg-secondary border-4 border-stroke p-6 shadow-[8px_8px_0px_0px_rgba(39,35,67,1)] overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-max">
            <thead>
                <tr class="bg-headline text-background">
                    <th class="p-4 border-4 border-stroke font-black uppercase">Order ID</th>
                    <th class="p-4 border-4 border-stroke font-black uppercase">Pembeli</th>
                    <th class="p-4 border-4 border-stroke font-black uppercase">Waktu</th>
                    <th class="p-4 border-4 border-stroke font-black uppercase text-right">Total (Rp)</th>
                    <th class="p-4 border-4 border-stroke font-black uppercase text-center">Status</th>
                    <th class="p-4 border-4 border-stroke font-black uppercase text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr class="bg-background hover:bg-tertiary transition-colors group">
                        <td class="p-4 border-4 border-stroke font-bold">#KIRA-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                        <td class="p-4 border-4 border-stroke font-bold uppercase">{{ $order->user->name }}</td>
                        <td class="p-4 border-4 border-stroke font-bold">{{ $order->created_at->format('d M Y, H:i') }}</td>
                        <td class="p-4 border-4 border-stroke font-black text-right text-button-fomo" style="-webkit-text-stroke: 1px #272343;">
                            {{ number_format($order->total_price, 0, ',', '.') }}
                        </td>
                        <td class="p-4 border-4 border-stroke text-center">
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
                            <span class="{{ $statusColor }} font-black px-3 py-1 border-2 border-stroke uppercase text-xs shadow-[2px_2px_0px_0px_#272343]">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="p-4 border-4 border-stroke text-center">
                            <a href="{{ route('admin.orders.show', $order->id) }}" wire:navigate class="inline-block bg-headline text-background p-2 border-2 border-stroke hover:bg-button-fomo hover:text-headline transition-colors" title="Proses">
                                <x-heroicon-s-arrow-right-circle class="w-5 h-5" />
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 border-4 border-stroke text-center font-bold text-xl opacity-50">Belum ada pesanan masuk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
