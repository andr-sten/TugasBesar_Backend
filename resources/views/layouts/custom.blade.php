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
    <style>
        html {
            scroll-behavior: smooth;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid #E8EEE7;
            border-radius: 24px;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
    @yield('styles')
</head>
<body class="{{ $bodyClasses ?? 'bg-background font-body-md text-on-background min-h-screen' }}" x-data="{ mobileMenuOpen: false }">
    <script src="https://cdn.jsdelivr.net/npm/qrcode-generator/qrcode.min.js"></script>
    @if(!isset($hideNav))
    <nav class="fixed top-0 w-full z-50 flex items-center justify-between px-4 md:px-8 h-16 bg-white/70 backdrop-blur-xl border-b border-emerald-50 shadow-sm">
        <div class="flex items-center gap-4 md:gap-8">
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 text-slate-600 hover:text-emerald-600 transition-colors">
                <span class="material-symbols-outlined" x-text="mobileMenuOpen ? 'close' : 'menu'">menu</span>
            </button>
            <span class="text-lg md:text-xl font-bold text-emerald-900 font-h1 tracking-tight">Campus Queue</span>
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
            <a href="{{ route('register') }}?role=admin" class="hidden sm:flex items-center gap-2 px-3 md:px-4 py-2 bg-secondary/10 text-secondary rounded-xl font-bold text-xs md:text-sm hover:bg-secondary/20 transition-all">
                <span class="material-symbols-outlined text-[18px] md:text-[20px]">person_add</span>
                <span class="hidden lg:inline">Tambah Admin</span>
            </a>
            @endif
            <button class="p-2 text-slate-600 hover:text-emerald-600 transition-colors active:scale-95 duration-200">
                <span class="material-symbols-outlined">notifications</span>
            </button>
            <div class="flex items-center gap-2 md:gap-3 pl-2 md:pl-4 border-l border-emerald-100">
                <span class="hidden sm:inline font-body-md font-semibold text-emerald-900">{{ Auth::user()->name ?? 'Guest' }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="material-symbols-outlined text-slate-600 hover:text-error transition-colors flex items-center">logout</button>
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
         class="fixed top-16 left-0 w-full bg-white z-40 border-b border-emerald-50 shadow-xl md:hidden"
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
    <footer class="w-full flex flex-col items-center justify-center gap-4 px-4 full-width py-8 mt-auto bg-white border-t border-emerald-50">
        <div class="flex gap-6 mb-2">
            <a class="text-slate-400 font-medium hover:text-emerald-700 transition-colors text-xs font-['Plus_Jakarta_Sans']" href="#">Bantuan</a>
            <a class="text-slate-400 font-medium hover:text-emerald-700 transition-colors text-xs font-['Plus_Jakarta_Sans']" href="#">Privasi</a>
            <a class="text-slate-400 font-medium hover:text-emerald-700 transition-colors text-xs font-['Plus_Jakarta_Sans']" href="#">Kontak Kami</a>
        </div>
        <p class="font-['Plus_Jakarta_Sans'] text-xs text-center text-slate-400">© 2026 STMIK WIDYA UTAMA PURWOKERTO. Sistem Antrian Digital.</p>
    </footer>
    @endif

    @yield('scripts')
</body>
</html>
