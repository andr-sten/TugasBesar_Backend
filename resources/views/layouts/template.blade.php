<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'Campus Queue')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://code.responsivevoice.org/responsivevoice.js?key=z2C6ZEKr"></script>
    <script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "on-error": "#ffffff",
                    "surface-dim": "#d8dbd3",
                    "outline-variant": "#bdcab9",
                    "tertiary": "#5b5f5c",
                    "on-tertiary-fixed-variant": "#444844",
                    "surface-variant": "#e0e4db",
                    "secondary-fixed-dim": "#b1cfa7",
                    "tertiary-container": "#8f938f",
                    "on-tertiary-fixed": "#191c1a",
                    "on-tertiary": "#ffffff",
                    "surface-tint": "#006e25",
                    "on-primary-fixed": "#002106",
                    "on-error-container": "#93000a",
                    "inverse-primary": "#66df75",
                    "error-container": "#ffdad6",
                    "surface": "#f7faf2",
                    "primary-fixed": "#83fc8e",
                    "surface-container-high": "#e6e9e1",
                    "on-secondary-fixed-variant": "#334d2f",
                    "primary": "#006e25",
                    "on-primary": "#ffffff",
                    "surface-container-lowest": "#ffffff",
                    "surface-bright": "#f7faf2",
                    "on-secondary-container": "#4f6a49",
                    "on-surface": "#191d18",
                    "on-background": "#191d18",
                    "on-surface-variant": "#3e4a3c",
                    "primary-fixed-dim": "#66df75",
                    "on-primary-container": "#00330d",
                    "surface-container-low": "#f2f5ec",
                    "secondary-container": "#c9e8bf",
                    "outline": "#6e7b6b",
                    "inverse-surface": "#2d322c",
                    "inverse-on-surface": "#eff2e9",
                    "on-secondary": "#ffffff",
                    "on-tertiary-container": "#282c29",
                    "tertiary-fixed-dim": "#c4c7c3",
                    "on-primary-fixed-variant": "#00531a",
                    "tertiary-fixed": "#e0e3df",
                    "primary-container": "#28a745",
                    "secondary-fixed": "#ccebc2",
                    "error": "#ba1a1a",
                    "secondary": "#4a6545",
                    "surface-container": "#ecefe7",
                    "on-secondary-fixed": "#082007",
                    "surface-container-highest": "#e0e4db",
                    "background": "#f7faf2"
            },
            "borderRadius": {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "full": "9999px"
            },
            "spacing": {
                    "card-gap": "20px",
                    "container-padding": "24px",
                    "lg": "32px",
                    "xs": "4px",
                    "sm": "12px",
                    "xl": "48px",
                    "md": "20px",
                    "base": "8px"
            },
            "fontFamily": {
                    "h1": ["Plus Jakarta Sans"],
                    "label-sm": ["Plus Jakarta Sans"],
                    "body-lg": ["Plus Jakarta Sans"],
                    "body-md": ["Plus Jakarta Sans"],
                    "h2": ["Plus Jakarta Sans"]
            },
            "fontSize": {
                    "h1": ["32px", {"lineHeight": "1.2", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                    "label-sm": ["12px", {"lineHeight": "1", "letterSpacing": "0.01em", "fontWeight": "600"}],
                    "body-lg": ["16px", {"lineHeight": "1.6", "fontWeight": "500"}],
                    "body-md": ["14px", {"lineHeight": "1.5", "fontWeight": "400"}],
                    "h2": ["24px", {"lineHeight": "1.3", "fontWeight": "600"}]
            }
          },
        },
      }
    </script>
    <style type="text/tailwindcss">
        html {
            scroll-behavior: smooth;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid #E8EEE7;
            border-radius: 24px;
        }
        .dark .glass-card {
            background: rgba(45, 50, 44, 0.7);
            border: 1px solid #6e7b6b;
            color: theme('colors.inverse-on-surface');
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        
        /* Dark Mode Overrides for Custom Theme Colors */
        .font-h1 { font-weight: 700 !important; }
        .dark .text-on-surface { color: theme('colors.inverse-on-surface'); }
        .dark .text-on-surface-variant { color: theme('colors.outline-variant'); }
        .dark .bg-surface-container-low { background-color: rgba(0, 0, 0, 0.2); }
        .dark .bg-surface-container { background-color: theme('colors.inverse-surface') !important; color: theme('colors.inverse-on-surface') !important; }
        .dark .bg-surface-container-high { background-color: rgba(0, 0, 0, 0.3) !important; color: theme('colors.inverse-on-surface') !important; }
        .dark .border-emerald-50 { border-color: theme('colors.outline'); }
        .dark .bg-emerald-100 { background-color: rgba(0, 110, 37, 0.2); color: theme('colors.emerald.300'); }
        .dark .text-emerald-800 { color: theme('colors.emerald.300'); }
        .dark .bg-amber-100 { background-color: rgba(217, 119, 6, 0.2); color: theme('colors.amber.300'); }
        .dark .text-amber-700 { color: theme('colors.amber.300'); }
        .dark .bg-blue-100 { background-color: rgba(37, 99, 235, 0.2); color: theme('colors.blue.300'); }
        .dark .text-blue-700 { color: theme('colors.blue.300'); }
        .dark .bg-white { background-color: theme('colors.inverse-surface'); }
        
        /* Table and Hover Adjustments */
        .glass-card:hover, button:hover, .hover\:border-primary\/30:hover { 
            border-color: theme('colors.primary') !important; 
            box-shadow: 0 0 0 1px theme('colors.primary') !important; 
        }
        
        .dark .hover\:bg-surface-container-low:hover { background-color: rgba(255, 255, 255, 0.08) !important; }
        .dark table th { color: theme('colors.outline-variant'); border-bottom-color: rgba(110, 123, 107, 0.3); }
        .dark table td { color: theme('colors.inverse-on-surface'); }
        .dark .divide-emerald-50\/50 > :not([hidden]) ~ :not([hidden]) { border-color: rgba(110, 123, 107, 0.3); }
        .dark input, .dark select, .dark textarea { background-color: rgba(0, 0, 0, 0.3) !important; border: 1px solid theme('colors.outline') !important; color: white !important; }
        .dark .text-slate-600 { color: theme('colors.slate.300'); }
        .dark .hover\:text-emerald-600:hover { color: theme('colors.emerald.400'); }
        .dark .bg-emerald-50 { background-color: rgba(0, 110, 37, 0.2); }
        /* Form Autofill Fixes for Dark Mode */
        .dark input:-webkit-autofill,
        .dark input:-webkit-autofill:hover,
        .dark input:-webkit-autofill:focus,
        .dark input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px #2d322c inset !important;
            -webkit-text-fill-color: white !important;
            transition: background-color 5000s ease-in-out 0s;
        }
        
        [x-cloak] { display: none !important; }
    </style>
    @yield('styles')
</head>
<body class="{{ $bodyClasses ?? 'bg-background font-body-md text-on-background min-h-screen' }} dark:bg-inverse-surface dark:text-inverse-on-surface transition-colors duration-300" 
      x-data="{ 
          mobileMenuOpen: false,
          darkMode: localStorage.getItem('theme') === 'dark',
          showComingSoon: false,
          showConfirmModal: false,
          confirmMessage: '',
          confirmFormId: '',
          showCallModal: {{ session('panggil_nomor') ? 'true' : 'false' }},
          callNomor: '{{ session('panggil_nomor') ?? '' }}',
          callLoket: '{{ session('panggil_loket') ?? '' }}',
          openConfirm(formId, message) {
              this.confirmFormId = formId;
              this.confirmMessage = message;
              this.showConfirmModal = true;
          }
      }"
      @show-call.window="callNomor = $event.detail.nomor; callLoket = $event.detail.loket; showCallModal = true"
      x-init="$watch('darkMode', val => { 
          localStorage.setItem('theme', val ? 'dark' : 'light'); 
          val ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove('dark');
      }); 
      if (darkMode) document.documentElement.classList.add('dark');
      ">
    <script src="https://cdn.jsdelivr.net/npm/qrcode-generator/qrcode.min.js"></script>
    @if(!isset($hideNav))
    <nav class="fixed top-0 w-full z-50 flex items-center justify-between px-4 md:px-8 h-16 bg-white/70 dark:bg-inverse-surface/80 backdrop-blur-xl border-b border-emerald-50 dark:border-outline shadow-sm transition-colors duration-300">
        <div class="flex items-center gap-4 md:gap-8">
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                <span class="material-symbols-outlined" x-text="mobileMenuOpen ? 'close' : 'menu'">menu</span>
            </button>
            <span class="text-lg md:text-xl font-bold text-emerald-900 dark:text-emerald-100 font-h1 tracking-tight">Campus Queue</span>
            <div class="hidden md:flex gap-6">
                @if(Auth::check() && Auth::user()->role === 'admin')
                    <a class="{{ request()->routeIs('dashboard') ? 'text-emerald-700 font-semibold border-b-2 border-emerald-600 pb-1' : 'text-slate-600 font-medium hover:text-emerald-600' }} transition-colors font-body-md" href="{{ route('dashboard') }}">Beranda</a>
                    <a class="{{ request()->routeIs('admin.layanan.*') ? 'text-emerald-700 font-semibold border-b-2 border-emerald-600 pb-1' : 'text-slate-600 font-medium hover:text-emerald-600' }} transition-colors font-body-md" href="{{ route('admin.layanan.index') }}">Kelola Layanan</a>
                    <a class="{{ request()->routeIs('admin.jadwal.*') ? 'text-emerald-700 font-semibold border-b-2 border-emerald-600 pb-1' : 'text-slate-600 font-medium hover:text-emerald-600' }} transition-colors font-body-md" href="{{ route('admin.jadwal.index') }}">Kelola Jadwal</a>
                    <a class="{{ request()->routeIs('admin.antrian') ? 'text-emerald-700 font-semibold border-b-2 border-emerald-600 pb-1' : 'text-slate-600 font-medium hover:text-emerald-600' }} transition-colors font-body-md" href="{{ route('admin.antrian') }}">Manajemen Antrian</a>
                @else
                    <a class="{{ request()->routeIs('dashboard') ? 'text-emerald-700 font-semibold border-b-2 border-emerald-600 pb-1' : 'text-slate-600 font-medium hover:text-emerald-600' }} transition-colors font-body-md" href="{{ route('dashboard') }}">Beranda</a>
                    <a class="{{ request()->routeIs('mahasiswa.layanan.index') ? 'text-emerald-700 font-semibold border-b-2 border-emerald-600 pb-1' : 'text-slate-600 font-medium hover:text-emerald-600' }} transition-colors font-body-md" href="{{ route('mahasiswa.layanan.index') }}">Semua Layanan</a>
                @endif
            </div>
        </div>
        <div class="flex items-center gap-2 md:gap-4">
            @if(Auth::check() && Auth::user()->role === 'admin')
            <a href="{{ route('register') }}?role=admin" class="hidden sm:flex items-center gap-2 px-3 md:px-4 py-2 bg-secondary/10 dark:bg-secondary-fixed/20 text-secondary dark:text-secondary-fixed rounded-xl font-bold text-xs md:text-sm hover:bg-secondary/20 dark:hover:bg-secondary-fixed/30 transition-all border border-transparent">
                <span class="material-symbols-outlined text-[18px] md:text-[20px]">person_add</span>
                <span class="hidden lg:inline">Tambah Admin</span>
            </a>
            @endif
            <button @click="darkMode = !darkMode" class="p-2 text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors active:scale-95 duration-200" title="Toggle Dark Mode">
                <span class="material-symbols-outlined" x-text="darkMode ? 'light_mode' : 'dark_mode'">light_mode</span>
            </button>
            <button class="p-2 text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors active:scale-95 duration-200">
                <span class="material-symbols-outlined">notifications</span>
            </button>
            <div class="flex items-center gap-2 md:gap-3 pl-2 md:pl-4 border-l border-emerald-100 dark:border-outline">
                <span class="hidden sm:inline font-body-md font-semibold text-emerald-900 dark:text-emerald-100">{{ Auth::user()->name ?? 'Guest' }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="material-symbols-outlined text-slate-600 dark:text-slate-300 hover:text-error dark:hover:text-error transition-colors flex items-center">logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu Overlay -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="fixed top-16 left-0 w-full bg-white dark:bg-inverse-surface z-40 border-b border-emerald-50 dark:border-outline shadow-xl md:hidden"
         @click.away="mobileMenuOpen = false">
        <div class="flex flex-col p-4 gap-2">
            @if(Auth::check() && Auth::user()->role === 'admin')
                <a class="p-3 {{ request()->routeIs('dashboard') ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-slate-600' }} rounded-xl transition-all" href="{{ route('dashboard') }}">Beranda</a>
                <a class="p-3 {{ request()->routeIs('admin.layanan.*') ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-slate-600' }} rounded-xl transition-all" href="{{ route('admin.layanan.index') }}">Kelola Layanan</a>
                <a class="p-3 {{ request()->routeIs('admin.jadwal.*') ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-slate-600' }} rounded-xl transition-all" href="{{ route('admin.jadwal.index') }}">Kelola Jadwal</a>
                <a class="p-3 {{ request()->routeIs('admin.antrian') ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-slate-600' }} rounded-xl transition-all" href="{{ route('admin.antrian') }}">Manajemen Antrian</a>
            @else
                <a class="p-3 {{ request()->routeIs('dashboard') ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-slate-600' }} rounded-xl transition-all" href="{{ route('dashboard') }}">Beranda</a>
                <a class="p-3 {{ request()->routeIs('mahasiswa.layanan.index') ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-slate-600' }} rounded-xl transition-all" href="{{ route('mahasiswa.layanan.index') }}">Semua Layanan</a>
            @endif
            
            @if(Auth::check() && Auth::user()->role === 'admin')
            <div class="mt-4 pt-4 border-t border-emerald-50">
                <a href="{{ route('register') }}?role=admin" class="flex items-center justify-center gap-2 px-4 py-3 bg-secondary/10 text-secondary rounded-xl font-bold text-sm">
                    <span class="material-symbols-outlined">person_add</span>
                    Tambah Admin Baru
                </a>
            </div>
            @endif
        </div>
    </div>
    @endif

    @yield('content')

    @if(!isset($hideFooter))
    <footer class="w-full flex flex-col items-center justify-center gap-4 px-4 full-width py-8 mt-auto bg-white dark:bg-inverse-surface border-t border-emerald-50 dark:border-outline transition-colors duration-300">
        <div class="flex gap-6 mb-2">
            <a @click.prevent="showComingSoon = true" class="text-slate-500 dark:text-slate-300 font-medium hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors text-xs font-['Plus_Jakarta_Sans']" href="#">Bantuan</a>
            <a @click.prevent="showComingSoon = true" class="text-slate-500 dark:text-slate-300 font-medium hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors text-xs font-['Plus_Jakarta_Sans']" href="#">Privasi</a>
            <a @click.prevent="showComingSoon = true" class="text-slate-500 dark:text-slate-300 font-medium hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors text-xs font-['Plus_Jakarta_Sans']" href="#">Kontak Kami</a>
        </div>
        <p class="font-['Plus_Jakarta_Sans'] text-xs text-center text-slate-400 dark:text-slate-300">© 2026 STMIK WIDYA UTAMA PURWOKERTO. Sistem Antrian Digital.</p>
    </footer>
    @endif
    <!-- Global Alert Modal -->
    @php
        $alertSuccess = session()->pull('persistent_success') ?? session('success');
        $alertError = session()->pull('persistent_error') ?? session('error');
        $alertStatus = session()->pull('persistent_status') ?? session('status');
        
        $panggilId = session()->pull('persistent_panggil_id') ?? session('panggil_id');
        $panggilNomor = session()->pull('persistent_panggil_nomor') ?? session('panggil_nomor');
        $panggilLoket = session()->pull('persistent_panggil_loket') ?? session('panggil_loket');
        
        $hasAlert = $alertSuccess || $alertError || $alertStatus || $errors->any();
        $alertType = $alertSuccess ? 'success' : ($alertError || $errors->any() ? 'error' : ($alertStatus ? 'info' : ''));
        $alertMessage = $alertSuccess ?? $alertError ?? $alertStatus ?? ($errors->any() ? $errors->first() : '');
    @endphp
    
    @if($panggilNomor)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nomor = "{{ $panggilNomor }}".split('').join(' ');
            const loket = "{{ $panggilLoket ?? 'Loket 1' }}";
            const text = `Nomor antrian, A, ${nomor}, silakan menuju ke ${loket}`;
            
            setTimeout(() => {
                if (window.responsiveVoice) {
                    responsiveVoice.speak(text, "Indonesian Female", { rate: 0.9, pitch: 1 });
                }
            }, 500);
        });
    </script>
    @endif
    
    <div x-data="{ 
            show: {{ $hasAlert ? 'true' : 'false' }}, 
            type: '{{ $alertType }}', 
            message: '{!! addslashes($alertMessage) !!}' 
         }" 
         @show-alert.window="type = $event.detail.type; message = $event.detail.message; show = true"
         x-cloak x-show="show" class="fixed inset-0 z-[100] flex items-center justify-center">
        
        <!-- Backdrop -->
        <div x-show="show" 
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 backdrop-blur-none" x-transition:enter-end="opacity-100 backdrop-blur-md"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 backdrop-blur-md" x-transition:leave-end="opacity-0 backdrop-blur-none"
             class="absolute inset-0 bg-slate-900/40 dark:bg-black/60 backdrop-blur-md"
             @click="show = false"></div>
        
        <!-- Content -->
        <div x-show="show"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="relative bg-white dark:bg-inverse-surface rounded-3xl p-8 max-w-sm w-full mx-4 shadow-2xl border border-emerald-50 dark:border-outline text-center flex flex-col items-center">
            
            <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4" 
                 :class="{
                    'bg-emerald-100 text-emerald-600 dark:bg-emerald-900/50 dark:text-emerald-400': type === 'success',
                    'bg-red-100 text-red-600 dark:bg-red-900/50 dark:text-red-400': type === 'error',
                    'bg-blue-100 text-blue-600 dark:bg-blue-900/50 dark:text-blue-400': type === 'info'
                 }">
                <span class="material-symbols-outlined text-4xl" x-text="type === 'success' ? 'check_circle' : (type === 'error' ? 'error' : 'info')"></span>
            </div>
            <h3 class="text-xl font-bold font-h1 text-on-surface dark:text-inverse-on-surface mb-2" x-text="type === 'success' ? 'Berhasil!' : (type === 'error' ? 'Peringatan!' : 'Informasi')"></h3>
            <p class="text-sm text-on-surface-variant dark:text-outline-variant mb-4" x-text="message"></p>
            
            @if($panggilId && Auth::check() && Auth::user()->role === 'admin')
            <p class="text-2xl font-bold text-primary mb-6">A-{{ $panggilNomor }}</p>
            <div class="w-full flex flex-col gap-3">
                <form action="{{ route('admin.antrian.updateStatus', $panggilId) }}" method="POST" class="w-full">
                    @csrf
                    <input type="hidden" name="status" value="dipanggil">
                    <button type="submit" class="w-full py-3 px-4 bg-blue-600 text-white rounded-xl font-bold hover:brightness-110 transition-all active:scale-95 flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">volume_up</span> Panggil Lagi
                    </button>
                </form>
                <form action="{{ route('admin.antrian.updateStatus', $panggilId) }}" method="POST" class="w-full">
                    @csrf
                    <input type="hidden" name="status" value="selesai">
                    <button type="submit" @click="show = false" class="w-full py-3 px-4 bg-emerald-600 text-white rounded-xl font-bold hover:brightness-110 transition-all active:scale-95 flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">check</span> Selesai
                    </button>
                </form>
                <button @click="show = false" class="w-full mt-2 py-2 px-4 bg-surface-variant text-on-surface-variant dark:bg-white/10 dark:text-white rounded-xl font-bold hover:brightness-95 transition-all active:scale-95">Tutup Dialog</button>
            </div>
            @else
            <button @click="show = false" class="w-full mt-2 py-3 px-4 bg-primary text-white rounded-xl font-bold hover:brightness-110 transition-all active:scale-95">Tutup</button>
            @endif
        </div>
    </div>

    <!-- Confirm Modal -->
    <div x-cloak x-show="showConfirmModal" class="fixed inset-0 z-[100] flex items-center justify-center">
        <div x-show="showConfirmModal" 
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 backdrop-blur-none" x-transition:enter-end="opacity-100 backdrop-blur-md"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 backdrop-blur-md" x-transition:leave-end="opacity-0 backdrop-blur-none"
             class="absolute inset-0 bg-slate-900/40 dark:bg-black/60 backdrop-blur-md"
             @click="showConfirmModal = false"></div>
        
        <div x-show="showConfirmModal"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="relative bg-white dark:bg-inverse-surface rounded-3xl p-8 max-w-sm w-full mx-4 shadow-2xl border border-emerald-50 dark:border-outline text-center flex flex-col items-center">
            
            <div class="w-16 h-16 rounded-full bg-amber-100 text-amber-600 dark:bg-amber-900/50 dark:text-amber-400 flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-4xl">help</span>
            </div>
            <h3 class="text-xl font-bold font-h1 text-on-surface dark:text-inverse-on-surface mb-2">Konfirmasi</h3>
            <p class="text-sm text-on-surface-variant dark:text-outline-variant mb-6" x-text="confirmMessage"></p>
            <div class="w-full flex gap-3">
                <button @click="showConfirmModal = false" class="flex-1 py-3 px-4 bg-surface-variant text-on-surface-variant dark:bg-white/10 dark:text-white dark:hover:bg-white/20 rounded-xl font-bold hover:brightness-95 transition-all active:scale-95">Batal</button>
                <button @click="window.isNavigating = true; document.getElementById(confirmFormId).submit(); showConfirmModal = false;" class="flex-1 py-3 px-4 bg-error-container text-on-error-container dark:bg-red-900/80 dark:text-red-100 rounded-xl font-bold hover:brightness-95 transition-all active:scale-95">Yakin</button>
            </div>
        </div>
    </div>

    <!-- Call Modal -->
    <div x-cloak x-show="showCallModal" class="fixed inset-0 z-[100] flex items-center justify-center">
        <div x-show="showCallModal" 
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 backdrop-blur-none" x-transition:enter-end="opacity-100 backdrop-blur-md"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 backdrop-blur-md" x-transition:leave-end="opacity-0 backdrop-blur-none"
             class="absolute inset-0 bg-slate-900/40 dark:bg-black/60 backdrop-blur-md"
             @click="showCallModal = false"></div>
        
        <div x-show="showCallModal"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="relative bg-white dark:bg-inverse-surface rounded-3xl p-8 max-w-sm w-full mx-4 shadow-2xl border border-emerald-50 dark:border-outline text-center flex flex-col items-center">
            
            <div class="w-20 h-20 rounded-full bg-emerald-100 text-emerald-600 dark:bg-emerald-900/50 dark:text-emerald-400 flex items-center justify-center mb-4 animate-bounce">
                <span class="material-symbols-outlined text-5xl">campaign</span>
            </div>
            <h3 class="text-2xl font-bold font-h1 text-on-surface dark:text-inverse-on-surface mb-2">Panggilan!</h3>
            <p class="text-md text-on-surface-variant dark:text-outline-variant mb-6">
                Nomor antrian <strong class="text-primary text-xl" x-text="'A-' + callNomor"></strong><br>
                silakan menuju ke <strong class="text-primary" x-text="callLoket"></strong>
            </p>
            <button @click="showCallModal = false; window.dispatchEvent(new CustomEvent('call-closed'));" class="w-full py-3 px-4 bg-primary text-white rounded-xl font-bold hover:brightness-110 transition-all active:scale-95">Siap, Menuju Loket</button>
        </div>
    </div>

    <!-- Coming Soon Modal -->
    <div x-cloak x-show="showComingSoon" class="fixed inset-0 z-[100] flex items-center justify-center">
        <div x-show="showComingSoon" 
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 backdrop-blur-none" x-transition:enter-end="opacity-100 backdrop-blur-md"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 backdrop-blur-md" x-transition:leave-end="opacity-0 backdrop-blur-none"
             class="absolute inset-0 bg-slate-900/40 dark:bg-black/60 backdrop-blur-md"
             @click="showComingSoon = false"></div>
        
        <div x-show="showComingSoon"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="relative bg-white dark:bg-inverse-surface rounded-3xl p-8 max-w-sm w-full mx-4 shadow-2xl border border-emerald-50 dark:border-outline text-center flex flex-col items-center">
            
            <div class="w-16 h-16 rounded-full bg-amber-100 text-amber-600 dark:bg-amber-900/50 dark:text-amber-400 flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-4xl">construction</span>
            </div>
            <h3 class="text-xl font-bold font-h1 text-on-surface dark:text-inverse-on-surface mb-2">Segera Hadir</h3>
            <p class="text-sm text-on-surface-variant dark:text-outline-variant mb-6">Fitur ini akan segera tersedia. Kami sedang mengembangkannya untuk Anda.</p>
            <button @click="showComingSoon = false" class="w-full py-3 px-4 bg-primary text-white rounded-xl font-bold hover:brightness-110 transition-all active:scale-95">Mengerti</button>
        </div>
    </div>

    @yield('scripts')
</body>
</html>
