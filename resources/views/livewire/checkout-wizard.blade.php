<div class="max-w-3xl mx-auto py-12 px-4">
    {{-- Progress Tracker Neo-Brutalism (Desain Happy Hues) --}}
    <div class="flex justify-between items-center mb-12 relative">
        <div class="absolute w-full h-2 bg-stroke z-0 top-1/2 -translate-y-1/2"></div>
        
        @for ($i = 1; $i <= $totalSteps; $i++)
            <div class="relative z-10 flex flex-col items-center">
                <div class="w-12 h-12 rounded-full border-4 border-stroke flex items-center justify-center font-black text-xl transition-colors duration-300 shadow-[4px_4px_0px_0px_rgba(39,35,67,1)]
                    {{ $currentStep >= $i ? 'bg-button-fomo text-headline' : 'bg-background text-stroke' }}">
                    {{ $i }}
                </div>
                <span class="mt-2 font-bold text-headline bg-background px-2 border-2 border-stroke rounded-md">
                    @if($i == 1) Alamat @elseif($i == 2) Kurir @else Bayar @endif
                </span>
            </div>
        @endfor
    </div>

    {{-- Kartu Utama Form Interaktif --}}
    <div class="card-premium p-8 bg-background relative overflow-hidden">
        
        {{-- Efek Loading (Pindah Step) --}}
        <div wire:loading wire:target="nextStep, previousStep, processCheckout" class="absolute inset-0 bg-background/80 z-50 flex items-center justify-center backdrop-blur-sm">
            <span class="animate-spin h-10 w-10 border-4 border-button-fomo border-t-stroke rounded-full"></span>
        </div>

        {{-- Step 1: Alamat Logistik --}}
        @if ($currentStep == 1)
            <h2 class="text-3xl font-black text-headline mb-6">Tujuan Pengiriman 📦</h2>
            <div class="mb-4">
                <label class="block font-bold text-paragraph mb-2">Alamat Lengkap</label>
                <textarea wire:model="shippingAddress" class="w-full border-4 border-stroke rounded-xl p-4 bg-secondary focus:bg-background focus:outline-none focus:translate-y-1 transition-transform font-medium shadow-inner" rows="4" placeholder="Jalan FOMO No. 99, RT/RW..."></textarea>
                @error('shippingAddress') <span class="text-red-600 font-bold mt-1 block bg-red-100 px-2 py-1 border-2 border-red-600 inline-block">{{ $message }}</span> @enderror
            </div>
        @endif

        {{-- Step 2: Pemilihan Kurir Ekspedisi (Fase 12 Injection) --}}
        @if ($currentStep == 2)
            <h2 class="text-3xl font-black text-headline mb-6">Pilih Kurir Kargo 🚚</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach(['jne' => 'JNE Express (Reguler)', 'sicepat' => 'SiCepat Halu'] as $val => $label)
                    <label class="cursor-pointer border-4 border-stroke rounded-xl p-4 text-center font-bold transition-all transform hover:-translate-y-1 hover:shadow-[4px_4px_0px_0px_rgba(39,35,67,1)]
                        {{ $courier === $val ? 'bg-button-fomo scale-105' : 'bg-secondary' }}">
                        <input type="radio" wire:model="courier" value="{{ $val }}" class="hidden">
                        {{ $label }}
                    </label>
                @endforeach
            </div>
            @error('courier') <span class="text-red-600 font-bold mt-2 block bg-red-100 px-2 py-1 border-2 border-red-600 inline-block">{{ $message }}</span> @enderror
        @endif

        {{-- Step 3: Mesin Pembayaran Final --}}
        @if ($currentStep == 3)
            <h2 class="text-3xl font-black text-headline mb-6">Metode Pembayaran 💳</h2>
            <div class="space-y-4">
                @foreach(['qris' => 'QRIS (Konfirmasi Instan)', 'va' => 'Virtual Account Bank'] as $val => $label)
                    <label class="block cursor-pointer border-4 border-stroke rounded-xl p-4 font-bold transition-colors hover:bg-tertiary flex justify-between items-center
                        {{ $paymentMethod === $val ? 'bg-tertiary shadow-[4px_4px_0px_0px_rgba(39,35,67,1)]' : 'bg-background' }}">
                        <span>{{ $label }}</span>
                        <input type="radio" wire:model="paymentMethod" value="{{ $val }}" class="w-5 h-5 accent-stroke">
                    </label>
                @endforeach
            </div>
            @error('paymentMethod') <span class="text-red-600 font-bold mt-2 block bg-red-100 px-2 py-1 border-2 border-red-600 inline-block">{{ $message }}</span> @enderror
        @endif

        {{-- Navigasi Mesin Paralel --}}
        <div class="flex justify-between mt-10 pt-6 border-t-4 border-stroke">
            @if ($currentStep > 1)
                <button wire:click="previousStep" class="font-bold text-paragraph hover:text-button-text hover:bg-secondary px-4 py-2 rounded-lg border-2 border-transparent hover:border-stroke transition-all">
                    &larr; Kembali
                </button>
            @else
                <div></div> {{-- Spacer --}}
            @endif

            @if ($currentStep < $totalSteps)
                <button wire:click="nextStep" class="btn-fomo py-2 px-8">
                    Lanjut &rarr;
                </button>
            @else
                <button wire:click="processCheckout" class="btn-fomo py-2 px-8 animate-pulse">
                    Kunci Pesanan! 🔒
                </button>
            @endif
        </div>
    </div>
</div>
