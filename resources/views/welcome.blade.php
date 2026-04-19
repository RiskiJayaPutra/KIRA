<x-layouts.app title="Kira.com - The Premium Blindbox Experience">
    
    {{-- HERO SECTION --}}
    <section class="relative w-full min-h-[90vh] bg-secondary flex flex-col items-center justify-center overflow-hidden border-b-4 border-stroke pt-12 pb-24">
        
        <!-- Decorative Elements for Pop Art Vibe -->
        <div class="absolute top-10 left-10 w-32 h-32 bg-button-fomo rounded-full border-4 border-stroke shadow-[8px_8px_0px_0px_rgba(39,35,67,1)] opacity-70 hero-deco z-0"></div>
        <div class="absolute bottom-20 right-20 w-40 h-40 bg-tertiary rounded-xl border-4 border-stroke shadow-[8px_8px_0px_0px_rgba(39,35,67,1)] rotate-12 hero-deco z-0"></div>
        <div class="absolute top-1/4 right-1/4 w-16 h-16 bg-background rounded-full border-4 border-stroke opacity-50 hero-deco-fast z-0"></div>

        <div class="z-10 text-center max-w-4xl px-4 flex flex-col items-center">
            <div class="badge-community bg-background mb-6 px-6 py-2 text-sm hero-stagger shadow-[4px_4px_0px_0px_rgba(39,35,67,1)] font-black">✨ THE NEXT DROP IS COMING</div>
            
            <h1 class="text-6xl md:text-8xl font-black text-headline leading-tight tracking-tight mb-6 hero-stagger" style="-webkit-text-stroke: 2px #272343; color: #fffffe; text-shadow: 8px 8px 0 #ffd803;">
                UNBOX YOUR <br> OBSESSION.
            </h1>
            
            <p class="text-xl md:text-2xl font-medium text-paragraph mb-10 max-w-2xl hero-stagger">
                Platform kurasi <span class="font-bold underline decoration-button-fomo decoration-4">blindbox & figure premium</span> paling brutal. Jangan sampai kehabisan secret character idamanmu.
            </p>
            
            <div class="flex flex-wrap gap-4 justify-center hero-stagger">
                <button class="btn-fomo text-xl px-10 py-5">
                    EXPLORE CATALOG 🚀
                </button>
                <button class="bg-background text-headline font-black tracking-wide py-5 px-10 rounded-lg border-4 border-stroke transition-transform hover:-translate-y-2 hover:shadow-[6px_6px_0px_0px_rgba(39,35,67,1)] shadow-[4px_4px_0px_0px_rgba(39,35,67,1)]">
                    VIEW DROPS
                </button>
            </div>
        </div>
    </section>

    {{-- LIVEWIRE SEARCH INTEGRATION (FASE 10) --}}
    <section class="py-24 bg-background border-b-4 border-stroke relative z-20 -mt-8 rounded-t-[3rem] shadow-[0px_-10px_0px_0px_rgba(39,35,67,1)]">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12 section-header opacity-0 translate-y-10">
                <h2 class="text-4xl md:text-6xl font-black text-headline mb-4 uppercase" style="text-shadow: 4px 4px 0 #bae8e8;">HUNT THE SECRETS</h2>
                <p class="text-xl text-paragraph font-medium">Gunakan radar instan kami untuk melacak figure langka incaranmu.</p>
            </div>
            
            <!-- Livewire Component from Fase 10 -->
            <div class="search-box opacity-0 scale-95 max-w-4xl mx-auto">
                <livewire:catalog-search />
            </div>
        </div>
    </section>

    {{-- FOOTER / TEASER --}}
    <footer class="bg-headline py-12 text-center text-secondary border-t-4 border-stroke">
        <h3 class="text-2xl font-black mb-4">KIRA.COM &copy; 2026</h3>
        <p class="text-tertiary">Pioneering the Next Generation of Hype.</p>
    </footer>

    {{-- GSAP Script Init --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            gsap.registerPlugin(ScrollTrigger);

            // Hero Animation: Bouncy Entrance
            gsap.fromTo('.hero-stagger', 
                { y: 60, opacity: 0 }, 
                { y: 0, opacity: 1, duration: 0.9, stagger: 0.15, ease: "back.out(1.7)" }
            );

            // Floating Decorative Elements
            gsap.to('.hero-deco', {
                y: -40,
                rotation: 10,
                duration: 3,
                yoyo: true,
                repeat: -1,
                ease: "sine.inOut"
            });
            gsap.to('.hero-deco-fast', {
                y: 30,
                rotation: -15,
                duration: 1.5,
                yoyo: true,
                repeat: -1,
                ease: "sine.inOut"
            });

            // Scroll Animation for Search Section
            gsap.to('.section-header', {
                scrollTrigger: {
                    trigger: '.section-header',
                    start: 'top 80%',
                },
                y: 0,
                opacity: 1,
                duration: 0.8,
                ease: "power3.out"
            });

            // Pop-in Search Box
            gsap.to('.search-box', {
                scrollTrigger: {
                    trigger: '.search-box',
                    start: 'top 85%',
                },
                scale: 1,
                opacity: 1,
                duration: 0.6,
                delay: 0.2,
                ease: "back.out(1.5)"
            });
        });
    </script>
</x-layouts.app>
