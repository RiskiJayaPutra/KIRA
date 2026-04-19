<div class="flex min-h-screen">
    <!-- Left Panel: Decorative Graphic -->
    <div class="hidden lg:flex w-1/2 bg-headline flex-col justify-center items-center relative overflow-hidden border-r-4 border-stroke">
        <!-- Minimalist Floating Elements -->
        <div class="absolute top-1/4 right-1/4 w-32 h-32 bg-transparent border-4 border-tertiary shadow-[8px_8px_0px_0px_#bae8e8] gsap-float"></div>
        <div class="absolute bottom-1/4 left-1/4 w-24 h-24 bg-button-fomo border-4 border-stroke -rotate-45 shadow-[8px_8px_0px_0px_#ffd803] gsap-float-slow"></div>
        
        <h2 class="text-7xl font-black text-background leading-tight text-center z-10 uppercase tracking-tighter" style="text-shadow: 6px 6px 0 #2d334a;">
            JOIN<br>KIRA<br>SOCIETY.
        </h2>
    </div>

    <!-- Right Panel: Form -->
    <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 md:px-20 py-12 bg-background relative z-10">
        <div class="max-w-md w-full mx-auto">
            <h1 class="text-5xl font-black text-headline mb-2" style="-webkit-text-stroke: 1px #272343;">CREATE ACCOUNT.</h1>
            <p class="text-paragraph text-lg font-medium mb-8">Bergabunglah untuk akses eksklusif ke rilis <span class="font-bold">blindbox & figure premium</span>.</p>
            
            <form wire:submit="register" class="space-y-5">
                <!-- Name Field -->
                <div>
                    <label class="block text-headline font-bold mb-2 uppercase tracking-wide">Full Name</label>
                    <input wire:model="name" type="text" class="w-full bg-background border-4 border-stroke rounded-none px-4 py-3 text-headline font-bold focus:outline-none focus:-translate-y-1 focus:shadow-[4px_4px_0px_0px_rgba(39,35,67,1)] transition-all @error('name') border-red-500 @enderror" placeholder="John Doe">
                    @error('name') <span class="text-red-500 font-bold text-sm mt-1 block">⚠️ {{ $message }}</span> @enderror
                </div>

                <!-- Email Field -->
                <div>
                    <label class="block text-headline font-bold mb-2 uppercase tracking-wide">Email Address</label>
                    <input wire:model="email" type="email" class="w-full bg-background border-4 border-stroke rounded-none px-4 py-3 text-headline font-bold focus:outline-none focus:-translate-y-1 focus:shadow-[4px_4px_0px_0px_rgba(39,35,67,1)] transition-all @error('email') border-red-500 @enderror" placeholder="name@example.com">
                    @error('email') <span class="text-red-500 font-bold text-sm mt-1 block">⚠️ {{ $message }}</span> @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label class="block text-headline font-bold mb-2 uppercase tracking-wide">Password</label>
                    <input wire:model="password" type="password" class="w-full bg-background border-4 border-stroke rounded-none px-4 py-3 text-headline font-bold focus:outline-none focus:-translate-y-1 focus:shadow-[4px_4px_0px_0px_rgba(39,35,67,1)] transition-all @error('password') border-red-500 @enderror" placeholder="Minimal 8 Karakter">
                    @error('password') <span class="text-red-500 font-bold text-sm mt-1 block">⚠️ {{ $message }}</span> @enderror
                </div>

                <!-- Password Confirmation Field -->
                <div>
                    <label class="block text-headline font-bold mb-2 uppercase tracking-wide">Confirm Password</label>
                    <input wire:model="password_confirmation" type="password" class="w-full bg-background border-4 border-stroke rounded-none px-4 py-3 text-headline font-bold focus:outline-none focus:-translate-y-1 focus:shadow-[4px_4px_0px_0px_rgba(39,35,67,1)] transition-all" placeholder="Ulangi Password">
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-tertiary text-headline font-black text-xl py-4 border-4 border-stroke rounded-none hover:-translate-y-1 hover:shadow-[6px_6px_0px_0px_rgba(39,35,67,1)] active:translate-y-0 active:shadow-none transition-all flex justify-center items-center gap-2 mt-4">
                    <span wire:loading.remove wire:target="register">CREATE ACCOUNT</span>
                    <span wire:loading wire:target="register">PROCESSING...</span>
                </button>
            </form>

            <div class="mt-6 text-center font-bold text-paragraph">
                Sudah memiliki akun? <a href="{{ route('login') }}" wire:navigate class="text-headline underline decoration-4 decoration-button-fomo hover:bg-button-fomo transition-colors">Sign In</a>
            </div>
        </div>
    </div>

    <!-- GSAP Animations -->
    <script>
        document.addEventListener('livewire:navigated', () => {
            if(typeof gsap !== 'undefined') {
                gsap.to('.gsap-float', { y: -20, rotation: 15, duration: 3, yoyo: true, repeat: -1, ease: "sine.inOut" });
                gsap.to('.gsap-float-slow', { y: 20, rotation: -30, duration: 4, yoyo: true, repeat: -1, ease: "sine.inOut" });
            }
        });
        document.addEventListener('DOMContentLoaded', () => {
            if(typeof gsap !== 'undefined') {
                gsap.to('.gsap-float', { y: -20, rotation: 15, duration: 3, yoyo: true, repeat: -1, ease: "sine.inOut" });
                gsap.to('.gsap-float-slow', { y: 20, rotation: -30, duration: 4, yoyo: true, repeat: -1, ease: "sine.inOut" });
            }
        });
    </script>
</div>
