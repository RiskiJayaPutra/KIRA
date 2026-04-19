<div class="flex min-h-screen">
    <!-- Left Panel: Form -->
    <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 md:px-20 py-12 bg-background relative z-10 border-r-4 border-stroke">
        <div class="max-w-md w-full mx-auto">
            <h1 class="text-5xl font-black text-headline mb-2" style="-webkit-text-stroke: 1px #272343;">WELCOME BACK.</h1>
            <p class="text-paragraph text-lg font-medium mb-10">Siap untuk memburu koleksi rahasia lagi?</p>
            
            <form wire:submit="login" class="space-y-6">
                <!-- Email Field -->
                <div>
                    <label class="block text-headline font-bold mb-2 uppercase tracking-wide">Kode Akses (Email)</label>
                    <input wire:model="email" type="email" class="w-full bg-background border-4 border-stroke rounded-lg px-4 py-4 text-headline font-bold focus:outline-none focus:-translate-y-1 focus:shadow-[4px_4px_0px_0px_rgba(39,35,67,1)] transition-all @error('email') border-red-500 @enderror" placeholder="agen@kira.com">
                    @error('email') <span class="text-red-500 font-bold text-sm mt-1 block">⚠️ {{ $message }}</span> @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <div class="flex justify-between mb-2">
                        <label class="block text-headline font-bold uppercase tracking-wide">Sandi Rahasia</label>
                        <a href="#" class="text-sm font-bold text-headline underline decoration-2 hover:text-button-fomo">Lupa Sandi?</a>
                    </div>
                    <input wire:model="password" type="password" class="w-full bg-background border-4 border-stroke rounded-lg px-4 py-4 text-headline font-bold focus:outline-none focus:-translate-y-1 focus:shadow-[4px_4px_0px_0px_rgba(39,35,67,1)] transition-all @error('password') border-red-500 @enderror" placeholder="••••••••">
                    @error('password') <span class="text-red-500 font-bold text-sm mt-1 block">⚠️ {{ $message }}</span> @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-button-fomo text-headline font-black text-xl py-4 border-4 border-stroke rounded-lg hover:-translate-y-1 hover:shadow-[6px_6px_0px_0px_rgba(39,35,67,1)] active:translate-y-0 active:shadow-none transition-all flex justify-center items-center gap-2 mt-4">
                    <span wire:loading.remove wire:target="login">MASUK MARKAS</span>
                    <span wire:loading wire:target="login">MENGOTENTIKASI...</span>
                </button>
            </form>

            <div class="mt-8 text-center font-bold text-paragraph">
                Belum punya akses? <a href="{{ route('register') }}" wire:navigate class="text-headline underline decoration-4 decoration-tertiary hover:bg-tertiary transition-colors">Rekrutmen Agen Baru</a>
            </div>
        </div>
    </div>

    <!-- Right Panel: Decorative Graphic -->
    <div class="hidden lg:flex w-1/2 bg-tertiary flex-col justify-center items-center relative overflow-hidden">
        <!-- Floating Elements -->
        <div class="absolute top-20 left-20 w-24 h-24 bg-button-fomo rounded-full border-4 border-stroke shadow-[8px_8px_0px_0px_rgba(39,35,67,1)] gsap-float"></div>
        <div class="absolute bottom-32 right-32 w-32 h-32 bg-secondary border-4 border-stroke rotate-12 shadow-[8px_8px_0px_0px_rgba(39,35,67,1)] gsap-float-slow"></div>
        
        <h2 class="text-8xl font-black text-headline leading-none text-center z-10" style="-webkit-text-stroke: 2px #272343; color: #fffffe; text-shadow: 8px 8px 0 #ffd803;">
            THE<br>HUNT<br>IS ON.
        </h2>
    </div>

    <!-- GSAP Animations -->
    <script>
        document.addEventListener('livewire:navigated', () => {
            if(typeof gsap !== 'undefined') {
                gsap.to('.gsap-float', { y: -30, rotation: 10, duration: 2.5, yoyo: true, repeat: -1, ease: "sine.inOut" });
                gsap.to('.gsap-float-slow', { y: 20, rotation: -15, duration: 4, yoyo: true, repeat: -1, ease: "sine.inOut" });
            }
        });
        document.addEventListener('DOMContentLoaded', () => {
            if(typeof gsap !== 'undefined') {
                gsap.to('.gsap-float', { y: -30, rotation: 10, duration: 2.5, yoyo: true, repeat: -1, ease: "sine.inOut" });
                gsap.to('.gsap-float-slow', { y: 20, rotation: -15, duration: 4, yoyo: true, repeat: -1, ease: "sine.inOut" });
            }
        });
    </script>
</div>
