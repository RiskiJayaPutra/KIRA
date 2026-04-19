<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    
    {{-- Kop Surat Dashboard ala Militer/Brutalism --}}
    <div class="mb-10 flex flex-col md:flex-row md:justify-between md:items-end gap-4">
        <div>
            <h1 class="text-5xl font-black text-headline tracking-tight uppercase" style="text-shadow: 4px 4px 0 #ffd803;">Pusat Kendali Satelit</h1>
            <p class="text-paragraph font-bold mt-2 text-xl">Intelijen Bisnis Kira.com (Akses Terbatas)</p>
        </div>
        <div class="bg-button-fomo border-4 border-stroke px-6 py-3 shadow-[6px_6px_0px_0px_rgba(39,35,67,1)] inline-block">
            <span class="font-black text-headline text-lg">STATUS RADAR: <span class="text-green-800 animate-pulse">AKTIF</span></span>
        </div>
    </div>

    {{-- Tiga Pilar Metrik Operasi (Kartu Besar) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        
        {{-- Pendapatan (Revenue) --}}
        <div class="card-premium bg-background p-6 border-4 border-stroke shadow-[8px_8px_0px_0px_rgba(39,35,67,1)] transform hover:-translate-y-2 transition-transform">
            <h3 class="text-xl font-bold text-tertiary mb-2 uppercase tracking-widest">Aliran Masuk (Hari Ini)</h3>
            <p class="text-4xl font-black text-headline">Rp {{ number_format($todaySales, 0, ',', '.') }}</p>
        </div>

        {{-- Pasukan Rujukan (Viral Marketing) --}}
        <div class="card-premium bg-secondary p-6 border-4 border-stroke shadow-[8px_8px_0px_0px_rgba(39,35,67,1)] transform hover:-translate-y-2 transition-transform">
            <h3 class="text-xl font-bold text-headline mb-2 uppercase tracking-widest">Pasukan KOL Afiliasi</h3>
            <p class="text-4xl font-black text-headline">{{ $totalAffiliates }} <span class="text-lg">Agen Aktif</span></p>
        </div>

        {{-- Tingkat Pembatalan (Konversi) --}}
        <div class="card-premium bg-[#ff5470] p-6 border-4 border-stroke shadow-[8px_8px_0px_0px_rgba(39,35,67,1)] transform hover:-translate-y-2 transition-transform">
            <h3 class="text-xl font-bold text-[#fffffe] mb-2 uppercase tracking-widest">Rasio Konversi</h3>
            <div class="flex items-end gap-2 text-[#fffffe]">
                <p class="text-4xl font-black">{{ $conversionRate['success'] }}</p>
                <p class="text-lg font-bold pb-1">Sukses / {{ $conversionRate['failed'] }} Batal</p>
            </div>
        </div>
    </div>

    {{-- Radar Peringatan Kelangkaan (Scarcity Radar) --}}
    <div class="card-premium bg-background p-8 border-4 border-stroke shadow-[8px_8px_0px_0px_rgba(39,35,67,1)] relative overflow-hidden">
        
        {{-- Aksen Garis Miring Background --}}
        <div class="absolute inset-0 opacity-5 pointer-events-none" style="background-image: repeating-linear-gradient(45deg, #272343 0, #272343 2px, transparent 2px, transparent 8px);"></div>

        <h2 class="text-3xl font-black text-headline mb-6 flex items-center gap-3 relative z-10">
            <span class="w-4 h-4 rounded-full bg-[#ff5470] animate-ping"></span> 
            Peringatan Gudang (Stok Kritis)
        </h2>
        
        <div class="overflow-x-auto relative z-10">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-tertiary text-background border-b-4 border-stroke">
                        <th class="p-4 font-black uppercase">Varian Karakter</th>
                        <th class="p-4 font-black uppercase">Merek / Seri Induk</th>
                        <th class="p-4 font-black uppercase text-center">Sisa Suplai</th>
                        <th class="p-4 font-black uppercase text-right">Tindakan Cepat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($criticalStocks as $variant)
                    <tr class="border-b-2 border-stroke hover:bg-secondary transition-colors font-bold">
                        <td class="p-4 text-headline">{{ $variant->variant_name }}</td>
                        <td class="p-4 text-paragraph">{{ $variant->product->name ?? 'Data Induk Hilang' }}</td>
                        <td class="p-4 text-center">
                            {{-- Lencana Merah Darurat --}}
                            <span class="inline-block px-3 py-1 bg-[#ff5470] text-[#fffffe] border-2 border-stroke shadow-[2px_2px_0px_0px_rgba(39,35,67,1)] animate-pulse">
                                {{ $variant->stock }} Pcs
                            </span>
                        </td>
                        <td class="p-4 text-right">
                            <button class="bg-button-fomo px-4 py-2 border-2 border-stroke hover:scale-105 active:scale-95 transition-transform text-sm text-headline font-black shadow-[2px_2px_0px_0px_rgba(39,35,67,1)]">
                                RE-STOCK 💉
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-paragraph font-bold border-b-2 border-stroke">
                            Gudang aman. Tidak ada Varian yang terdeteksi menipis.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
