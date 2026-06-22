@extends('layouts.template', [
    'hideNav' => true,
    'hideFooter' => true,
    'bodyClasses' => 'bg-surface font-body-md text-on-surface min-h-screen flex flex-col relative overflow-x-hidden'
])

@section('title', 'Selamat Datang - Campus Queue')

@section('content')
<!-- Background Design -->
<div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-primary/20 dark:bg-emerald-900/20 blur-[120px]"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] rounded-full bg-emerald-200/40 dark:bg-emerald-800/20 blur-[120px]"></div>
    <div class="absolute top-[20%] right-[10%] w-[20%] h-[20%] rounded-full bg-amber-200/30 dark:bg-amber-900/10 blur-[80px]"></div>
</div>

<!-- Header / Nav -->
<header class="w-full p-6 flex justify-between items-center z-10 relative max-w-6xl mx-auto">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 bg-primary-container rounded-[14px] flex items-center justify-center shadow-sm">
            <span class="material-symbols-outlined text-[24px] text-on-primary-container" style="font-variation-settings: 'FILL' 1;">confirmation_number</span>
        </div>
        <h1 class="font-h1 text-xl font-bold text-on-surface">Campus Queue</h1>
    </div>
    <div class="flex items-center gap-2 sm:gap-3">
        <button @click="darkMode = !darkMode" class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-surface-container-high dark:hover:bg-white/10 transition-colors text-on-surface-variant dark:text-outline-variant">
            <span class="material-symbols-outlined text-[20px]" x-text="darkMode ? 'light_mode' : 'dark_mode'"></span>
        </button>
        <div class="w-px h-6 bg-outline-variant/30 mx-1"></div>
        <a href="{{ route('login') }}" class="px-4 sm:px-5 py-2.5 text-sm font-bold text-primary dark:text-emerald-400 hover:bg-primary-container/50 dark:hover:bg-emerald-900/30 rounded-xl transition-colors">Masuk</a>
        <a href="{{ route('register') }}" class="px-4 sm:px-5 py-2.5 text-sm font-bold bg-primary text-on-primary rounded-xl shadow-md hover:brightness-110 active:scale-95 transition-all">Daftar</a>
    </div>
</header>

<!-- Main Hero Section -->
<main class="flex-1 w-full max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 md:gap-y-0 px-4 md:px-6 py-2 md:py-4 z-10 relative mt-2 md:mt-4 mb-4">
    
    <!-- Child 1: Badge, Headline, Paragraph (Top Left on Desktop, Top on Mobile) -->
    <div class="flex flex-col items-center md:items-start text-center md:text-left order-1 md:col-start-1 md:row-start-1 md:self-end">
        <div class="inline-flex items-center gap-2 px-3 py-1.5 md:px-4 md:py-2 rounded-full bg-primary-container/50 dark:bg-emerald-900/30 text-primary dark:text-emerald-400 mb-4 md:mb-5 border border-primary/10 dark:border-emerald-800 backdrop-blur-sm">
            <span class="material-symbols-outlined text-[14px] md:text-[16px]">bolt</span>
            <span class="text-[10px] md:text-xs font-bold uppercase tracking-wider">Sistem Antrian Modern</span>
        </div>
        
        <h2 class="font-h1 text-4xl md:text-5xl lg:text-[54px] font-bold text-on-surface leading-[1.1] mb-4 md:mb-5 min-h-[120px] md:min-h-[130px]">
            <span id="t1"></span><span id="t2" class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-emerald-400"></span><span id="t3"></span><span id="typing-cursor" class="inline-block w-1 h-8 md:h-12 bg-primary dark:bg-emerald-400 ml-1 opacity-0 align-middle -mt-1 md:-mt-2"></span>
        </h2>
        
        <p class="font-body-lg text-on-surface-variant text-sm md:text-base lg:text-lg max-w-xl leading-relaxed opacity-0 translate-y-4 mb-2 md:mb-4" id="hero-desc">
            Tinggalkan antrian fisik yang melelahkan. Ambil nomor antrian dari mana saja, pantau status secara real-time, dan datang tepat waktu saat giliran Anda tiba.
        </p>
    </div>
    
    <!-- Child 2: Mockup Card (Right Side spanning 2 rows on Desktop, Middle on Mobile) -->
    <div class="w-full max-w-[260px] sm:max-w-[300px] md:max-w-sm lg:max-w-[380px] relative mx-auto md:mx-0 flex justify-center md:justify-end shrink-0 order-2 md:col-start-2 md:row-span-2 self-center md:translate-x-8 lg:translate-x-16">
        <!-- Mockup Visual -->
        <div class="relative w-full aspect-[4/5] rounded-[32px] md:rounded-[40px] bg-white border border-outline-variant/20 shadow-2xl p-5 md:p-6 flex flex-col overflow-hidden rotate-2 hover:rotate-0 transition-transform duration-500 scale-95 md:scale-100 origin-center">
            <!-- Mockup Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <div class="w-20 md:w-24 h-3 md:h-4 bg-surface-container-high rounded-full mb-2"></div>
                    <div class="w-12 md:w-16 h-2 md:h-3 bg-surface-container rounded-full"></div>
                </div>
                <div class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-primary-container flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-xs md:text-sm" style="font-variation-settings: 'FILL' 1;">person</span>
                </div>
            </div>
            
            <!-- Mockup Card -->
            <div class="bg-primary rounded-2xl md:rounded-3xl p-5 text-white mb-5 shadow-lg relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-20 h-20 bg-white/10 rounded-full blur-xl"></div>
                <div class="w-10 h-3 bg-white/20 rounded-full mb-4 md:mb-6"></div>
                <div class="flex items-end gap-2 mb-2">
                    <span class="text-4xl md:text-5xl font-bold">A-12</span>
                </div>
                <div class="w-24 md:w-32 h-2 md:h-3 bg-white/20 rounded-full"></div>
            </div>
            
            <div class="space-y-3">
                <div class="w-full h-14 md:h-16 bg-surface-container-low rounded-xl md:rounded-2xl border border-outline-variant/30 flex items-center px-3 md:px-4 gap-3">
                    <div class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-emerald-100 flex items-center justify-center">
                        <span class="material-symbols-outlined text-emerald-600 text-xs md:text-sm" style="font-variation-settings: 'FILL' 1;">notifications</span>
                    </div>
                    <div class="flex-1">
                        <div class="w-16 md:w-20 h-2 md:h-3 bg-surface-container-high rounded-full mb-1.5 md:mb-2"></div>
                        <div class="w-24 md:w-32 h-1.5 md:h-2 bg-surface-container rounded-full"></div>
                    </div>
                </div>
                <div class="w-full h-14 md:h-16 bg-surface-container-low rounded-xl md:rounded-2xl border border-outline-variant/30 flex items-center px-3 md:px-4 gap-3 opacity-70">
                    <div class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-surface-container flex items-center justify-center"></div>
                    <div class="flex-1">
                        <div class="w-20 md:w-24 h-2 md:h-3 bg-surface-container rounded-full mb-1.5 md:mb-2"></div>
                        <div class="w-12 md:w-16 h-1.5 md:h-2 bg-surface-container-low rounded-full"></div>
                    </div>
                </div>
            </div>
            
            <div class="mt-auto pt-4 md:pt-6 flex justify-center gap-2">
                <div class="w-1.5 md:w-2 h-1.5 md:h-2 rounded-full bg-primary"></div>
                <div class="w-1.5 md:w-2 h-1.5 md:h-2 rounded-full bg-surface-container-high"></div>
                <div class="w-1.5 md:w-2 h-1.5 md:h-2 rounded-full bg-surface-container-high"></div>
            </div>
        </div>
        
        <!-- Decorative floating elements -->
        <div class="absolute -left-2 sm:-left-6 top-10 sm:top-20 bg-white p-2.5 sm:p-4 rounded-xl sm:rounded-2xl shadow-xl border border-outline-variant/20 animate-bounce hidden sm:block" style="animation-duration: 3s;">
            <div class="flex items-center gap-2 sm:gap-3">
                <span class="material-symbols-outlined text-amber-500 text-sm sm:text-base" style="font-variation-settings: 'FILL' 1;">campaign</span>
                <span class="text-xs sm:text-sm font-bold text-on-surface">Giliran Anda!</span>
            </div>
        </div>
        <div class="absolute -right-2 sm:-right-6 bottom-16 sm:bottom-32 bg-white p-2.5 sm:p-4 rounded-xl sm:rounded-2xl shadow-xl border border-outline-variant/20 animate-bounce hidden sm:block" style="animation-duration: 4s; animation-delay: 1s;">
            <div class="flex items-center gap-2 sm:gap-3">
                <span class="material-symbols-outlined text-emerald-500 text-sm sm:text-base" style="font-variation-settings: 'FILL' 1;">qr_code_scanner</span>
                <span class="text-xs sm:text-sm font-bold text-on-surface">Scan & Masuk</span>
            </div>
        </div>
    </div>
    
    <!-- Child 3: Buttons and Checkmarks (Bottom Left on Desktop, Bottom on Mobile) -->
    <div class="flex flex-col items-center md:items-start text-center md:text-left order-3 md:col-start-1 md:row-start-2 md:self-start mt-6 md:mt-4">
        <div class="flex flex-col sm:flex-row gap-3 md:gap-4 w-full sm:w-auto">
            <a href="{{ route('login') }}" class="px-6 md:px-8 py-3 md:py-4 bg-primary text-on-primary rounded-xl md:rounded-2xl font-bold text-base md:text-lg shadow-[0_10px_30px_-10px_rgba(0,110,37,0.5)] hover:brightness-110 active:scale-95 transition-all flex items-center justify-center gap-2 md:gap-3 group">
                Mulai Sekarang
                <span class="material-symbols-outlined transition-transform group-hover:translate-x-1 text-[20px] md:text-[24px]">arrow_forward</span>
            </a>
            <a href="{{ route('register') }}" class="px-6 md:px-8 py-3 md:py-4 bg-surface dark:bg-transparent text-on-surface dark:text-emerald-400 border-2 border-outline-variant/30 dark:border-emerald-800 rounded-xl md:rounded-2xl font-bold text-base md:text-lg hover:bg-surface-container dark:hover:bg-emerald-900/30 hover:border-outline-variant/50 active:scale-95 transition-all flex items-center justify-center gap-2 md:gap-3">
                Buat Akun Baru
            </a>
        </div>
        
        <div class="mt-6 md:mt-8 flex items-center gap-4 md:gap-6 text-on-surface-variant justify-center md:justify-start">
            <div class="flex items-center gap-1.5 md:gap-2">
                <span class="material-symbols-outlined text-primary text-[18px] md:text-[24px]" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                <span class="text-xs md:text-sm font-medium">Real-time update</span>
            </div>
            <div class="flex items-center gap-1.5 md:gap-2">
                <span class="material-symbols-outlined text-primary text-[18px] md:text-[24px]" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                <span class="text-xs md:text-sm font-medium">Tanpa kertas</span>
            </div>
        </div>
    </div>

</main>

<footer class="w-full text-center py-8 mt-auto z-10">
    <p class="font-body-md text-xs text-on-surface-variant font-medium">© 2026 STMIK WIDYA UTAMA PURWOKERTO. Campus Queue System.</p>
</footer>

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/TextPlugin.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        gsap.registerPlugin(TextPlugin);

        // Blinking cursor
        gsap.to("#typing-cursor", {
            opacity: 1,
            repeat: -1,
            yoyo: true,
            duration: 0.5,
            ease: "steps(1)"
        });

        const tl = gsap.timeline();

        // 1. Type "Antri Lebih " (12 chars @ 0.15s/char = 1.8s)
        tl.to("#t1", {
            duration: 1.8,
            text: { value: "Antri Lebih ", delimiter: "" },
            ease: "none",
            delay: 0.5
        })
        // 2. Type "Pintar" (6 chars = 0.9s)
        .to("#t2", {
            duration: 0.9,
            text: { value: "Pintar", delimiter: "" },
            ease: "none"
        })
        // 3. Type "," (1 char = 0.15s) -> Cursor stays here!
        .to("#t3", {
            duration: 0.15,
            text: { value: ",", delimiter: "" },
            ease: "none"
        })
        // 4. Fade in description
        .to("#hero-desc", {
            opacity: 1,
            y: 0,
            duration: 0.8,
            ease: "power2.out"
        }, "+=0.2")
        // 5. Wait for the remainder of the 3 seconds, then type the rest
        // Description took 0.8s + 0.2s gap = 1.0s. Add 2.0s delay = 3.0s total pause at the comma.
        .to("#t3", {
            duration: 4.0, // 27 chars @ 0.15s/char ≈ 4.0s
            text: { value: ",<br>Tertib Antri dan Produktif.", delimiter: "" },
            ease: "none",
            delay: 2.0
        })
        // 6. Loop erasing and typing the second line
        .add(() => {
            const loopTl = gsap.timeline({ repeat: -1 });
            
            loopTl.to({}, { duration: 3 }) // Pause at the end for 3 seconds
            .to("#t3", {
                duration: 1.5, // Erase back to empty second line
                text: { value: ",<br>", delimiter: "" }, // Keep the <br>!
                ease: "none"
            })
            .to({}, { duration: 0.5 }) // Wait 0.5s before re-typing
            .to("#t3", {
                duration: 4.0, // Type it again
                text: { value: ",<br>Tertib Antri dan Produktif.", delimiter: "" },
                ease: "none"
            });
        });
    });
</script>
@endsection
@endsection
