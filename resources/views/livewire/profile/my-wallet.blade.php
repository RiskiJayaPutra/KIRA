<div class="container mx-auto px-4 py-12 max-w-6xl">
    <div class="mb-10">
        <h1 class="text-5xl font-black text-headline uppercase" style="-webkit-text-stroke: 1px #272343;">MY WALLET.</h1>
        <p class="text-paragraph text-xl font-bold mt-2">Brankas digital & komando afiliasi Anda.</p>
    </div>

    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar -->
        <x-profile-sidebar />

        <!-- Main Content -->
        <div class="w-full md:w-3/4">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <!-- KIRI: Kira Points -->
                <div class="bg-background border-4 border-stroke p-8 shadow-[8px_8px_0px_0px_rgba(39,35,67,1)] h-full flex flex-col">
                    <div class="flex items-center gap-4 mb-6 border-b-4 border-stroke pb-4">
                        <div class="w-12 h-12 bg-headline flex items-center justify-center rounded-full text-background">
                            <x-heroicon-s-star class="w-8 h-8 text-button-fomo" />
                        </div>
                        <h3 class="text-3xl font-black text-headline uppercase">Kira Points</h3>
                    </div>
                    
                    <div class="flex-grow flex flex-col justify-center items-center text-center py-8">
                        <p class="text-lg font-bold text-paragraph uppercase mb-2">Saldo Aktif</p>
                        <h2 class="text-6xl font-black text-headline" style="text-shadow: 4px 4px 0 #ffd803;">
                            {{ number_format($kiraPoints, 0, ',', '.') }}
                        </h2>
                        <p class="text-sm font-bold text-paragraph mt-4">1 Point = Rp 1. Dapat digunakan untuk potongan harga saat Checkout (Fase Mendatang).</p>
                    </div>
                    
                    <button class="w-full bg-secondary text-paragraph font-black py-4 border-4 border-stroke opacity-50 cursor-not-allowed mt-auto flex justify-center items-center gap-2">
                        <x-heroicon-o-lock-closed class="w-5 h-5" />
                        TUKARKAN POIN
                    </button>
                </div>

                <!-- KANAN: Affiliate Radar -->
                <div class="bg-secondary border-4 border-stroke p-8 shadow-[8px_8px_0px_0px_rgba(39,35,67,1)] h-full flex flex-col">
                    <div class="flex items-center gap-4 mb-6 border-b-4 border-stroke pb-4">
                        <div class="w-12 h-12 bg-button-fomo flex items-center justify-center rounded-full text-headline border-2 border-stroke">
                            <x-heroicon-s-currency-dollar class="w-8 h-8" />
                        </div>
                        <h3 class="text-3xl font-black text-headline uppercase">Markas Afiliasi</h3>
                    </div>

                    @if($affiliateCode)
                        <!-- Jika Sudah Aktif -->
                        <div class="flex-grow flex flex-col justify-center items-center text-center py-4">
                            <p class="text-lg font-bold text-paragraph uppercase mb-2">Komisi Tersedia</p>
                            <h2 class="text-5xl font-black text-button-fomo mb-6" style="-webkit-text-stroke: 1px #272343;">
                                Rp {{ number_format($affiliateBalance, 0, ',', '.') }}
                            </h2>
                            
                            <div class="w-full bg-background border-4 border-stroke p-4 text-left relative group">
                                <p class="text-xs font-bold text-paragraph uppercase mb-1">Kode Referral Anda</p>
                                <div class="flex items-center justify-between">
                                    <p class="text-xl font-black text-headline tracking-widest">{{ $affiliateCode }}</p>
                                    <button onclick="navigator.clipboard.writeText('{{ url('/?ref=' . $affiliateCode) }}'); alert('Link referral berhasil disalin!');" class="bg-headline text-background p-2 hover:bg-tertiary hover:text-headline transition-colors">
                                        <x-heroicon-o-clipboard-document class="w-6 h-6" />
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        @if(session('payout_success'))
                            <div class="mt-4 bg-green-400 text-headline p-3 font-bold border-2 border-stroke text-sm text-center">
                                {{ session('payout_success') }}
                            </div>
                        @endif

                        @if($showPayoutForm)
                            <div class="w-full mt-6 bg-background border-4 border-stroke p-4 text-left shadow-[4px_4px_0px_0px_#272343]">
                                <h4 class="font-black text-headline uppercase mb-4 border-b-2 border-stroke pb-2">Form Pencairan</h4>
                                <form wire:submit="requestPayout" class="space-y-4">
                                    <div>
                                        <label class="block text-xs font-bold uppercase mb-1">Nominal (Min. 50000)</label>
                                        <input type="number" wire:model="payoutAmount" class="w-full bg-secondary border-2 border-stroke p-2 font-bold focus:outline-none focus:bg-background" placeholder="50000">
                                        @error('payoutAmount') <span class="text-button-fomo text-xs font-bold">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold uppercase mb-1">Bank & No. Rekening</label>
                                        <textarea wire:model="bankDetails" rows="2" class="w-full bg-secondary border-2 border-stroke p-2 font-bold focus:outline-none focus:bg-background" placeholder="BCA 12345678 a.n. John Doe"></textarea>
                                        @error('bankDetails') <span class="text-button-fomo text-xs font-bold">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="flex gap-2 pt-2">
                                        <button type="button" wire:click="togglePayoutForm" class="flex-1 bg-secondary text-headline font-black py-2 border-2 border-stroke hover:bg-headline hover:text-background transition-colors text-sm">BATAL</button>
                                        <button type="submit" class="flex-1 bg-headline text-background font-black py-2 border-2 border-stroke hover:bg-button-fomo hover:text-headline transition-colors text-sm shadow-[2px_2px_0px_0px_#bae8e8]">KIRIM</button>
                                    </div>
                                </form>
                            </div>
                        @else
                            <button wire:click="togglePayoutForm" class="w-full bg-headline text-background font-black py-4 border-4 border-stroke shadow-[4px_4px_0px_0px_#bae8e8] hover:-translate-y-1 active:translate-y-0 active:shadow-none transition-all mt-auto mt-6 flex justify-center items-center gap-2">
                                <x-heroicon-o-banknotes class="w-5 h-5" />
                                CAIRKAN KOMISI
                            </button>
                        @endif
                    @else
                        <!-- Jika Belum Aktif -->
                        <div class="flex-grow flex flex-col justify-center items-center text-center py-4">
                            <x-heroicon-o-signal class="w-20 h-20 text-stroke opacity-30 mb-4" />
                            <h4 class="text-2xl font-black text-headline uppercase mb-2">Sinyal Terputus</h4>
                            <p class="text-paragraph font-bold mb-6">Anda belum mengaktifkan program afiliasi. Aktifkan sekarang dan dapatkan komisi dari setiap penjualan yang Anda rekomendasikan!</p>
                            <p class="text-sm font-bold text-button-fomo mb-4">*Bonus 100 Kira Points untuk pendaftaran pertama!</p>
                        </div>
                        
                        <button wire:click="activateAffiliate" class="w-full bg-button-fomo text-headline font-black py-4 border-4 border-stroke shadow-[6px_6px_0px_0px_#272343] hover:-translate-y-1 active:translate-y-0 active:shadow-none transition-all mt-auto flex justify-center items-center gap-2 group">
                            <span>AKTIFKAN RADAR</span>
                            <x-heroicon-s-bolt class="w-5 h-5 group-hover:scale-125 transition-transform" />
                        </button>
                    @endif
                </div>

            </div>

        </div>
    </div>
</div>
