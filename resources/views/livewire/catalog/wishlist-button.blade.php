<div>
    @if($style === 'full')
        <!-- Gaya tombol penuh untuk halaman Product Detail -->
        <button wire:click="toggleWishlist" 
                class="w-full font-black text-xl py-4 border-4 border-stroke transition-all flex justify-center items-center gap-2 {{ $isWishlisted ? 'bg-tertiary text-headline shadow-none translate-y-1' : 'bg-background text-headline shadow-[4px_4px_0px_0px_#bae8e8] hover:-translate-y-1 hover:shadow-[6px_6px_0px_0px_#bae8e8]' }}">
            <span>{{ $isWishlisted ? 'WISHLISTED' : 'ADD TO WISHLIST' }}</span>
            <span class="text-2xl">{{ $isWishlisted ? '❤️' : '🤍' }}</span>
        </button>
    @else
        <!-- Gaya ikon/kotak kecil untuk Product Grid -->
        <button wire:click="toggleWishlist" 
                class="font-black px-6 py-3 border-4 border-stroke transition-transform w-3/4 flex justify-center items-center gap-2 {{ $isWishlisted ? 'bg-tertiary text-headline' : 'bg-background text-headline hover:scale-105' }}">
            <span>{{ $isWishlisted ? 'SAVED' : '+ WISHLIST' }}</span>
        </button>
    @endif
</div>
