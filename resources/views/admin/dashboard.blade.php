@extends('layouts.custom')

@section('title', 'Admin Dashboard - Campus Queue')

@section('content')
<main class="pt-24 pb-12 px-4 md:px-8 max-w-7xl mx-auto">
    <header class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <h1 class="font-h1 text-2xl md:text-h1 text-on-surface mb-2">Panel Admin</h1>
            <p class="text-on-surface-variant text-sm md:text-body-lg">Pantau dan kelola seluruh antrian layanan kampus secara real-time.</p>
        </div>
       
    </header>

    @if(session('success'))
    <div class="mb-6 p-4 bg-emerald-100 text-emerald-800 rounded-xl font-bold border border-emerald-200 text-sm">
        {{ session('success') }}
    </div>
    @endif

    <!-- Statistik Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-card-gap mb-10">
        <!-- Total Antrian Aktif -->
        <div class="glass-card p-4 md:p-6 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-16 md:w-20 h-16 md:h-20 bg-primary/10 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-primary/10 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-[24px] md:text-[28px]" style="font-variation-settings: 'FILL' 1;">groups</span>
                </div>
                <span class="text-[8px] md:text-[10px] font-bold text-primary px-2 py-1 bg-primary/5 rounded-lg">AKTIF</span>
            </div>
            <p class="text-[10px] md:text-label-sm text-on-surface-variant uppercase mb-1">Total Antrian</p>
            <h2 class="font-h1 text-2xl md:text-[36px] text-on-surface leading-none">{{ $stats['total'] }}</h2>
        </div>

        <!-- Menunggu -->
        <div class="glass-card p-4 md:p-6 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-16 md:w-20 h-16 md:h-20 bg-amber-500/10 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-amber-500/10 text-amber-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[24px] md:text-[28px]" style="font-variation-settings: 'FILL' 1;">hourglass_empty</span>
                </div>
                <span class="text-[8px] md:text-[10px] font-bold text-amber-600 px-2 py-1 bg-amber-500/5 rounded-lg">PENDING</span>
            </div>
            <p class="text-[10px] md:text-label-sm text-on-surface-variant uppercase mb-1">Menunggu</p>
            <h2 class="font-h1 text-2xl md:text-[36px] text-on-surface leading-none">{{ $stats['menunggu'] }}</h2>
        </div>

        <!-- Dipanggil -->
        <div class="glass-card p-4 md:p-6 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-16 md:w-20 h-16 md:h-20 bg-blue-500/10 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-blue-500/10 text-blue-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[24px] md:text-[28px]" style="font-variation-settings: 'FILL' 1;">notifications_active</span>
                </div>
                <span class="text-[8px] md:text-[10px] font-bold text-blue-600 px-2 py-1 bg-blue-500/5 rounded-lg">LOKET</span>
            </div>
            <p class="text-[10px] md:text-label-sm text-on-surface-variant uppercase mb-1">Dilayani</p>
            <h2 class="font-h1 text-2xl md:text-[36px] text-on-surface leading-none">{{ $stats['dipanggil'] }}</h2>
        </div>

        <!-- Selesai -->
        <div class="glass-card p-4 md:p-6 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-16 md:w-20 h-16 md:h-20 bg-emerald-500/10 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[24px] md:text-[28px]" style="font-variation-settings: 'FILL' 1;">task_alt</span>
                </div>
                <span class="text-[8px] md:text-[10px] font-bold text-emerald-600 px-2 py-1 bg-emerald-500/5 rounded-lg">SUCCESS</span>
            </div>
            <p class="text-[10px] md:text-label-sm text-on-surface-variant uppercase mb-1">Selesai</p>
            <h2 class="font-h1 text-2xl md:text-[36px] text-on-surface leading-none">{{ $stats['selesai'] }}</h2>
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
                            <tr class="text-left text-[10px] md:text-label-sm text-on-surface-variant border-b border-emerald-50">
                                <th class="pb-4 font-bold">NOMOR</th>
                                <th class="pb-4 font-bold">MAHASISWA</th>
                                <th class="pb-4 font-bold hidden md:table-cell">LAYANAN</th>
                                <th class="pb-4 font-bold">STATUS</th>
                                <th class="pb-4 font-bold text-right">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-emerald-50/50">
                            @forelse($antrians as $antrian)
                            <tr class="group hover:bg-surface-container-low transition-colors">
                                <td class="py-4 md:py-5">
                                    <span class="px-2 md:px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full font-bold text-xs md:text-base">A-{{ $antrian->nomor }}</span>
                                </td>
                                <td class="py-4 md:py-5">
                                    <p class="font-bold text-on-surface text-xs md:text-base leading-tight">{{ $antrian->user->name }}</p>
                                    <p class="text-[10px] md:text-[11px] text-on-surface-variant hidden sm:block">{{ $antrian->user->username }}</p>
                                    <p class="text-[10px] text-primary md:hidden">{{ $antrian->layanan->nama }}</p>
                                </td>
                                <td class="py-4 md:py-5 text-sm hidden md:table-cell">{{ $antrian->layanan->nama }}</td>
                                <td class="py-4 md:py-5">
                                    @php
                                        $statusClass = $antrian->status === 'dipanggil' ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700';
                                    @endphp
                                    <span class="px-2 md:px-3 py-0.5 md:py-1 {{ $statusClass }} rounded-full text-[9px] md:text-[10px] font-bold uppercase tracking-wider">{{ $antrian->status }}</span>
                                </td>
                                <td class="py-4 md:py-5 text-right">
                                    <div class="flex justify-end gap-1 md:gap-2">
                                        @if($antrian->status === 'menunggu')
                                        <form action="{{ route('admin.antrian.updateStatus', $antrian) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="status" value="dipanggil">
                                            <button type="submit" class="p-2 bg-primary text-on-primary rounded-lg hover:brightness-110 transition-all flex items-center gap-1 text-[10px] md:text-xs px-2 md:px-3 shadow-sm active:scale-95">
                                                <span class="material-symbols-outlined text-sm md:text-base">campaign</span>
                                                <span class="hidden xs:inline">Panggil</span>
                                            </button>
                                        </form>
                                        @elseif($antrian->status === 'dipanggil')
                                        <form action="{{ route('admin.antrian.updateStatus', $antrian) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="status" value="dipanggil">
                                            <button type="submit" class="p-2 bg-blue-600 text-on-primary rounded-lg hover:brightness-110 transition-all flex items-center gap-1 text-[10px] md:text-xs px-2 md:px-3 shadow-sm active:scale-95" title="Panggil Ulang">
                                                <span class="material-symbols-outlined text-sm md:text-base">volume_up</span>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.antrian.updateStatus', $antrian) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="status" value="selesai">
                                            <button type="submit" class="p-2 bg-emerald-600 text-on-primary rounded-lg hover:brightness-110 transition-all flex items-center gap-1 text-[10px] md:text-xs px-2 md:px-3 shadow-sm active:scale-95">
                                                <span class="material-symbols-outlined text-sm md:text-base">check</span>
                                                <span class="hidden xs:inline">Selesai</span>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
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
            <div class="glass-card p-4 md:p-lg h-full">
                <h2 class="font-h2 text-lg md:text-h2 mb-6 md:mb-8 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-xl md:text-2xl">desk</span>
                    Status Loket
                </h2>
                <div class="flex flex-col gap-4">
                    <div class="p-3 md:p-4 rounded-2xl bg-surface-container-low border border-emerald-50 flex items-center justify-between hover:border-primary/30 transition-all cursor-default">
                        <div class="flex items-center gap-3 md:gap-4">
                            <div class="w-8 h-8 md:w-10 md:h-10 rounded-lg md:rounded-xl bg-primary text-on-primary flex items-center justify-center font-bold text-sm md:text-base">1</div>
                            <div>
                                <p class="font-bold text-on-surface text-sm md:text-base">Loket Utama</p>
                                <p class="text-[10px] md:text-xs text-on-surface-variant">{{ Auth::user()->name }}</p>
                            </div>
                        </div>
                        <span class="px-2 md:px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-[9px] md:text-[10px] font-bold">ONLINE</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('panggil_nomor'))
            const nomor = "{{ session('panggil_nomor') }}";
            const loket = "{{ session('panggil_loket') }}";
            const text = `Nomor antrian A ${nomor}, silakan menuju ke ${loket}`;
            
            // Beri sedikit delay agar browser siap
            setTimeout(() => {
                if (window.responsiveVoice) {
                    responsiveVoice.speak(text, "Indonesian Female", { 
                        rate: 0.9, 
                        pitch: 1,
                        onstart: () => console.log("Voice started"),
                        onend: () => console.log("Voice ended")
                    });
                } else {
                    console.error("ResponsiveVoice not loaded. Check API Key in layout.");
                }
            }, 500);
        @endif
    });
</script>
@endsection
