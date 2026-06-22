@extends('layouts.template')

@section('title', 'Kelola Jadwal - Campus Queue')

@section('content')
<main class="pt-24 pb-12 px-4 md:px-8 max-w-7xl mx-auto">
    <header class="mb-8 md:mb-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <h1 class="font-h1 text-2xl md:text-h1 text-on-surface mb-2">Kelola Jadwal Layanan</h1>
            <p class="text-on-surface-variant text-sm md:text-body-lg">Atur waktu operasional dan kuota untuk setiap layanan.</p>
        </div>
        <a href="{{ route('admin.jadwal.create') }}" class="w-full md:w-auto justify-center px-6 py-3 bg-primary text-on-primary rounded-xl font-bold flex items-center gap-2 shadow-lg hover:brightness-110 transition-all">
            <span class="material-symbols-outlined">add</span>
            Tambah Jadwal
        </a>
    </header>

    <div class="glass-card p-4 md:p-lg overflow-hidden">
        <div class="overflow-x-auto -mx-4 md:mx-0 px-4 md:px-0">
            <table class="w-full min-w-[500px] md:min-w-0">
                <thead>
                    <tr class="text-left text-xs md:text-label-sm text-on-surface-variant border-b border-emerald-50">
                        <th class="pb-4 font-bold">LAYANAN</th>
                        <th class="pb-4 font-bold">WAKTU</th>
                        <th class="pb-4 font-bold">KUOTA</th>
                        <th class="pb-4 font-bold text-right hidden md:table-cell">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-emerald-50/50">
                    @forelse($jadwals as $jadwal)
                    <tr class="group hover:bg-surface-container-low transition-colors relative" x-data="{ open: false }" @click="if(window.innerWidth < 768) open = !open" @click.away="open = false">
                        <td class="py-4 md:py-5">
                            <p class="font-bold text-on-surface text-sm md:text-base">{{ $jadwal->layanan->nama }}</p>
                            <p class="text-xs md:text-sm text-on-surface-variant">{{ $jadwal->layanan->ruangan }}</p>
                        </td>
                        <td class="py-4 md:py-5">
                            <span class="flex items-center gap-1 md:gap-2 text-xs md:text-sm text-on-surface-variant">
                                <span class="material-symbols-outlined text-sm md:text-base text-slate-400">calendar_month</span>
                                {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d M Y') }}
                            </span>
                            <span class="flex items-center gap-1 md:gap-2 text-xs md:text-sm text-on-surface-variant mt-1">
                                <span class="material-symbols-outlined text-sm md:text-base text-slate-400">schedule</span>
                                {{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}
                            </span>
                        </td>
                        <td class="py-4 md:py-5">
                            <span class="text-xs font-bold text-on-surface">
                                {{ $jadwal->kuota }} Orang
                            </span>
                        </td>
                        <td class="py-4 md:py-5 text-right relative hidden md:table-cell">
                            <!-- Desktop Actions -->
                            <div class="hidden md:flex justify-end gap-2">
                                <a href="{{ route('admin.jadwal.edit', $jadwal) }}" class="p-2 text-primary hover:bg-primary-container/20 rounded-lg transition-all">
                                    <span class="material-symbols-outlined">edit</span>
                                </a>
                                <form id="form-delete-jadwal-{{$jadwal->id}}" action="{{ route('admin.jadwal.destroy', $jadwal) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" @click="openConfirm('form-delete-jadwal-{{$jadwal->id}}', 'Apakah Anda yakin ingin menghapus jadwal ini?')" class="p-2 text-error hover:bg-error-container/20 rounded-lg transition-all">
                                        <span class="material-symbols-outlined">delete</span>
                                    </button>
                                </form>
                                <button onclick="showQrModal({{ $jadwal->id }}, '{{ $jadwal->layanan->nama }}')" class="p-2 text-primary hover:bg-primary-container/20 rounded-lg transition-all">
                                    <span class="material-symbols-outlined">qr_code_2</span>
                                </button>
                            </div>
                            <!-- Mobile Actions Bottom Sheet -->
                            <template x-teleport="body">
                                <div x-show="open" style="display: none;" class="md:hidden fixed inset-0 z-[100] flex items-end sm:items-center justify-center">
                                    <div x-show="open" x-transition.opacity @click="open = false" class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
                                    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="translate-y-full opacity-0" x-transition:enter-end="translate-y-0 opacity-100" class="relative w-full bg-surface-container rounded-t-3xl p-4 shadow-2xl border-t border-emerald-100 dark:border-emerald-800">
                                        <div class="w-12 h-1.5 bg-emerald-100 dark:bg-emerald-800 rounded-full mx-auto mb-4"></div>
                                        <h3 class="text-center font-bold text-sm text-on-surface-variant mb-4">Aksi Jadwal</h3>
                                        <div class="flex flex-col gap-2">
                                            <a href="{{ route('admin.jadwal.edit', $jadwal) }}" class="w-full text-center px-4 py-3 bg-primary/10 text-primary rounded-xl font-bold flex items-center justify-center gap-2">
                                                <span class="material-symbols-outlined text-[18px]">edit</span> Edit
                                            </a>
                                            <button @click="open = false; setTimeout(() => showQrModal({{ $jadwal->id }}, '{{ $jadwal->layanan->nama }}'), 300)" class="w-full text-center px-4 py-3 bg-surface-container-highest text-on-surface rounded-xl font-bold flex items-center justify-center gap-2">
                                                <span class="material-symbols-outlined text-[18px]">qr_code_2</span> QR Code
                                            </button>
                                            <form id="form-mobile-delete-jadwal-{{$jadwal->id}}" action="{{ route('admin.jadwal.destroy', $jadwal) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" @click="openConfirm('form-mobile-delete-jadwal-{{$jadwal->id}}', 'Apakah Anda yakin ingin menghapus jadwal ini?'); open = false;" class="w-full text-center px-4 py-3 bg-error/10 text-error rounded-xl font-bold flex items-center justify-center gap-2">
                                                    <span class="material-symbols-outlined text-[18px]">delete</span> Hapus
                                                </button>
                                            </form>
                                            <button @click="open = false" class="w-full mt-2 px-4 py-3 text-sm text-on-surface-variant font-bold text-center hover:bg-surface-container-low rounded-xl">Batal</button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-10 text-center text-on-surface-variant">Belum ada data jadwal.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- QR Code Modal -->
    <div id="qrModal" class="fixed inset-0 bg-black/30 backdrop-blur-sm z-50 hidden items-center justify-center" onclick="hideQrModal()">
        <div class="bg-white rounded-2xl shadow-xl p-8 max-w-sm w-full" onclick="event.stopPropagation()">
            <h3 class="font-h2 text-h2 text-on-surface mb-1">Kode QR Jadwal</h3>
            <p id="modalLayananName" class="text-on-surface-variant font-body-md mb-6"></p>
            <div id="qrCodeContainer" class="flex justify-center"></div>
            <p class="text-center text-sm text-slate-500 mt-4">Pindai kode ini untuk mengambil nomor antrian pada jadwal ini.</p>
            <div class="flex gap-4 mt-8">
                <button onclick="hideQrModal()" class="w-full px-6 py-3 bg-slate-100 text-slate-700 rounded-xl font-bold hover:bg-slate-200 transition-all">Tutup</button>
                <button onclick="downloadQrCode()" class="w-full px-6 py-3 bg-primary text-on-primary rounded-xl font-bold shadow-lg hover:brightness-110 transition-all">Unduh</button>
            </div>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script>
    const qrModal = document.getElementById('qrModal');
    const qrCodeContainer = document.getElementById('qrCodeContainer');
    const modalLayananName = document.getElementById('modalLayananName');
    let currentJadwalId = null;
    let currentLayananName = '';

    function showQrModal(jadwalId, layananName) {
        currentJadwalId = jadwalId;
        currentLayananName = layananName;
        modalLayananName.textContent = `Layanan: ${layananName}`;
        qrCodeContainer.innerHTML = '';
        
        const typeNumber = 4;
        const errorCorrectionLevel = 'L';
        const qr = qrcode(typeNumber, errorCorrectionLevel);
        const data = JSON.stringify({ type: 'jadwal', id: jadwalId });
        qr.addData(data);
        qr.make();

        qrCodeContainer.innerHTML = qr.createImgTag(6, 12);
        qrModal.classList.remove('hidden');
        qrModal.classList.add('flex');
    }

    function hideQrModal() {
        qrModal.classList.add('hidden');
        qrModal.classList.remove('flex');
    }

    function downloadQrCode() {
        const img = qrCodeContainer.querySelector('img');
        const link = document.createElement('a');
        link.href = img.src;
        link.download = `QR_Jadwal_${currentLayananName.replace(/\s+/g, '-')}_${currentJadwalId}.png`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>
@endsection
