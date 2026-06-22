@extends('layouts.template')

@section('title', 'Dashboard - Campus Queue')

@section('content')
<main class="pt-24 pb-12 px-8 max-w-7xl mx-auto"
      x-data="{ selectedDashboardLayanan: null, showQrModal: false }"
      @open-layanan.window="selectedDashboardLayanan = $event.detail.id">

    <!-- Wrap content to apply blur -->
    <div :class="(selectedDashboardLayanan || showQrModal) ? 'blur-md pointer-events-none transition-all duration-300' : 'transition-all duration-300'">
        <header class="mb-10">
            <h1 class="font-h1 text-h1 text-on-surface mb-2">Selamat datang, <span class="text-primary">{{ Auth::user()->name }}</span>.</h1>
            <p class="text-on-surface-variant font-body-lg">Pantau antrianmu dan kelola keperluan kampus dengan lebih efisien hari ini.</p>
        </header>

        @if($antrianAktif && $antrianAktif->status === 'dipanggil')
        <div class="mb-8 p-5 bg-primary/10 border border-primary/20 rounded-2xl flex items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-primary rounded-xl flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-white text-[28px]">campaign</span>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-primary">Panggilan Antrian</h2>
                    <p class="text-on-surface-variant text-sm">Antrian Anda sedang dipanggil. Silakan menuju ke <span class="font-bold text-on-surface">{{ $antrianAktif->nomor_meja ?? 'Loket 1' }}</span> sekarang.</p>
                </div>
            </div>
            <div class="hidden md:block">
                <span class="px-4 py-2 bg-primary text-on-primary rounded-full text-xs font-bold uppercase tracking-wider">Sedang Dipanggil</span>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-card-gap">
            <section class="lg:col-span-8 flex flex-col gap-card-gap">
                @if($antrianAktif)
                <div class="glass-card p-lg relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full -mr-20 -mt-20 blur-3xl group-hover:bg-primary/10 transition-colors"></div>
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-base">
                            <span class="inline-flex items-center gap-2 px-4 py-1 bg-secondary-container text-on-secondary-container rounded-full text-label-sm">
                                <span class="material-symbols-outlined text-[16px]" style="font-variation-settings: 'FILL' 1;">confirmation_number</span>
                                Tiket Aktif
                            </span>
                            <div class="text-right">
                                <p class="text-label-sm text-on-surface-variant uppercase tracking-wider">Estimasi Waktu</p>
                                <p class="font-h2 text-h2 text-primary">~{{ $antrianAktif->layanan->durasi ?? '15' }} Menit</p>
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row items-center gap-10 mt-6">
                            <div class="flex-shrink-0 w-40 h-40 rounded-[40px] bg-primary text-on-primary flex flex-col items-center justify-center shadow-lg shadow-primary/20">
                                <span class="text-[14px] font-bold opacity-80 uppercase tracking-widest">Nomor</span>
                                <span class="text-[56px] font-extrabold leading-none">A-{{ $antrianAktif->nomor }}</span>
                            </div>
                            <div class="flex-grow grid grid-cols-2 gap-6 w-full">
                                <div class="p-4 rounded-xl bg-surface-container-low border border-outline-variant/30">
                                    <p class="text-label-sm text-on-surface-variant mb-1">Layanan</p>
                                    <p class="font-h2 text-body-lg text-on-surface">{{ $antrianAktif->layanan->nama }}</p>
                                </div>
                                <div class="p-4 rounded-xl bg-surface-container-low border border-outline-variant/30">
                                    <p class="text-label-sm text-on-surface-variant mb-1">Ruangan / Meja</p>
                                    <p class="font-h2 text-body-lg text-on-surface">{{ $antrianAktif->layanan->ruangan }} - {{ $antrianAktif->nomor_meja ?? 'TBA' }}</p>
                                </div>
                                <div class="p-4 rounded-xl bg-surface-container-low border border-outline-variant/30">
                                    <p class="text-label-sm text-on-surface-variant mb-1">Status</p>
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                                        <p class="font-h2 text-body-lg text-primary">{{ ucfirst($antrianAktif->status) }}</p>
                                    </div>
                                </div>
                                <div class="p-4 rounded-xl bg-surface-container-low border border-outline-variant/30">
                                    <p class="text-label-sm text-on-surface-variant mb-1">Antrian Di Depan</p>
                                    <p class="font-h2 text-body-lg text-on-surface">{{ $antrianDiDepan }} Orang</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-8 flex gap-3">
                            {{-- TOMBOL QR CODE --}}
                            <button @click="showQrModal = true; $nextTick(() => window.dispatchEvent(new Event('show-qr-modal')))"
                                    class="flex-1 py-4 bg-primary text-on-primary rounded-xl font-bold flex items-center justify-center gap-2 hover:brightness-110 transition-all shadow-md active:scale-[0.98]">
                                <span class="material-symbols-outlined">qr_code_2</span>
                                Tampilkan QR Code
                            </button>
                            <form id="form-batal-{{$antrianAktif->id}}" action="{{ route('antrian.batal', $antrianAktif) }}" method="POST">
                                @csrf
                                <button type="button" @click="openConfirm('form-batal-{{$antrianAktif->id}}', 'Apakah Anda yakin ingin membatalkan antrian ini?')" class="px-6 py-4 bg-error-container text-on-error-container dark:bg-red-900/50 dark:text-red-200 rounded-xl font-bold hover:bg-error/10 dark:hover:bg-red-900/80 transition-all active:scale-[0.98]">
                                    <span class="material-symbols-outlined">close</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @else
                <div class="glass-card p-lg flex flex-col items-center justify-center text-center py-12">
                    <div class="w-20 h-20 bg-surface-container rounded-full flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined text-[40px] text-outline">confirmation_number</span>
                    </div>
                    <h2 class="font-h2 text-h2 text-on-surface mb-2">Belum Ada Antrian</h2>
                    <p class="text-on-surface-variant mb-8 max-w-md">Anda belum memiliki tiket antrian aktif. Silakan pilih layanan untuk mulai mengantri.</p>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('mahasiswa.scan') }}" class="px-6 py-3 bg-primary/10 text-primary border border-primary/20 rounded-xl font-bold flex items-center justify-center gap-2 hover:bg-primary/20 transition-all">
                            <span class="material-symbols-outlined">qr_code_scanner</span>
                            Scan Kode QR
                        </a>
                        <a href="#jadwal-tersedia" class="px-8 py-3 bg-primary text-on-primary rounded-xl font-bold flex items-center justify-center gap-2 hover:brightness-110 transition-all shadow-lg shadow-primary/20">
                            <span class="material-symbols-outlined">confirmation_number</span>
                            Ambil Nomor Antrian
                        </a>
                    </div>
                </div>
                @endif

                <div class="glass-card p-lg" id="jadwal-tersedia">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="font-h2 text-h2 text-on-surface">Jadwal Layanan Tersedia</h2>
                        <a href="{{ route('mahasiswa.layanan.index') }}" class="text-primary font-bold text-label-sm flex items-center gap-1 hover:underline">
                            Lihat Semua <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($jadwals as $layanan)
                        <div @click="selectedDashboardLayanan = {{ $layanan->id }}"
                             class="p-5 rounded-[20px] bg-white border border-emerald-50 hover:shadow-md transition-shadow cursor-pointer group flex flex-col h-full">
                            <div class="w-12 h-12 rounded-2xl bg-secondary-container flex items-center justify-center text-primary mb-4 group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined">description</span>
                            </div>
                            <h3 class="font-bold text-on-surface mb-1">{{ $layanan->nama }}</h3>
                            <p class="text-label-sm text-on-surface-variant mb-4">{{ $layanan->ruangan }}</p>
                            <div class="mt-auto pt-4 border-t border-emerald-50/50 flex items-center justify-between">
                                <span class="text-[11px] font-bold text-primary">{{ $layanan->jadwal->count() }} Jadwal Tersedia</span>
                                <div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-all">
                                    <span class="material-symbols-outlined text-[18px]">add</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <aside class="lg:col-span-4 flex flex-col gap-card-gap">
                <div class="glass-card p-lg flex flex-col gap-6">
                    <h2 class="font-h2 text-h2 text-on-surface">Riwayat Terakhir</h2>
                    <div class="flex flex-col gap-4">
                        @forelse($riwayats as $riwayat)
                        <div class="flex items-center gap-4 p-3 rounded-2xl hover:bg-surface-container-low transition-colors">
                            <span class="material-symbols-outlined text-[32px] text-primary shrink-0">history</span>
                            <div class="flex-grow">
                                <p class="font-bold text-on-surface text-body-md">{{ $riwayat->layanan->nama }}</p>
                                <p class="text-label-sm text-on-surface-variant">{{ $riwayat->created_at->format('d M Y') }} • {{ ucfirst($riwayat->status) }}</p>
                            </div>
                        </div>
                        @empty
                        <p class="text-on-surface-variant text-sm text-center">Belum ada riwayat.</p>
                        @endforelse
                    </div>
                    <a href="{{ route('mahasiswa.riwayat') }}" class="block text-center w-full py-3 border border-emerald-100 dark:border-emerald-800 text-primary dark:text-emerald-400 rounded-xl font-bold hover:bg-emerald-50 dark:hover:bg-emerald-900/30 transition-colors font-body-md shadow-sm">
                        Semua Riwayat
                    </a>
                </div>

                <div class="rounded-[24px] p-lg bg-emerald-900 overflow-hidden relative shadow-xl border border-emerald-800">
                    <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-primary opacity-20 rounded-full blur-2xl"></div>
                    <div class="relative z-10 text-white">
                        <span class="material-symbols-outlined text-[32px] mb-4" style="font-variation-settings: 'FILL' 1;">help</span>
                        <h3 class="font-h1 text-xl md:text-2xl mb-2 font-bold text-white">Butuh Bantuan?</h3>
                        <p class="text-white/90 text-sm md:text-base font-medium mb-6">Pusat bantuan kami siap menjawab pertanyaan seputar sistem antrian kampus.</p>
                        <a @click.prevent="showComingSoon = true" class="block text-center w-full py-3 bg-white dark:bg-transparent border border-transparent dark:border-emerald-800 text-emerald-900 dark:text-emerald-400 rounded-xl font-bold font-body-md hover:bg-emerald-50 dark:hover:bg-emerald-900/30 transition-colors shadow-sm" href="#">
                            Tanya Support
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    {{-- =============================================
         MODAL: PILIH JADWAL
         ============================================= --}}
    <div x-show="selectedDashboardLayanan"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/40 backdrop-blur-md"
         style="display: none;">

        <div class="bg-white w-full max-w-2xl rounded-[32px] shadow-2xl overflow-hidden"
             @click.away="selectedDashboardLayanan = null">
            <div class="p-8 border-b border-emerald-50 flex justify-between items-center">
                <div>
                    <h2 class="font-h2 text-h2 text-on-surface">Pilih Jadwal Antrian</h2>
                    <p class="text-on-surface-variant text-body-md">Silakan tentukan waktu kunjungan Anda.</p>
                </div>
                <button @click="selectedDashboardLayanan = null" class="p-2 hover:bg-surface-container-low rounded-full transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="p-8 max-h-[60vh] overflow-y-auto">
                @foreach($jadwals as $layanan)
                <div x-show="selectedDashboardLayanan == {{ $layanan->id }}" class="space-y-4">
                    <p class="font-bold text-primary mb-4">{{ $layanan->nama }}</p>
                    @forelse($layanan->jadwal as $jadwal)
                    <form action="{{ route('antrian.store') }}" method="POST"
                          class="p-4 rounded-2xl border border-emerald-50 hover:border-primary hover:bg-emerald-50/30 transition-all group relative">
                        @csrf
                        <input type="hidden" name="layanan_id" value="{{ $layanan->id }}">
                        <input type="hidden" name="jadwal_id" value="{{ $jadwal->id }}">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-white border border-emerald-100 flex flex-col items-center justify-center shadow-sm">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase">{{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('M') }}</span>
                                    <span class="text-lg font-bold text-on-surface leading-none">{{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d') }}</span>
                                </div>
                                <div>
                                    <p class="font-bold text-on-surface">{{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('l, d F Y') }}</p>
                                    <p class="text-sm text-on-surface-variant">{{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }} WIB</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-bold text-primary mb-2">Kuota: {{ $jadwal->kuota }}</p>
                                <button type="submit"
                                        class="px-6 py-2 bg-primary text-on-primary rounded-lg font-bold text-sm hover:brightness-110 transition-all">
                                    Ambil
                                </button>
                            </div>
                        </div>
                    </form>
                    @empty
                    <div class="text-center py-10">
                        <p class="text-on-surface-variant">Belum ada jadwal tersedia.</p>
                    </div>
                    @endforelse
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- =============================================
         MODAL: QR CODE TIKET
         ============================================= --}}
    @if($antrianAktif)
    <div x-show="showQrModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/40 backdrop-blur-md"
         style="display: none;">

        <div class="bg-white w-full max-w-xs rounded-[28px] shadow-2xl overflow-hidden flex flex-col"
             style="max-height: 88vh;"
             @click.away="showQrModal = false">

            {{-- Header --}}
            <div class="bg-emerald-900 px-5 py-3 text-center relative flex-shrink-0">
                <p class="text-emerald-300 text-xs font-bold tracking-widest uppercase mb-0.5">Campus Queue</p>
                <p class="text-white text-base font-bold">Tiket Antrian</p>
                <button @click="showQrModal = false"
                        class="absolute right-3 top-3 p-1 rounded-full bg-white/10 hover:bg-white/20 transition-colors">
                    <span class="material-symbols-outlined text-white text-[18px]">close</span>
                </button>
            </div>

            {{-- Body scrollable --}}
            <div class="p-3 flex flex-col items-center gap-2.5 overflow-y-auto">

                {{-- QR Box --}}
                <div class="bg-white border border-emerald-100 rounded-xl p-2 w-full flex justify-center items-center">
                    <!-- Ukuran display tetap dipertahankan 150x150 via CSS, tetapi kanvas di dalamnya digambar pada resolusi tinggi -->
                    <div id="qrcode-tiket" class="w-[150px] h-[150px] flex items-center justify-center overflow-hidden"></div>
                </div>

                {{-- Detail --}}
                <div class="w-full border border-emerald-100 rounded-2xl overflow-hidden text-sm">
                    <div class="grid grid-cols-2 border-b border-emerald-100">
                        <div class="p-2 border-r border-emerald-100">
                            <p class="text-xs text-on-surface-variant mb-0.5">Nomor Antrian</p>
                            <p class="text-2xl font-extrabold text-primary leading-none">
                                A-{{ $antrianAktif->nomor }}
                            </p>
                        </div>
                        <div class="p-2">
                            <p class="text-xs text-on-surface-variant mb-1">Status</p>
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold mt-1 px-3 py-1 rounded-full
                                {{ $antrianAktif->status === 'dipanggil' ? 'text-amber-700 bg-amber-100' : 'text-emerald-700 bg-emerald-100' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $antrianAktif->status === 'dipanggil' ? 'bg-amber-500' : 'bg-emerald-500 animate-pulse' }}"></span>
                                {{ ucfirst($antrianAktif->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="p-3 border-b border-emerald-100">
                        <p class="text-xs text-on-surface-variant mb-1">Layanan</p>
                        <p class="font-bold text-on-surface">{{ $antrianAktif->layanan->nama }}</p>
                    </div>
                    <div class="grid grid-cols-2 border-b border-emerald-100">
                        <div class="p-2 border-r border-emerald-100">
                            <p class="text-xs text-on-surface-variant mb-1">Tanggal</p>
                            <p class="font-bold text-on-surface text-xs">
                                @if($antrianAktif->jadwal)
                                    {{ \Carbon\Carbon::parse($antrianAktif->jadwal->tanggal)->translatedFormat('D, d M Y') }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                        <div class="p-2">
                            <p class="text-xs text-on-surface-variant mb-1">Waktu</p>
                            <p class="font-bold text-on-surface text-xs">
                                @if($antrianAktif->jadwal)
                                    {{ substr($antrianAktif->jadwal->jam_mulai, 0, 5) }} – {{ substr($antrianAktif->jadwal->jam_selesai, 0, 5) }} WIB
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2">
                        <div class="p-2 border-r border-emerald-100">
                            <p class="text-xs text-on-surface-variant mb-1">Ruangan</p>
                            <p class="font-bold text-on-surface text-xs">{{ $antrianAktif->layanan->ruangan ?? '-' }}</p>
                        </div>
                        <div class="p-2">
                            <p class="text-xs text-on-surface-variant mb-1">Antrian di Depan</p>
                            <p class="font-bold text-on-surface text-xs">{{ $antrianDiDepan }} Orang</p>
                        </div>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="w-full flex gap-2">
                    <button id="btn-download-qr"
                            class="flex-1 py-2.5 bg-primary text-on-primary rounded-xl font-bold flex items-center justify-center gap-2 hover:brightness-110 transition-all text-sm active:scale-[0.98]">
                        <span class="material-symbols-outlined text-[18px]">download</span>
                        Download PNG
                    </button>
                    <button id="btn-share-qr"
                            class="px-3 py-2.5 bg-surface-container text-on-surface rounded-xl font-bold hover:bg-surface-container-high transition-all active:scale-[0.98]"
                            title="Bagikan tiket">
                        <span class="material-symbols-outlined text-[18px]">share</span>
                    </button>
                </div>

                <p class="text-[11px] text-on-surface-variant text-center leading-tight">
                    Tunjukkan QR ini kepada petugas saat tiba di loket.
                </p>
            </div>
        </div>
    </div>
    @endif

</main>
@endsection

@section('scripts')
<!-- Memuat library qrcode-generator versi 2.x/1.x yang stabil via Cloudflare cdnjs -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode-generator/1.4.4/qrcode.min.js"></script>

<script>
    {{-- =============================================
         NOTIFIKASI REAL-TIME & SERVICE WORKER
         ============================================= --}}
    function showNotification(nomor, loket) {
        if ("Notification" in window && Notification.permission === "granted") {
            const title = "Panggilan Antrian!";
            const options = {
                body: `Nomor A-${nomor} ke ${loket || 'Loket 1'}`,
                icon: '/favicon.ico',
                tag: 'antrian-panggilan',
                vibrate: [200, 100, 200, 100, 200, 100, 200],
                requireInteraction: true,
                actions: [
                    {
                        action: 'oke',
                        title: 'Oke, Saya Menuju Kesana'
                    }
                ]
            };

            // Gunakan Service Worker jika ada untuk push notif di mobile (Android)
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.ready.then(function(registration) {
                    registration.showNotification(title, options);
                }).catch(function() {
                    // Fallback
                    new Notification(title, options);
                });
            } else {
                new Notification(title, options);
            }
        }
        try {
            new Audio('https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3').play();
        } catch (e) {}
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Daftarkan Service Worker
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js').then(function(registration) {
                console.log('ServiceWorker registered:', registration.scope);
            }).catch(function(error) {
                console.error('ServiceWorker registration failed:', error);
            });
        }

        // Request Notification Permission on load
        if ("Notification" in window && Notification.permission === "default") {
            Notification.requestPermission();
        }
        
        let lastStatus    = "{{ $antrianAktif ? $antrianAktif->status : 'none' }}";
        let lastUpdatedAt = "{{ $antrianAktif ? $antrianAktif->updated_at->toDateTimeString() : '' }}";
        
        window.isNavigating = false;
        
        // Prevent polling reload when a form is submitting
        document.querySelectorAll('form').forEach(f => {
            f.addEventListener('submit', () => { window.isNavigating = true; });
        });
        window.addEventListener('beforeunload', () => { window.isNavigating = true; });

        setInterval(function () {
            if (window.isNavigating) return;
            
            fetch("{{ route('antrian.checkStatus') }}")
                .then(r => r.json())
                .then(data => {
                    if (data.status === 'dipanggil') {
                        if (lastStatus !== 'dipanggil' || (data.updated_at && data.updated_at !== lastUpdatedAt)) {
                            showNotification(data.nomor, data.nomor_meja);
                            window.dispatchEvent(new CustomEvent('show-call', { detail: { nomor: data.nomor, loket: data.nomor_meja || 'Loket 1' } }));
                        }
                    }
                    if (data.status === 'none' && (lastStatus === 'menunggu' || lastStatus === 'dipanggil')) {
                        if (!window.isNavigating) window.location.reload();
                    }
                    lastStatus = data.status;
                    if (data.updated_at) lastUpdatedAt = data.updated_at;
                })
                .catch(err => console.error(err));
        }, 5000);

        window.addEventListener('call-closed', () => {
            sessionStorage.setItem('call_dismissed_timestamp', lastUpdatedAt);
            window.location.reload();
        });

        if (lastStatus === 'dipanggil' && sessionStorage.getItem('call_dismissed_timestamp') !== lastUpdatedAt) {
            setTimeout(function () {
                window.dispatchEvent(new CustomEvent('show-call', { 
                    detail: { 
                        nomor: '{{ $antrianAktif ? $antrianAktif->nomor : "" }}', 
                        loket: '{{ $antrianAktif ? ($antrianAktif->nomor_meja ?? "Loket 1") : "Loket 1" }}' 
                    } 
                }));
            }, 500);
        }

        {{-- =============================================
             QR CODE — menggunakan library qrcode (qrcode-generator)
             ============================================= --}}
        @if($antrianAktif)
        const qrEl        = document.getElementById('qrcode-tiket');
        const btnDownload = document.getElementById('btn-download-qr');
        const btnShare    = document.getElementById('btn-share-qr');
        let qrGenerated   = false;

        // payload dikonversi secara aman ke format string agar tidak memicu error linter js
        const qrPayload = JSON.stringify({
            type: 'jadwal',
            id  : parseInt('{{ $antrianAktif->jadwal_id }}') || null
        });

        // Generate QR saat tombol diklik (modal dibuka)
        window.addEventListener('show-qr-modal', function () {
            if (!qrGenerated && qrEl) {
                qrEl.innerHTML = '';
                
                // Gunakan tipe nomor 4 dan tingkat koreksi kesalahan 'H'
                const typeNumber = 4;
                const errorCorrectionLevel = 'H';
                const qr = qrcode(typeNumber, errorCorrectionLevel);
                qr.addData(qrPayload);
                qr.make();
                
                // SOLUSI ANTI BURIK: Menggambar di Canvas dengan teknik Super-Sampling (Kerapatan Piksel Tinggi)
                const canvas = document.createElement('canvas');
                const displaySize = 150; // Ukuran tampilan di layar CSS
                const dprScale = 3;     // Naikkan skala internal piksel menjadi 3x (Ultra Sharp)
                
                canvas.width = displaySize * dprScale;
                canvas.height = displaySize * dprScale;
                canvas.style.width = displaySize + 'px';
                canvas.style.height = displaySize + 'px';
                
                const ctx = canvas.getContext('2d');
                
                // Nonaktifkan anti-aliasing bawaan browser agar tepian piksel hitam QR Code tetap krispi
                ctx.imageSmoothingEnabled = false;
                ctx.mozImageSmoothingEnabled = false;
                ctx.webkitImageSmoothingEnabled = false;
                ctx.msImageSmoothingEnabled = false;
                
                const count = qr.getModuleCount();
                // Hitung ukuran sel mentah tanpa pembulatan kasar untuk ketepatan sub-piksel
                const rawCellSize = (canvas.width - (20 * dprScale)) / count;
                const margin = (canvas.width - (count * rawCellSize)) / 2;
                
                // Gambar background putih bersih
                ctx.fillStyle = '#ffffff';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                
                // Menggambar blok hitam QR Code dengan pencegahan celah sub-piksel
                ctx.fillStyle = '#000000';
                for (let row = 0; row < count; row++) {
                    for (let col = 0; col < count; col++) {
                        if (qr.isDark(row, col)) {
                            // Menggunakan Math.round untuk posisi koordinat dan Math.ceil untuk ukuran sel
                            // guna menghindari garis-garis putih samar di sela-sela kotak akibat floating point
                            ctx.fillRect(
                                Math.round(margin + col * rawCellSize),
                                Math.round(margin + row * rawCellSize),
                                Math.ceil(rawCellSize),
                                Math.ceil(rawCellSize)
                            );
                        }
                    }
                }
                
                qrEl.appendChild(canvas);
                qrGenerated = true;
            }
        });

        // -----------------------------------------------
        // DOWNLOAD PNG — canvas manual (tanpa html2canvas)
        // -----------------------------------------------
        btnDownload.addEventListener('click', function () {
            const qrCanvas = qrEl ? qrEl.querySelector('canvas') : null;
            if (!qrCanvas) {
                alert('QR belum siap, tutup dan buka kembali modal.');
                return;
            }

            const btn = this;
            btn.disabled = true;
            btn.innerHTML = '<span class="material-symbols-outlined text-[18px] animate-spin">progress_activity</span>&nbsp;Memproses...';

            // Data detail tiket
            const details = [
                { label: 'Nomor Antrian', value: 'A-{{ $antrianAktif->nomor }}' },
                { label: 'Status'       , value: '{{ ucfirst($antrianAktif->status) }}'                       },
                { label: 'Layanan'      , value: '{{ $antrianAktif->layanan->nama }}'                         },
                { label: 'Tanggal'      , value: '{{ $antrianAktif->jadwal ? \Carbon\Carbon::parse($antrianAktif->jadwal->tanggal)->translatedFormat("D, d M Y") : "-" }}' },
                { label: 'Waktu'        , value: '{{ $antrianAktif->jadwal ? substr($antrianAktif->jadwal->jam_mulai,0,5)." – ".substr($antrianAktif->jadwal->jam_selesai,0,5)." WIB" : "-" }}' },
                { label: 'Ruangan'      , value: '{{ $antrianAktif->layanan->ruangan ?? "-" }}'               },
                { label: 'Antrian di Depan', value: '{{ $antrianDiDepan }} Orang'                             },
            ];

            // Ukuran canvas
            const scale    = 2;          // retina
            const padX     = 40 * scale;
            const padY     = 32 * scale;
            const qrSize   = 180 * scale;
            const lineH    = 22 * scale;
            const labelSz  = 11 * scale;
            const valueSz  = 14 * scale;
            const headerH  = 90 * scale;
            const footerH  = 44 * scale;
            const rowH     = (labelSz + valueSz + 10 * scale);
            const detailH  = details.length * rowH + padY * 2;
            const canvasW  = qrSize + padX * 2;
            const canvasH  = headerH + padY + qrSize + padY + detailH + padY + footerH;

            const c   = document.createElement('canvas');
            c.width   = canvasW;
            c.height  = canvasH;
            const ctx = c.getContext('2d');

            // --- background putih ---
            ctx.fillStyle = '#ffffff';
            ctx.fillRect(0, 0, canvasW, canvasH);

            // --- header hijau tua ---
            ctx.fillStyle = '#065f46';
            ctx.fillRect(0, 0, canvasW, headerH);

            ctx.textAlign    = 'center';
            ctx.fillStyle    = '#6ee7b7';
            ctx.font         = `500 ${13 * scale}px sans-serif`;
            ctx.fillText('CAMPUS QUEUE', canvasW / 2, 30 * scale);

            ctx.fillStyle    = '#ffffff';
            ctx.font         = `bold ${22 * scale}px sans-serif`;
            ctx.fillText('Tiket Antrian', canvasW / 2, 62 * scale);

            // --- QR image ---
            ctx.drawImage(qrCanvas, padX, headerH + padY, qrSize, qrSize);

            // --- detail box background ---
            const boxY = headerH + padY + qrSize + padY;
            ctx.fillStyle = '#f0fdf4';
            const r = 12 * scale;
            ctx.beginPath();
            ctx.moveTo(padX / 2 + r, boxY);
            ctx.lineTo(canvasW - padX / 2 - r, boxY);
            ctx.quadraticCurveTo(canvasW - padX / 2, boxY, canvasW - padX / 2, boxY + r);
            ctx.lineTo(canvasW - padX / 2, boxY + detailH - r);
            ctx.quadraticCurveTo(canvasW - padX / 2, boxY + detailH, canvasW - padX / 2 - r, boxY + detailH);
            ctx.lineTo(padX / 2 + r, boxY + detailH);
            ctx.quadraticCurveTo(padX / 2, boxY + detailH, padX / 2, boxY + detailH - r);
            ctx.lineTo(padX / 2, boxY + r);
            ctx.quadraticCurveTo(padX / 2, boxY, padX / 2 + r, boxY);
            ctx.closePath();
            ctx.fill();

            // border box
            ctx.strokeStyle = '#a7f3d0';
            ctx.lineWidth   = 1 * scale;
            ctx.stroke();

            // --- detail rows ---
            ctx.textAlign = 'left';
            details.forEach(function (row, i) {
                const y = boxY + padY + i * rowH;

                ctx.fillStyle = '#6b7280';
                ctx.font      = `400 ${labelSz}px sans-serif`;
                ctx.fillText(row.label, padX, y + labelSz);

                ctx.fillStyle = '#065f46';
                ctx.font      = `bold ${valueSz}px sans-serif`;
                ctx.fillText(row.value, padX, y + labelSz + 6 * scale + valueSz);
            });

            // --- footer strip ---
            ctx.fillStyle = '#d1fae5';
            ctx.fillRect(0, canvasH - footerH, canvasW, footerH);

            ctx.fillStyle = '#065f46';
            ctx.font      = `500 ${11 * scale}px sans-serif`;
            ctx.textAlign = 'center';
            ctx.fillText('Tunjukkan kepada petugas saat tiba di loket', canvasW / 2, canvasH - footerH / 2 + 5 * scale);

            // --- trigger download ---
            const link    = document.createElement('a');
            link.download = 'tiket-antrian-A-{{ $antrianAktif->nomor }}.png';
            link.href     = c.toDataURL('image/png', 1.0);
            link.click();

            btn.disabled  = false;
            btn.innerHTML = '<span class="material-symbols-outlined text-[18px]">download</span>&nbsp;Download PNG';
        });

        // -----------------------------------------------
        // SHARE
        // -----------------------------------------------
        btnShare.addEventListener('click', function () {
            const text = [
                'Tiket Antrian Campus Queue',
                'Nomor : A-{{ $antrianAktif->nomor }}',
                'Layanan: {{ $antrianAktif->layanan->nama }}',
                @if($antrianAktif->jadwal)
                'Tanggal: {{ \Carbon\Carbon::parse($antrianAktif->jadwal->tanggal)->translatedFormat("D, d M Y") }}',
                'Waktu  : {{ substr($antrianAktif->jadwal->jam_mulai,0,5) }} – {{ substr($antrianAktif->jadwal->jam_selesai,0,5) }} WIB',
                @endif
                'Ruangan: {{ $antrianAktif->layanan->ruangan ?? "-" }}',
            ].join('\n');

            if (navigator.share) {
                navigator.share({ title: 'Tiket Antrian', text }).catch(() => {});
            } else {
                navigator.clipboard.writeText(text).then(function () {
                    alert('Detail tiket berhasil disalin ke clipboard!');
                });
            }
        });
        @endif
    });
</script>

{{-- Auto-open modal jadwal setelah scan QR --}}
@if($scannedLayanan)
<script>
    document.addEventListener('alpine:init', function () {
        Alpine.nextTick(function () {
            window.dispatchEvent(new CustomEvent('open-layanan', {
                detail: { id: parseInt('{{ $scannedLayanan }}') }
            }));
        });
    });
</script>
@endif
@endsection