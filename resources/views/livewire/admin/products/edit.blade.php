<div>
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('admin.products.index') }}" wire:navigate class="bg-background text-headline p-3 border-4 border-stroke hover:bg-secondary transition-colors">
            <x-heroicon-s-arrow-left class="w-6 h-6" />
        </a>
        <div>
            <h2 class="text-4xl font-black text-headline uppercase tracking-tighter" style="-webkit-text-stroke: 1px #272343;">EDIT PRODUK</h2>
            <p class="text-xl font-bold text-paragraph">Modifikasi parameter entitas katalog.</p>
        </div>
    </div>

    <form wire:submit="save" class="flex flex-col lg:flex-row gap-8">
        
        <!-- Kolom Kiri: Info Dasar -->
        <div class="w-full lg:w-1/2 space-y-6">
            <div class="bg-background border-4 border-stroke p-6 shadow-[8px_8px_0px_0px_rgba(39,35,67,1)]">
                <h3 class="text-2xl font-black text-headline uppercase border-b-4 border-stroke pb-2 mb-6">Informasi Dasar</h3>
                
                <div class="space-y-4 font-bold text-headline">
                    <div>
                        <label class="block uppercase mb-1">Nama Produk</label>
                        <input type="text" wire:model.live="name" class="w-full bg-secondary border-4 border-stroke p-3 focus:outline-none focus:bg-background transition-colors" placeholder="Contoh: KAWS Companion">
                        @error('name') <span class="text-button-fomo text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block uppercase mb-1">Slug (URL)</label>
                        <input type="text" wire:model="slug" class="w-full bg-secondary border-4 border-stroke p-3 focus:outline-none focus:bg-background transition-colors opacity-70" placeholder="kaws-companion">
                        @error('slug') <span class="text-button-fomo text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block uppercase mb-1">URL Gambar Utama</label>
                        <input type="text" wire:model="image_url" class="w-full bg-secondary border-4 border-stroke p-3 focus:outline-none focus:bg-background transition-colors" placeholder="https://example.com/image.jpg">
                        @error('image_url') <span class="text-button-fomo text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block uppercase mb-1">Deskripsi</label>
                        <textarea wire:model="description" rows="5" class="w-full bg-secondary border-4 border-stroke p-3 focus:outline-none focus:bg-background transition-colors"></textarea>
                        @error('description') <span class="text-button-fomo text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-4 border-t-4 border-stroke">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" wire:model.live="is_blindbox" class="w-6 h-6 border-4 border-stroke text-button-fomo focus:ring-0">
                            <span class="text-xl uppercase font-black">Mode Blindbox</span>
                        </label>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full bg-headline text-background font-black text-2xl py-4 border-4 border-stroke shadow-[6px_6px_0px_0px_#bae8e8] hover:-translate-y-1 active:translate-y-0 active:shadow-none transition-all flex justify-center items-center gap-2">
                <x-heroicon-s-arrow-path class="w-6 h-6" />
                SINKRONISASI DATA
            </button>
        </div>

        <!-- Kolom Kanan: Varian -->
        <div class="w-full lg:w-1/2">
            <div class="bg-secondary border-4 border-stroke p-6 shadow-[8px_8px_0px_0px_rgba(39,35,67,1)] h-full">
                <div class="flex justify-between items-center border-b-4 border-stroke pb-2 mb-6">
                    <h3 class="text-2xl font-black text-headline uppercase">Manajemen Varian</h3>
                    <button type="button" wire:click="addVariant" class="bg-headline text-background font-black px-4 py-2 border-2 border-stroke hover:bg-tertiary hover:text-headline transition-colors text-sm flex items-center gap-1">
                        <x-heroicon-s-plus class="w-4 h-4" /> TAMBAH VARIAN
                    </button>
                </div>

                <div class="space-y-6">
                    @foreach($variants as $index => $variant)
                        <div class="bg-background border-4 border-stroke p-4 relative group">
                            <!-- Tombol Hapus Varian -->
                            @if(count($variants) > 1)
                                <button type="button" wire:click="removeVariant({{ $index }})" class="absolute -top-3 -right-3 bg-red-500 text-background w-8 h-8 rounded-full border-2 border-stroke flex justify-center items-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <x-heroicon-s-x-mark class="w-5 h-5" />
                                </button>
                            @endif

                            <div class="grid grid-cols-2 gap-4 font-bold text-headline">
                                <div class="col-span-2">
                                    <label class="block uppercase text-xs mb-1">Nama Varian</label>
                                    <input type="text" wire:model="variants.{{ $index }}.variant_name" class="w-full bg-secondary border-2 border-stroke p-2 focus:outline-none focus:bg-background" placeholder="Standard">
                                    @error('variants.'.$index.'.variant_name') <span class="text-button-fomo text-xs">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label class="block uppercase text-xs mb-1">Harga (Rp)</label>
                                    <input type="number" wire:model="variants.{{ $index }}.price" class="w-full bg-secondary border-2 border-stroke p-2 focus:outline-none focus:bg-background">
                                    @error('variants.'.$index.'.price') <span class="text-button-fomo text-xs">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label class="block uppercase text-xs mb-1">Stok Fisik</label>
                                    <input type="number" wire:model="variants.{{ $index }}.stock" class="w-full bg-secondary border-2 border-stroke p-2 focus:outline-none focus:bg-background">
                                    @error('variants.'.$index.'.stock') <span class="text-button-fomo text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-span-2">
                                    <label class="block uppercase text-xs mb-1">URL Gambar Khusus</label>
                                    <input type="text" wire:model="variants.{{ $index }}.image_url" class="w-full bg-secondary border-2 border-stroke p-2 focus:outline-none focus:bg-background" placeholder="Opsional">
                                </div>

                                @if($is_blindbox)
                                    <div class="col-span-2 bg-headline text-button-fomo p-2 border-2 border-stroke">
                                        <label class="block uppercase text-xs mb-1">Drop Rate (%)</label>
                                        <input type="number" step="0.01" wire:model="variants.{{ $index }}.drop_rate" class="w-full bg-background text-headline border-2 border-stroke p-2 focus:outline-none" placeholder="10.5">
                                        @error('variants.'.$index.'.drop_rate') <span class="text-button-fomo text-xs">{{ $message }}</span> @enderror
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </form>
</div>
