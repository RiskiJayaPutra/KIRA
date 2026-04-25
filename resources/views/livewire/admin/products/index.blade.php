<div>
    <div class="flex justify-between items-end mb-8">
        <div>
            <h2 class="text-4xl font-black text-headline uppercase tracking-tighter" style="-webkit-text-stroke: 1px #272343;">Katalog</h2>
            <p class="text-xl font-bold text-paragraph">Pusat komando basis data produk.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" wire:navigate class="bg-button-fomo text-headline font-black px-6 py-3 border-4 border-stroke shadow-[4px_4px_0px_0px_#272343] hover:-translate-y-1 hover:shadow-[6px_6px_0px_0px_#272343] transition-all flex items-center gap-2">
            <x-heroicon-s-plus class="w-6 h-6" />
            <span>TAMBAH PRODUK</span>
        </a>
    </div>

    <div class="bg-secondary border-4 border-stroke p-6 shadow-[8px_8px_0px_0px_rgba(39,35,67,1)] overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-max">
            <thead>
                <tr class="bg-headline text-background">
                    <th class="p-4 border-4 border-stroke font-black uppercase">ID</th>
                    <th class="p-4 border-4 border-stroke font-black uppercase">Nama Produk</th>
                    <th class="p-4 border-4 border-stroke font-black uppercase">Tipe</th>
                    <th class="p-4 border-4 border-stroke font-black uppercase">Jumlah Varian</th>
                    <th class="p-4 border-4 border-stroke font-black uppercase text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr class="bg-background hover:bg-tertiary transition-colors group">
                        <td class="p-4 border-4 border-stroke font-bold">#{{ $product->id }}</td>
                        <td class="p-4 border-4 border-stroke font-black uppercase">
                            {{ $product->name }}
                        </td>
                        <td class="p-4 border-4 border-stroke font-bold">
                            @if($product->is_blindbox)
                                <span class="bg-headline text-button-fomo px-2 py-1 text-xs font-black uppercase border-2 border-stroke">BLINDBOX</span>
                            @else
                                <span class="bg-background text-headline px-2 py-1 text-xs font-black uppercase border-2 border-stroke">FIGURE</span>
                            @endif
                        </td>
                        <td class="p-4 border-4 border-stroke font-bold">{{ $product->variants_count }}</td>
                        <td class="p-4 border-4 border-stroke text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('product.detail', $product->slug) }}" target="_blank" class="bg-secondary text-headline p-2 border-2 border-stroke hover:bg-headline hover:text-background transition-colors" title="Lihat di Web">
                                    <x-heroicon-o-eye class="w-5 h-5" />
                                </a>
                                <a href="{{ route('admin.products.edit', $product->id) }}" wire:navigate class="bg-button-fomo text-headline p-2 border-2 border-stroke hover:bg-headline hover:text-button-fomo transition-colors" title="Edit">
                                    <x-heroicon-o-pencil-square class="w-5 h-5" />
                                </a>
                                <button wire:click="delete({{ $product->id }})" wire:confirm="Hapus produk ini secara permanen?" class="bg-red-500 text-background p-2 border-2 border-stroke hover:bg-headline transition-colors" title="Hapus">
                                    <x-heroicon-o-trash class="w-5 h-5" />
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 border-4 border-stroke text-center font-bold text-xl opacity-50">Katalog Kosong</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
