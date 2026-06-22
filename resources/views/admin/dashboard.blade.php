@extends('layouts.template')

@section('title', 'Admin Dashboard - Campus Queue')

@section('content')
<main class="pt-24 pb-12 px-4 md:px-8 max-w-7xl mx-auto" x-data="{ showQrModal: false }">
    <header class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <h1 class="font-h1 text-2xl md:text-h1 text-on-surface mb-2">Panel Admin</h1>
            <p class="text-on-surface-variant text-sm md:text-body-lg">Pantau dan kelola seluruh antrian layanan kampus secara real-time.</p>
        </div>
       
    </header>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-card-gap mb-10">
        <!-- Total Antrian Aktif -->
        <div class="glass-card p-5 md:p-6 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-20 md:w-20 h-20 md:h-20 bg-primary/10 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-primary/10 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-[28px] md:text-[28px]" style="font-variation-settings: 'FILL' 1;">groups</span>
                </div>
                <span class="text-[10px] md:text-xs font-bold text-primary px-2 py-1 bg-primary/5 rounded-lg">AKTIF</span>
            </div>
            <p class="text-xs md:text-sm font-semibold text-on-surface-variant uppercase mb-1">Total Antrian</p>
            <h2 class="font-h1 text-3xl md:text-[36px] text-on-surface leading-none">{{ $stats['total'] }}</h2>
        </div>

        <!-- Menunggu -->
        <div class="glass-card p-5 md:p-6 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-20 md:w-20 h-20 md:h-20 bg-amber-500/10 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-amber-500/10 text-amber-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[28px] md:text-[28px]" style="font-variation-settings: 'FILL' 1;">hourglass_empty</span>
                </div>
                <span class="text-[10px] md:text-xs font-bold text-amber-600 px-2 py-1 bg-amber-500/5 rounded-lg">PENDING</span>
            </div>
            <p class="text-xs md:text-sm font-semibold text-on-surface-variant uppercase mb-1">Menunggu</p>
            <h2 class="font-h1 text-3xl md:text-[36px] text-on-surface leading-none">{{ $stats['menunggu'] }}</h2>
        </div>

        <!-- Dipanggil -->
        <div class="glass-card p-5 md:p-6 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-20 md:w-20 h-20 md:h-20 bg-blue-500/10 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-blue-500/10 text-blue-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[28px] md:text-[28px]" style="font-variation-settings: 'FILL' 1;">notifications_active</span>
                </div>
                <span class="text-[10px] md:text-xs font-bold text-blue-600 px-2 py-1 bg-blue-500/5 rounded-lg">LOKET</span>
            </div>
            <p class="text-xs md:text-sm font-semibold text-on-surface-variant uppercase mb-1">Dilayani</p>
            <h2 class="font-h1 text-3xl md:text-[36px] text-on-surface leading-none">{{ $stats['dipanggil'] }}</h2>
        </div>

        <!-- Selesai -->
        <div class="glass-card p-5 md:p-6 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-20 md:w-20 h-20 md:h-20 bg-emerald-500/10 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[28px] md:text-[28px]" style="font-variation-settings: 'FILL' 1;">task_alt</span>
                </div>
                <span class="text-[10px] md:text-xs font-bold text-emerald-600 px-2 py-1 bg-emerald-500/5 rounded-lg">SUCCESS</span>
            </div>
            <p class="text-xs md:text-sm font-semibold text-on-surface-variant uppercase mb-1">Selesai</p>
            <h2 class="font-h1 text-3xl md:text-[36px] text-on-surface leading-none">{{ $stats['selesai'] }}</h2>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 md:gap-card-gap">
        <div class="lg:col-span-8 order-2 lg:order-1">
            <div class="glass-card p-4 md:p-lg">
                <div class="flex items-center justify-between mb-6 md:mb-8">
                    <h2 class="font-h2 text-lg md:text-h2 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-xl md:text-2xl">potted_plant</span>
                        Antrian Aktif
                    </h2>
                    <a href="{{ route('admin.antrian') }}" class="text-primary font-bold hover:underline text-xs md:text-sm">Kelola Semua</a>
                </div>
                <div class="overflow-x-auto -mx-4 md:mx-0 px-4 md:px-0">
                    <table class="w-full min-w-[600px] md:min-w-0">
                        <thead>
                            <tr class="text-left text-xs md:text-label-sm text-on-surface-variant border-b border-emerald-50">
                                <th class="pb-4 font-bold">NOMOR</th>
                                <th class="pb-4 font-bold">MAHASISWA</th>
                                <th class="pb-4 font-bold hidden md:table-cell">LAYANAN</th>
                                <th class="pb-4 font-bold">STATUS</th>
                                <th class="pb-4 font-bold text-right hidden md:table-cell">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-emerald-50/50">
                            @forelse($antrians as $antrian)
                            <tr class="group hover:bg-surface-container-low transition-colors relative" x-data="{ open: false }" @click="if(window.innerWidth < 768) open = !open" @click.away="open = false">
                                <td class="py-4 md:py-5">
                                    <span class="px-3 py-1.5 md:py-1 bg-emerald-100 text-emerald-800 rounded-full font-bold text-sm md:text-base">A-{{ $antrian->nomor }}</span>
                                </td>
                                <td class="py-4 md:py-5">
                                    <p class="font-bold text-on-surface text-sm md:text-base leading-tight">{{ $antrian->user->name }}</p>
                                    <p class="text-xs md:text-[11px] text-on-surface-variant hidden sm:block">{{ $antrian->user->username }}</p>
                                    <p class="text-xs text-primary md:hidden">{{ $antrian->layanan->nama }}</p>
                                </td>
                                <td class="py-4 md:py-5 text-sm hidden md:table-cell">{{ $antrian->layanan->nama }}</td>
                                <td class="py-4 md:py-5">
                                    @php
                                        $statusClass = $antrian->status === 'dipanggil' ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700';
                                    @endphp
                                    <span class="px-3 py-1 {{ $statusClass }} rounded-full text-[10px] md:text-[10px] font-bold uppercase tracking-wider">{{ $antrian->status }}</span>
                                </td>
                                <td class="py-4 md:py-5 text-right relative hidden md:table-cell">
                                    <!-- Desktop Actions -->
                                    <div class="hidden md:flex justify-end gap-2 relative z-10">
                                        @if($antrian->status === 'menunggu')
                                        <form action="{{ route('admin.antrian.updateStatus', $antrian) }}" method="POST" @click.stop>
                                            @csrf
                                            <input type="hidden" name="status" value="dipanggil">
                                            <button type="submit" class="p-2 bg-primary text-on-primary rounded-lg hover:brightness-110 transition-all flex items-center gap-1 text-xs px-3 shadow-sm active:scale-95">
                                                <span class="material-symbols-outlined text-base">campaign</span>
                                                <span>Panggil</span>
                                            </button>
                                        </form>
                                        <form id="form-admin-desktop-batal-{{$antrian->id}}" action="{{ route('admin.antrian.updateStatus', $antrian) }}" method="POST" @click.stop>
                                            @csrf
                                            <input type="hidden" name="status" value="batal">
                                            <button type="button" @click="openConfirm('form-admin-desktop-batal-{{$antrian->id}}', 'Apakah Anda yakin ingin membatalkan antrian A-{{$antrian->nomor}} ini?')" class="p-2 bg-error-container text-on-error-container rounded-lg hover:brightness-110 transition-all flex items-center gap-1 text-xs px-3 shadow-sm active:scale-95">
                                                <span class="material-symbols-outlined text-base">close</span>
                                            </button>
                                        </form>
                                        @elseif($antrian->status === 'dipanggil')
                                        <form action="{{ route('admin.antrian.updateStatus', $antrian) }}" method="POST" class="inline" @click.stop>
                                            @csrf
                                            <input type="hidden" name="status" value="dipanggil">
                                            <button type="submit" class="p-2 bg-blue-600 text-on-primary rounded-lg hover:brightness-110 transition-all flex items-center gap-1 text-xs px-3 shadow-sm active:scale-95" title="Panggil Ulang">
                                                <span class="material-symbols-outlined text-base">volume_up</span>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.antrian.updateStatus', $antrian) }}" method="POST" class="inline" @click.stop>
                                            @csrf
                                            <input type="hidden" name="status" value="selesai">
                                            <button type="submit" class="p-2 bg-emerald-600 text-on-primary rounded-lg hover:brightness-110 transition-all flex items-center gap-1 text-xs px-3 shadow-sm active:scale-95">
                                                <span class="material-symbols-outlined text-base">check</span>
                                                <span>Selesai</span>
                                            </button>
                                        </form>
                                        @endif
                                    </div>

                                    <!-- Mobile Actions Bottom Sheet -->
                                    <template x-teleport="body">
                                        <div x-show="open" style="display: none;" class="md:hidden fixed inset-0 z-[100] flex items-end sm:items-center justify-center">
                                            <div x-show="open" x-transition.opacity @click="open = false" class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
                                            <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="translate-y-full opacity-0" x-transition:enter-end="translate-y-0 opacity-100" class="relative w-full bg-surface-container rounded-t-3xl p-4 shadow-2xl border-t border-emerald-100 dark:border-emerald-800">
                                                <div class="w-12 h-1.5 bg-emerald-100 dark:bg-emerald-800 rounded-full mx-auto mb-4"></div>
                                                <h3 class="text-center font-bold text-sm text-on-surface-variant mb-4">Aksi A-{{ $antrian->nomor }}</h3>
                                                <div class="flex flex-col gap-2">
                                                    @if($antrian->status === 'menunggu')
                                                    <form action="{{ route('admin.antrian.updateStatus', $antrian) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="dipanggil">
                                                        <button type="submit" class="w-full text-center px-4 py-3 bg-primary/10 text-primary rounded-xl font-bold flex items-center justify-center gap-2 hover:bg-primary/20 transition-all">
                                                            <span class="material-symbols-outlined">campaign</span> Panggil
                                                        </button>
                                                    </form>
                                                    <form id="form-admin-batal-{{$antrian->id}}" action="{{ route('admin.antrian.updateStatus', $antrian) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="batal">
                                                        <button type="button" @click="openConfirm('form-admin-batal-{{$antrian->id}}', 'Apakah Anda yakin ingin membatalkan antrian A-{{$antrian->nomor}} ini?')" class="w-full mt-2 px-4 py-3 text-sm text-error font-bold text-center hover:bg-error/10 rounded-xl transition-all">Batal</button>
                                                    </form>
                                                    @elseif($antrian->status === 'dipanggil')
                                                    <form action="{{ route('admin.antrian.updateStatus', $antrian) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="dipanggil">
                                                        <button type="submit" class="w-full text-center px-4 py-3 bg-blue-600/10 text-blue-600 rounded-xl font-bold flex items-center justify-center gap-2">
                                                            <span class="material-symbols-outlined">volume_up</span> Panggil Ulang
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.antrian.updateStatus', $antrian) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="selesai">
                                                        <button type="submit" class="w-full text-center px-4 py-3 bg-emerald-600/10 text-emerald-600 rounded-xl font-bold flex items-center justify-center gap-2">
                                                            <span class="material-symbols-outlined">check</span> Selesai
                                                        </button>
                                                    </form>
                                                    @endif
                                                    <button @click="open = false" class="w-full mt-2 px-4 py-3 text-sm text-on-surface-variant font-bold text-center hover:bg-surface-container-low rounded-xl">Batal</button>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-10 text-center text-on-surface-variant text-sm">Tidak ada antrian aktif saat ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="lg:col-span-4 order-1 lg:order-2">
            <div class="glass-card p-4 md:p-lg h-full flex flex-col" x-data="{ selectedJadwalId: '' }">
                <div class="mb-4">
                    <h2 class="font-h2 text-lg md:text-h2 mb-2 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-xl md:text-2xl">qr_code_scanner</span>
                        Generate QR
                    </h2>
                    <p class="text-on-surface-variant text-sm mb-4">Pilih jadwal untuk menampilkan kode QR antrian.</p>
                    
                    <select x-model="selectedJadwalId" class="w-full px-4 py-3 rounded-xl border border-emerald-100 bg-white dark:bg-surface-container text-on-surface focus:ring-2 focus:ring-primary focus:outline-none dark:border-emerald-800 text-sm">
                        <option value="">-- Pilih Jadwal --</option>
                        @foreach($jadwals as $jadwal)
                            <option value="{{ $jadwal->id }}">{{ $jadwal->layanan->nama }} ({{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }})</option>
                        @endforeach
                    </select>
                </div>
                
                <div x-show="selectedJadwalId" class="flex flex-col items-center justify-center flex-1 bg-white dark:bg-surface-container-low rounded-2xl p-4 border border-emerald-100 dark:border-emerald-800" style="display: none;" x-transition>
                    <img :src="'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=%7B%22type%22%3A%22jadwal%22%2C%22id%22%3A' + selectedJadwalId + '%7D'" alt="QR Code" class="w-32 h-32 md:w-40 md:h-40 object-contain mix-blend-multiply dark:mix-blend-normal dark:bg-white dark:p-2 dark:rounded-xl">
                    <p class="text-xs text-on-surface-variant mt-3 text-center">Scan untuk melihat jadwal dan mengambil antrian</p>
                </div>

                <div x-show="!selectedJadwalId" class="flex flex-col items-center justify-center flex-1 border-2 border-dashed border-emerald-100 dark:border-emerald-800/50 rounded-2xl text-emerald-200 dark:text-emerald-800/50 min-h-[200px]">
                    <span class="material-symbols-outlined text-4xl mb-2">qr_code</span>
                    <p class="text-sm text-on-surface-variant">Belum ada jadwal dipilih</p>
                </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode-generator/1.4.4/qrcode.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if($antrianAktif)
        // INIT QR CODE TIKET
        const typeNumber = 0;
        const errorCorrectionLevel = 'M';
        const qr = qrcode(typeNumber, errorCorrectionLevel);
        const qrData = JSON.stringify({
            id: {{ $antrianAktif->id }},
            nomor: 'A-{{ $antrianAktif->nomor }}',
            status: '{{ $antrianAktif->status }}'
        });
        qr.addData(qrData);
        qr.make();
        document.getElementById('qrcode-tiket').innerHTML = qr.createImgTag(5, 0);
        
        const imgTag = document.getElementById('qrcode-tiket').querySelector('img');
        if (imgTag) {
            imgTag.style.width = '100%';
            imgTag.style.height = '100%';
            imgTag.style.objectFit = 'contain';
        }
        @endif
    });
</script>
@endsection
