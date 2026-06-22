@extends('layouts.template')

@section('title', 'Manajemen Antrian - Campus Queue')

@section('content')
<main class="pt-24 pb-12 px-4 md:px-8 max-w-7xl mx-auto">
    <header class="mb-8 md:mb-10">
        <h1 class="font-h1 text-2xl md:text-h1 text-on-surface mb-2">Manajemen Antrian</h1>
        <p class="text-on-surface-variant text-sm md:text-body-lg">Kelola status antrian dan panggil mahasiswa sesuai urutan.</p>
    </header>

    <div class="glass-card p-4 md:p-lg">
        <div class="flex flex-col md:flex-row gap-4 mb-6 md:mb-8 justify-between items-start md:items-center">
            <div class="relative w-full md:w-80">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">search</span>
                <input type="text" placeholder="Cari nomor atau nama..." class="w-full pl-12 pr-4 py-3 bg-surface-container-low border-none rounded-xl focus:ring-2 focus:ring-primary/20 outline-none">
            </div>
            <div class="flex flex-wrap gap-2 items-center">
                <a href="{{ route('admin.antrian') }}" class="px-4 py-2 {{ !request('status') ? 'bg-primary text-on-primary shadow-md' : 'bg-surface-container-low text-on-surface-variant hover:bg-emerald-50' }} rounded-lg font-bold text-sm transition-all">Semua</a>
                <a href="{{ route('admin.antrian', ['status' => 'menunggu']) }}" class="px-4 py-2 {{ request('status') === 'menunggu' ? 'bg-amber-500 text-white shadow-md' : 'bg-surface-container-low text-on-surface-variant hover:bg-amber-50' }} rounded-lg font-bold text-sm transition-all">Menunggu</a>
                <a href="{{ route('admin.antrian', ['status' => 'dipanggil']) }}" class="px-4 py-2 {{ request('status') === 'dipanggil' ? 'bg-blue-600 text-white shadow-md' : 'bg-surface-container-low text-on-surface-variant hover:bg-blue-50' }} rounded-lg font-bold text-sm transition-all">Dipanggil</a>
                <a href="{{ route('admin.antrian', ['status' => 'selesai']) }}" class="px-4 py-2 {{ request('status') === 'selesai' ? 'bg-emerald-600 text-white shadow-md' : 'bg-surface-container-low text-on-surface-variant hover:bg-emerald-50' }} rounded-lg font-bold text-sm transition-all">Selesai</a>
                
                <div class="h-8 w-px bg-emerald-100 mx-2"></div>
                
                <form action="{{ route('admin.antrian.reset') }}" method="POST" onsubmit="return confirm('PENTING: Seluruh data antrian akan dihapus permanen. Tindakan ini tidak dapat dibatalkan. Apakah Anda yakin?')">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-error text-on-primary rounded-lg font-bold text-sm hover:brightness-110 transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">delete_sweep</span>
                        Reset Antrian
                    </button>
                </form>
            </div>
        </div>

        <div class="overflow-x-auto -mx-4 md:mx-0 px-4 md:px-0">
            <table class="w-full min-w-[700px] md:min-w-0">
                <thead>
                    <tr class="text-left text-xs md:text-label-sm text-on-surface-variant border-b border-emerald-50">
                        <th class="pb-4 font-bold">WAKTU</th>
                        <th class="pb-4 font-bold">NOMOR</th>
                        <th class="pb-4 font-bold">MAHASISWA</th>
                        <th class="pb-4 font-bold">LAYANAN</th>
                        <th class="pb-4 font-bold">STATUS</th>
                        <th class="pb-4 font-bold text-right hidden md:table-cell">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-emerald-50/50">
                    @foreach($antrians as $antrian)
                    <tr class="group hover:bg-surface-container-low transition-colors relative" x-data="{ open: false }" @click="if(window.innerWidth < 768) open = !open" @click.away="open = false">
                        <td class="py-4 md:py-5 text-xs md:text-sm text-on-surface-variant">{{ $antrian->created_at->format('H:i') }}</td>
                        <td class="py-4 md:py-5 font-bold text-primary text-sm md:text-base">A-{{ $antrian->nomor }}</td>
                        <td class="py-4 md:py-5">
                            <p class="font-bold text-sm md:text-base">{{ $antrian->user->name }}</p>
                            <p class="text-[10px] md:text-xs text-on-surface-variant">{{ $antrian->user->username }}</p>
                        </td>
                        <td class="py-4 md:py-5 text-sm md:text-base">{{ $antrian->layanan->nama }}</td>
                        <td class="py-4 md:py-5">
                            @php
                                $statusClass = match($antrian->status) {
                                    'menunggu' => 'bg-amber-100 text-amber-700',
                                    'dipanggil' => 'bg-blue-100 text-blue-700',
                                    'selesai' => 'bg-emerald-100 text-emerald-700',
                                    default => 'bg-gray-100 text-gray-700'
                                };
                            @endphp
                            <span class="px-2 md:px-3 py-1 {{ $statusClass }} rounded-full text-[10px] md:text-[11px] font-bold">{{ ucfirst($antrian->status) }}</span>
                        </td>
                        <td class="py-4 md:py-5 text-right relative hidden md:table-cell">
                            <div class="flex justify-end gap-1 md:gap-2">
                                <!-- Desktop Primary Actions -->
                                <div class="hidden md:flex gap-1 md:gap-2">
                                    @if($antrian->status === 'menunggu')
                                    <form action="{{ route('admin.antrian.updateStatus', $antrian) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="dipanggil">
                                        <button type="submit" class="p-2 md:p-2 bg-primary text-on-primary rounded-lg hover:brightness-110 transition-all flex items-center gap-1 text-[10px] md:text-xs px-2 md:px-3">
                                            <span class="material-symbols-outlined text-sm">campaign</span> <span class="hidden xs:inline">Panggil</span>
                                        </button>
                                    </form>
                                    @elseif($antrian->status === 'dipanggil')
                                    <form action="{{ route('admin.antrian.updateStatus', $antrian) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="dipanggil">
                                        <button type="submit" class="p-2 md:p-2 bg-amber-500 text-on-primary rounded-lg hover:brightness-110 transition-all flex items-center gap-1 text-[10px] md:text-xs px-2 md:px-3" title="Panggil Lagi">
                                            <span class="material-symbols-outlined text-sm">campaign</span>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.antrian.updateStatus', $antrian) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="selesai">
                                        <button type="submit" class="p-2 md:p-2 bg-emerald-600 text-on-primary rounded-lg hover:brightness-110 transition-all flex items-center gap-1 text-[10px] md:text-xs px-2 md:px-3">
                                            <span class="material-symbols-outlined text-sm">check</span> <span class="hidden xs:inline">Selesai</span>
                                        </button>
                                    </form>
                                    @endif
                                </div>

                                <!-- Desktop Secondary Actions Dropdown (Only visible on MD+) -->
                                <div class="hidden md:inline-block relative text-left" x-data="{ dropdownOpen: false }">
                                    <button @click="dropdownOpen = !dropdownOpen" class="p-2 border border-emerald-100 text-on-surface-variant rounded-lg hover:bg-emerald-50 transition-all shadow-sm bg-white dark:bg-surface-container-low dark:border-emerald-800">
                                        <span class="material-symbols-outlined text-sm">more_vert</span>
                                    </button>
                                    <div x-show="dropdownOpen" @click.away="dropdownOpen = false" style="display: none;" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white dark:bg-surface-container ring-1 ring-black ring-opacity-5 z-50 overflow-hidden border border-emerald-50 dark:border-emerald-800">
                                        <div class="py-1">
                                            @if($antrian->status !== 'batal')
                                            <form action="{{ route('admin.antrian.updateStatus', $antrian) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="batal">
                                                <button type="submit" class="block px-4 py-2.5 text-sm text-error dark:text-red-400 hover:bg-error-container/20 w-full text-left flex items-center gap-2">
                                                    <span class="material-symbols-outlined text-[16px]">cancel</span> Batalkan Antrian
                                                </button>
                                            </form>
                                            @endif
                                            @if($antrian->status !== 'menunggu')
                                            <form action="{{ route('admin.antrian.updateStatus', $antrian) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="menunggu">
                                                <button type="submit" class="block px-4 py-2.5 text-sm text-amber-600 dark:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-900/30 w-full text-left flex items-center gap-2">
                                                    <span class="material-symbols-outlined text-[16px]">refresh</span> Reset ke Menunggu
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Mobile All Actions Bottom Sheet -->
                                <template x-teleport="body">
                                    <div x-show="open" style="display: none;" class="md:hidden fixed inset-0 z-[100] flex items-end sm:items-center justify-center">
                                        <div x-show="open" x-transition.opacity @click="open = false" class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
                                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="translate-y-full opacity-0" x-transition:enter-end="translate-y-0 opacity-100" class="relative w-full bg-surface-container rounded-t-3xl p-4 shadow-2xl border-t border-emerald-100 dark:border-emerald-800">
                                            <div class="w-12 h-1.5 bg-emerald-100 dark:bg-emerald-800 rounded-full mx-auto mb-4"></div>
                                            <h3 class="text-center font-bold text-sm text-on-surface-variant mb-4">Aksi A-{{ $antrian->nomor }}</h3>
                                            
                                            <div class="flex flex-col gap-2">
                                                <!-- Primary Actions -->
                                                @if($antrian->status === 'menunggu')
                                                <form action="{{ route('admin.antrian.updateStatus', $antrian) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="dipanggil">
                                                    <button type="submit" class="w-full text-center px-4 py-3 bg-primary/10 text-primary rounded-xl font-bold flex items-center justify-center gap-2">
                                                        <span class="material-symbols-outlined text-[18px]">campaign</span> Panggil
                                                    </button>
                                                </form>
                                                @elseif($antrian->status === 'dipanggil')
                                                <form action="{{ route('admin.antrian.updateStatus', $antrian) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="dipanggil">
                                                    <button type="submit" class="w-full text-center px-4 py-3 bg-blue-600/10 text-blue-600 rounded-xl font-bold flex items-center justify-center gap-2">
                                                        <span class="material-symbols-outlined text-[18px]">volume_up</span> Panggil Lagi
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.antrian.updateStatus', $antrian) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="selesai">
                                                    <button type="submit" class="w-full text-center px-4 py-3 bg-emerald-600/10 text-emerald-600 rounded-xl font-bold flex items-center justify-center gap-2">
                                                        <span class="material-symbols-outlined text-[18px]">check</span> Selesai
                                                    </button>
                                                </form>
                                                @endif

                                                <div class="h-px bg-emerald-50 dark:bg-emerald-800/50 my-1"></div>

                                                <!-- Secondary Actions -->
                                                @if($antrian->status !== 'batal')
                                                <form action="{{ route('admin.antrian.updateStatus', $antrian) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="batal">
                                                    <button type="submit" class="w-full text-center px-4 py-3 bg-error/10 text-error rounded-xl font-bold flex items-center justify-center gap-2">
                                                        <span class="material-symbols-outlined text-[18px]">cancel</span> Batalkan Antrian
                                                    </button>
                                                </form>
                                                @endif
                                                @if($antrian->status !== 'menunggu')
                                                <form action="{{ route('admin.antrian.updateStatus', $antrian) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="menunggu">
                                                    <button type="submit" class="w-full text-center px-4 py-3 bg-amber-500/10 text-amber-600 rounded-xl font-bold flex items-center justify-center gap-2">
                                                        <span class="material-symbols-outlined text-[18px]">refresh</span> Reset ke Menunggu
                                                    </button>
                                                </form>
                                                @endif

                                                <button @click="open = false" class="w-full mt-2 px-4 py-3 text-sm text-on-surface-variant font-bold text-center hover:bg-surface-container-low rounded-xl">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
            
            setTimeout(() => {
                if (window.responsiveVoice) {
                    responsiveVoice.speak(text, "Indonesian Female", { 
                        rate: 0.9, 
                        pitch: 1 
                    });
                }
            }, 500);
        @endif
    });
</script>
@endsection
