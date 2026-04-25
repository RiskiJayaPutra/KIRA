<div class="mt-24 border-t-8 border-stroke pt-16" id="reviews-section">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12 gap-6">
        <div>
            <h2 class="text-5xl font-black text-headline uppercase tracking-tighter" style="-webkit-text-stroke: 1px #272343;">REVIEWS.</h2>
            <p class="text-xl font-bold text-paragraph mt-2">Suara dari barisan terdepan.</p>
        </div>
        
        <!-- Score Box -->
        <div class="bg-button-fomo border-4 border-stroke p-4 shadow-[6px_6px_0px_0px_#272343] flex items-center gap-4">
            <h3 class="text-4xl font-black text-headline">{{ $averageRating > 0 ? number_format($averageRating, 1) : '0.0' }}</h3>
            <div>
                <div class="flex gap-1 text-headline">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= round($averageRating))
                            <x-heroicon-s-star class="w-6 h-6" />
                        @else
                            <x-heroicon-o-star class="w-6 h-6 opacity-50" />
                        @endif
                    @endfor
                </div>
                <p class="text-sm font-bold mt-1">{{ count($reviews) }} OPERATIF</p>
            </div>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-12">
        
        <!-- Left: Form Input -->
        <div class="w-full lg:w-1/3">
            <div class="bg-background border-4 border-stroke p-6 sticky top-8 shadow-[8px_8px_0px_0px_rgba(39,35,67,1)]">
                <h3 class="text-2xl font-black text-headline uppercase border-b-4 border-stroke pb-2 mb-6 flex items-center gap-2">
                    <x-heroicon-o-chat-bubble-bottom-center-text class="w-8 h-8" />
                    Beri Laporan
                </h3>

                @auth
                    @if($hasReviewed)
                        <div class="bg-tertiary border-4 border-stroke p-6 text-center shadow-[4px_4px_0px_0px_#272343]">
                            <x-heroicon-s-check-circle class="w-16 h-16 text-headline mx-auto mb-4" />
                            <p class="font-black text-headline uppercase">Laporan Diterima</p>
                            <p class="text-sm font-bold mt-2">Anda telah menyuarakan opini untuk produk ini.</p>
                        </div>
                    @else
                        <form wire:submit="saveReview" class="flex flex-col gap-6">
                            <!-- Rating -->
                            <div>
                                <label class="block text-headline font-black uppercase mb-2">Tingkat Kepuasan</label>
                                <div class="flex gap-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button type="button" wire:click="setRating({{ $i }})" class="focus:outline-none hover:scale-110 transition-transform">
                                            @if($i <= $rating)
                                                <x-heroicon-s-star class="w-10 h-10 text-button-fomo filter drop-shadow-[2px_2px_0_#272343]" />
                                            @else
                                                <x-heroicon-o-star class="w-10 h-10 text-headline opacity-50" />
                                            @endif
                                        </button>
                                    @endfor
                                </div>
                                @error('rating') <span class="text-button-fomo font-bold text-sm bg-headline px-2 mt-2 inline-block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Comment -->
                            <div>
                                <label class="block text-headline font-black uppercase mb-2">Komentar Operasi</label>
                                <textarea wire:model="comment" rows="4" class="w-full bg-secondary border-4 border-stroke p-4 font-bold focus:outline-none focus:ring-0 focus:bg-background transition-colors placeholder-headline placeholder-opacity-50" placeholder="Tuliskan detail barang yang Anda terima..."></textarea>
                                @error('comment') <span class="text-button-fomo font-bold text-sm bg-headline px-2 mt-2 inline-block">{{ $message }}</span> @enderror
                            </div>

                            <button type="submit" class="w-full bg-headline text-background font-black text-xl py-4 border-4 border-stroke shadow-[4px_4px_0px_0px_#bae8e8] hover:-translate-y-1 hover:shadow-[6px_6px_0px_0px_#bae8e8] active:translate-y-0 active:shadow-none transition-all flex justify-center items-center gap-2 group">
                                <span>KIRIM LAPORAN</span>
                                <x-heroicon-s-paper-airplane class="w-6 h-6 group-hover:translate-x-2 group-hover:-translate-y-2 transition-transform" />
                            </button>
                        </form>
                    @endif
                @else
                    <div class="bg-secondary border-4 border-stroke p-6 text-center opacity-70">
                        <x-heroicon-o-lock-closed class="w-16 h-16 text-headline mx-auto mb-4" />
                        <p class="font-black text-headline uppercase mb-4">Akses Terkunci</p>
                        <a href="{{ route('login') }}" class="inline-block bg-headline text-background font-black px-6 py-2 border-4 border-stroke hover:bg-button-fomo hover:text-headline transition-colors">
                            LOGIN UNTUK MELAPOR
                        </a>
                    </div>
                @endauth
            </div>
        </div>

        <!-- Right: Reviews Wall -->
        <div class="w-full lg:w-2/3">
            @if(count($reviews) > 0)
                <div class="space-y-6">
                    @foreach($reviews as $review)
                        <div class="bg-background border-4 border-stroke p-6 relative group transition-colors hover:bg-secondary">
                            
                            <!-- Rating Badges -->
                            <div class="absolute -top-4 -right-4 bg-headline text-button-fomo border-4 border-stroke px-4 py-2 font-black text-xl flex items-center gap-2 shadow-[4px_4px_0px_0px_#bae8e8] rotate-3 group-hover:rotate-6 transition-transform">
                                <span>{{ $review->rating }}</span>
                                <x-heroicon-s-star class="w-5 h-5" />
                            </div>

                            <!-- User Info -->
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-12 h-12 bg-tertiary border-4 border-stroke flex items-center justify-center rounded-full font-black text-headline">
                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h4 class="text-xl font-black text-headline uppercase">{{ $review->user->name }}</h4>
                                    <div class="flex items-center gap-3">
                                        <span class="text-sm font-bold text-paragraph">{{ $review->created_at->diffForHumans() }}</span>
                                        @if($review->is_verified_buyer)
                                            <span class="text-xs font-black bg-tertiary text-headline px-2 border-2 border-stroke flex items-center gap-1 shadow-[2px_2px_0px_0px_#272343]">
                                                <x-heroicon-s-check-badge class="w-3 h-3" /> VERIFIED
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Comment text -->
                            @if($review->comment)
                                <p class="font-bold text-paragraph leading-relaxed pl-16 border-l-4 border-stroke ml-6">
                                    "{{ $review->comment }}"
                                </p>
                            @else
                                <p class="font-bold text-paragraph opacity-50 italic pl-16 border-l-4 border-stroke ml-6">
                                    Pengguna tidak meninggalkan pesan operasi.
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-secondary border-4 border-stroke border-dashed p-12 text-center h-full flex flex-col justify-center items-center">
                    <x-heroicon-o-megaphone class="w-24 h-24 text-stroke opacity-30 mb-6" />
                    <h3 class="text-3xl font-black text-headline uppercase mb-2">Belum Ada Suara</h3>
                    <p class="font-bold text-paragraph text-xl">Jadilah yang pertama melaporkan kualitas barang ini ke markas.</p>
                </div>
            @endif
        </div>

    </div>
</div>
