<div class="container mx-auto px-4 py-12 max-w-6xl">
    <div class="mb-10">
        <h1 class="text-5xl font-black text-headline uppercase" style="-webkit-text-stroke: 1px #272343;">ADDRESS BOOK.</h1>
        <p class="text-paragraph text-xl font-bold mt-2">Kelola alamat pengiriman untuk drop eksklusif Anda.</p>
    </div>

    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar -->
        <x-profile-sidebar />

        <!-- Main Content -->
        <div class="w-full md:w-3/4">
            
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-3xl font-black text-headline">Saved Addresses</h3>
                <button wire:click="toggleForm" class="bg-button-fomo text-headline font-black px-6 py-3 border-4 border-stroke hover:-translate-y-1 hover:shadow-[4px_4px_0px_0px_rgba(39,35,67,1)] active:translate-y-0 active:shadow-none transition-all flex items-center gap-2">
                    {{ $showAddForm ? 'BATAL' : '+ ADD NEW' }}
                </button>
            </div>

            <!-- Add Form -->
            @if($showAddForm)
            <div class="bg-background border-4 border-stroke p-8 mb-8 shadow-[8px_8px_0px_0px_rgba(39,35,67,1)] animate-fade-in-up">
                <h4 class="text-2xl font-black text-headline mb-6 border-b-4 border-stroke pb-2">ADD NEW ADDRESS</h4>
                <form wire:submit="saveAddress" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-headline font-bold mb-2 uppercase">Label (e.g., Home, Office)</label>
                            <input wire:model="label" type="text" class="w-full bg-background border-4 border-stroke rounded-none px-4 py-3 font-bold focus:outline-none focus:-translate-y-1 transition-all @error('label') border-red-500 @enderror">
                            @error('label') <span class="text-red-500 font-bold text-sm block mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-headline font-bold mb-2 uppercase">Recipient Name</label>
                            <input wire:model="recipient_name" type="text" class="w-full bg-background border-4 border-stroke rounded-none px-4 py-3 font-bold focus:outline-none focus:-translate-y-1 transition-all @error('recipient_name') border-red-500 @enderror">
                            @error('recipient_name') <span class="text-red-500 font-bold text-sm block mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-headline font-bold mb-2 uppercase">Phone Number</label>
                            <input wire:model="phone_number" type="text" class="w-full bg-background border-4 border-stroke rounded-none px-4 py-3 font-bold focus:outline-none focus:-translate-y-1 transition-all @error('phone_number') border-red-500 @enderror">
                            @error('phone_number') <span class="text-red-500 font-bold text-sm block mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-headline font-bold mb-2 uppercase">City</label>
                            <input wire:model="city" type="text" class="w-full bg-background border-4 border-stroke rounded-none px-4 py-3 font-bold focus:outline-none focus:-translate-y-1 transition-all @error('city') border-red-500 @enderror">
                            @error('city') <span class="text-red-500 font-bold text-sm block mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-headline font-bold mb-2 uppercase">Full Address</label>
                        <textarea wire:model="full_address" rows="3" class="w-full bg-background border-4 border-stroke rounded-none px-4 py-3 font-bold focus:outline-none focus:-translate-y-1 transition-all @error('full_address') border-red-500 @enderror"></textarea>
                        @error('full_address') <span class="text-red-500 font-bold text-sm block mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="w-full md:w-1/2">
                        <label class="block text-headline font-bold mb-2 uppercase">Postal Code</label>
                        <input wire:model="postal_code" type="text" class="w-full bg-background border-4 border-stroke rounded-none px-4 py-3 font-bold focus:outline-none focus:-translate-y-1 transition-all @error('postal_code') border-red-500 @enderror">
                        @error('postal_code') <span class="text-red-500 font-bold text-sm block mt-1">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="bg-headline text-background font-black px-8 py-4 border-4 border-stroke hover:-translate-y-1 hover:shadow-[4px_4px_0px_0px_#ffd803] transition-all w-full md:w-auto mt-4">
                        SAVE ADDRESS
                    </button>
                </form>
            </div>
            @endif

            <!-- Address List -->
            @if($addresses->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($addresses as $address)
                    <div class="bg-background border-4 {{ $address->is_primary ? 'border-tertiary shadow-[8px_8px_0px_0px_#bae8e8]' : 'border-stroke shadow-[4px_4px_0px_0px_rgba(39,35,67,1)]' }} p-6 relative flex flex-col h-full transition-all hover:-translate-y-1">
                        
                        @if($address->is_primary)
                        <div class="absolute -top-4 -right-4 bg-tertiary border-4 border-stroke px-3 py-1 font-black text-headline uppercase rotate-12">
                            PRIMARY
                        </div>
                        @endif

                        <div class="flex-grow">
                            <h4 class="text-2xl font-black text-headline uppercase mb-1">{{ $address->label }}</h4>
                            <p class="font-bold text-headline mb-4">{{ $address->recipient_name }} | {{ $address->phone_number }}</p>
                            
                            <p class="text-paragraph font-medium leading-relaxed">{{ $address->full_address }}</p>
                            <p class="text-paragraph font-medium">{{ $address->city }}, {{ $address->postal_code }}</p>
                        </div>

                        <div class="mt-6 pt-4 border-t-4 border-stroke flex gap-4">
                            @if(!$address->is_primary)
                            <button wire:click="setPrimary({{ $address->id }})" class="text-sm font-black underline decoration-4 decoration-tertiary hover:bg-tertiary transition-colors uppercase">
                                Set Primary
                            </button>
                            @endif
                            <button wire:click="deleteAddress({{ $address->id }})" wire:confirm="Are you sure you want to delete this address?" class="text-sm font-black text-red-500 underline decoration-4 decoration-red-200 hover:bg-red-200 transition-colors uppercase ml-auto">
                                Delete
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="bg-secondary border-4 border-stroke p-12 text-center shadow-[8px_8px_0px_0px_rgba(39,35,67,1)]">
                    <div class="text-6xl mb-4">🏠</div>
                    <h3 class="text-2xl font-black text-headline mb-2 uppercase">No Addresses Found</h3>
                    <p class="text-paragraph font-bold">Anda belum menambahkan alamat pengiriman.</p>
                </div>
            @endif

        </div>
    </div>
</div>

<style>
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in-up {
    animation: fadeInUp 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
}
</style>
