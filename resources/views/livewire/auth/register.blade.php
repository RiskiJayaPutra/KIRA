<div class="flex min-h-screen">
    <!-- Left Panel: Decorative Graphic -->
    <div class="hidden lg:flex w-1/2 bg-secondary flex-col justify-center items-center relative overflow-hidden border-r-4 border-stroke">
        <!-- Floating Elements -->
        <div class="absolute top-32 right-20 w-24 h-24 bg-tertiary rounded-full border-4 border-stroke shadow-[8px_8px_0px_0px_rgba(39,35,67,1)] gsap-float"></div>
        <div class="absolute bottom-20 left-32 w-28 h-28 bg-button-fomo border-4 border-stroke -rotate-12 shadow-[8px_8px_0px_0px_rgba(39,35,67,1)] gsap-float-slow"></div>
        
        <h2 class="text-8xl font-black text-headline leading-none text-center z-10" style="-webkit-text-stroke: 2px #272343; color: #fffffe; text-shadow: 8px 8px 0 #bae8e8;">
            JOIN<br>THE<br>CULT.
        </h2>
    </div>

    <!-- Right Panel: Form -->
    <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 md:px-20 py-12 bg-background relative z-10">
        <div class="max-w-md w-full mx-auto">
            <h1 class="text-5xl font-black text-headline mb-2" style="-webkit-text-stroke: 1px #272343;">NEW BLOOD.</h1>
            <p class="text-paragraph text-lg font-medium mb-8">Daftarkan dirimu dan mulai memburu gacha rahasia.</p>
            
            <form wire:submit="register" class="space-y-5">
                <!-- Name Field -->
                <div>
                    <label class="block text-headline font-bold mb-2 uppercase tracking-wide">Nama Panggilan</label>
                    <input wire:model="name" type="text" class="w-full bg-background border-4 border-stroke rounded-lg px-4 py-3 text-headline font-bold focus:outline-none focus:-translate-y-1 focus:shadow-[4px_4px_0px_0px_rgba(39,35,67,1)] transition-all @error('name') border-red-500 @enderror" placeholder="Kira Hunter">
                    @error('name') <span class="text-red-500 font-bold text-sm mt-1 block">⚠️ {{ $message }}</span> @enderror
                </div>

                <!-- Email Field -->
                <div>
                    <label class="block text-headline font-bold mb-2 uppercase tracking-wide">Email</label>
                    <input wire:model="email" type="email" class="w-full bg-background border-4 border-stroke rounded-lg px-4 py-3 text-headline font-bold focus:outline-none focus:-translate-y-1 focus:shadow-[4px_4px_0px_0px_rgba(39,35,67,1)] transition-all @error('email') border-red-500 @enderror" placeholder="newblood@kira.com">
                    @error('email') <span class="text-red-500 font-bold text-sm mt-1 block">⚠️ {{ $message }}</span> @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label class="block text-headline font-bold mb-2 uppercase tracking-wide">Sandi Rahasia</label>
                    <input wire:model="password" type="password" class="w-full bg-background border-4 border-stroke rounded-lg px-4 py-3 text-headline font-bold focus:outline-none focus:-translate-y-1 focus:shadow-[4px_4px_0px_0px_rgba(39,35,67,1)] transition-all @error('password') border-red-500 @enderror" placeholder="Minimal 8 Karakter">
                    @error('password') <span class="text-red-500 font-bold text-sm mt-1 block">⚠️ {{ $message }}</span> @enderror
                </div>

                <!-- Password Confirmation Field -->
                <div>
                    <label class="block text-headline font-bold mb-2 uppercase tracking-wide">Ulangi Sandi</label>
                    <input wire:model="password_confirmation" type="password" class="w-full bg-background border-4 border-stroke rounded-lg px-4 py-3 text-headline font-bold focus:outline-none focus:-translate-y-1 focus:shadow-[4px_4px_0px_0px_rgba(39,35,67,1)] transition-all" placeholder="Pastikan Sama">
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-tertiary text-headline font-black text-xl py-4 border-4 border-stroke rounded-lg hover:-translate-y-1 hover:shadow-[6px_6px_0px_0px_rgba(39,35,67,1)] active:translate-y-0 active:shadow-none transition-all flex justify-center items-center gap-2 mt-4">
                    <span wire:loading.remove wire:target="register">REKRUT SAYA</span>
                    <span wire:loading wire:target="register">MENCATAT IDENTITAS...</span>
                </button>
            </form>

            <div class="mt-6 text-center font-bold text-paragraph">
                Sudah punya akses? <a href="{{ route('login') }}" wire:navigate class="text-headline underline decoration-4 decoration-button-fomo hover:bg-button-fomo transition-colors">Masuk ke Markas</a>
            </div>
        </div>
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
