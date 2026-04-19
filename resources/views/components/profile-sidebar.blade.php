<div class="w-full md:w-1/4 bg-background border-4 border-stroke p-6 mb-8 md:mb-0">
    <div class="mb-8 text-center">
        <div class="w-24 h-24 bg-tertiary border-4 border-stroke rounded-full mx-auto mb-4 flex items-center justify-center text-3xl font-black text-headline shadow-[4px_4px_0px_0px_rgba(39,35,67,1)]">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
        <h2 class="text-2xl font-black text-headline">{{ auth()->user()->name }}</h2>
        <p class="text-paragraph font-bold">{{ auth()->user()->email }}</p>
    </div>

    <nav class="flex flex-col gap-2">
        <a href="{{ route('dashboard') }}" wire:navigate class="font-bold text-lg px-4 py-3 border-2 border-stroke transition-all {{ request()->routeIs('dashboard') ? 'bg-button-fomo text-headline shadow-[4px_4px_0px_0px_rgba(39,35,67,1)] -translate-y-1' : 'bg-background hover:bg-secondary' }}">
            Dashboard
        </a>
        <a href="{{ route('address.book') }}" wire:navigate class="font-bold text-lg px-4 py-3 border-2 border-stroke transition-all {{ request()->routeIs('address.book') ? 'bg-button-fomo text-headline shadow-[4px_4px_0px_0px_rgba(39,35,67,1)] -translate-y-1' : 'bg-background hover:bg-secondary' }}">
            Address Book
        </a>
        <!-- Placeholders for future phases -->
        <a href="#" class="font-bold text-lg px-4 py-3 border-2 border-stroke bg-background hover:bg-secondary transition-all opacity-50 cursor-not-allowed">
            Order History
        </a>
        <a href="#" class="font-bold text-lg px-4 py-3 border-2 border-stroke bg-background hover:bg-secondary transition-all opacity-50 cursor-not-allowed">
            My Wallet
        </a>
    </nav>
</div>
