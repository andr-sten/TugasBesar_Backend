@extends('layouts.custom')

@section('title', 'Kelola Jadwal - Campus Queue')

@section('content')
<main class="pt-24 pb-12 px-8 max-w-7xl mx-auto">
    <header class="mb-10 flex justify-between items-end">
        <div>
            <h1 class="font-h1 text-h1 text-on-surface mb-2">Kelola Jadwal Layanan</h1>
            <p class="text-on-surface-variant font-body-lg">Atur waktu operasional dan kuota untuk setiap layanan.</p>
        </div>
        <a href="{{ route('admin.jadwal.create') }}" class="px-6 py-3 bg-primary text-on-primary rounded-xl font-bold flex items-center gap-2 shadow-lg hover:brightness-110 transition-all">
            <span class="material-symbols-outlined">add</span>
            Tambah Jadwal
        </a>
    </header>

    @if(session('success'))
    <div class="mb-6 p-4 bg-emerald-100 text-emerald-800 rounded-xl font-bold border border-emerald-200">
        {{ session('success') }}
    </div>
    @endif

    <div class="glass-card p-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-label-sm text-on-surface-variant border-b border-emerald-50">
                        <th class="pb-4 font-bold">LAYANAN</th>
                        <th class="pb-4 font-bold">TANGGAL</th>
                        <th class="pb-4 font-bold">WAKTU</th>
                        <th class="pb-4 font-bold">KUOTA</th>
                        <th class="pb-4 font-bold text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-emerald-50/50">
                    @forelse($jadwals as $jadwal)
                    <tr class="group hover:bg-surface-container-low transition-colors">
                        <td class="py-5">
                            <p class="font-bold text-on-surface">{{ $jadwal->layanan->nama }}</p>
                            <p class="text-xs text-on-surface-variant">{{ $jadwal->layanan->ruangan }}</p>
                        </td>
                        <td class="py-5">
                            <span class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm text-slate-400">calendar_month</span>
                                {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d F Y') }}
                            </span>
                        </td>
                        <td class="py-5">
                            <span class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm text-slate-400">schedule</span>
                                {{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}
                            </span>
                        </td>
                        <td class="py-5">
                            <span class="px-3 py-1 bg-surface-container-high rounded-full text-xs font-bold">
                                {{ $jadwal->kuota }} Orang
                            </span>
                        </td>
                        <td class="py-5 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.jadwal.edit', $jadwal) }}" class="p-2 text-primary hover:bg-primary-container/20 rounded-lg transition-all">
                                    <span class="material-symbols-outlined">edit</span>
                                </a>
                                <form action="{{ route('admin.jadwal.destroy', $jadwal) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-error hover:bg-error-container/20 rounded-lg transition-all">
                                        <span class="material-symbols-outlined">delete</span>
                                    </button>
                                </form>
                                <button onclick="showQrModal({{ $jadwal->id }}, '{{ $jadwal->layanan->nama }}')" class="p-2 text-primary hover:bg-primary-container/20 rounded-lg transition-all">
                                    <span class="material-symbols-outlined">qr_code_2</span>
                                </button>
                            </div>
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
