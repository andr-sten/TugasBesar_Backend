@extends('layouts.template')

@section('title', 'Kelola Layanan - Campus Queue')

@section('content')
<main class="pt-24 pb-12 px-4 md:px-8 max-w-7xl mx-auto">
    <header class="mb-8 md:mb-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <h1 class="font-h1 text-2xl md:text-h1 text-on-surface mb-2">Kelola Layanan</h1>
            <p class="text-on-surface-variant text-sm md:text-body-lg">Tambah, ubah, atau hapus kategori layanan administrasi.</p>
        </div>
        <a href="{{ route('admin.layanan.create') }}" class="w-full md:w-auto justify-center px-6 py-3 bg-primary text-on-primary rounded-xl font-bold flex items-center gap-2 shadow-lg hover:brightness-110 transition-all">
            <span class="material-symbols-outlined">add</span>
            Tambah Layanan
        </a>
    </header>

    <div class="glass-card p-4 md:p-lg overflow-hidden">
        <div class="overflow-x-auto -mx-4 md:mx-0 px-4 md:px-0">
            <table class="w-full min-w-[500px] md:min-w-0">
                <thead>
                    <tr class="text-left text-xs md:text-label-sm text-on-surface-variant border-b border-emerald-50">
                        <th class="pb-4 font-bold">ID</th>
                        <th class="pb-4 font-bold">NAMA LAYANAN</th>
                        <th class="pb-4 font-bold">DURASI</th>
                        <th class="pb-4 font-bold hidden sm:table-cell">RUANGAN</th>
                        <th class="pb-4 font-bold text-right hidden md:table-cell">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-emerald-50/50">
                    @forelse($layanans as $layanan)
                    <tr class="group hover:bg-surface-container-low transition-colors relative" x-data="{ open: false }" @click="if(window.innerWidth < 768) open = !open" @click.away="open = false">
                        <td class="py-4 md:py-5 font-bold text-slate-500 text-sm md:text-base">#{{ $layanan->id }}</td>
                        <td class="py-4 md:py-5">
                            <p class="font-bold text-on-surface text-sm md:text-base">{{ $layanan->nama }}</p>
                            <p class="text-xs text-on-surface-variant sm:hidden">{{ $layanan->ruangan }}</p>
                        </td>
                        <td class="py-4 md:py-5">
                            <span class="flex items-center gap-1 md:gap-2 text-xs md:text-sm">
                                <span class="material-symbols-outlined text-sm text-slate-400">schedule</span>
                                {{ $layanan->durasi }} Mnt
                            </span>
                        </td>
                        <td class="py-4 md:py-5 hidden sm:table-cell">
                            <span class="flex items-center gap-2 text-sm">
                                <span class="material-symbols-outlined text-sm text-slate-400">meeting_room</span>
                                {{ $layanan->ruangan }}
                            </span>
                        </td>
                        <td class="py-4 md:py-5 text-right relative hidden md:table-cell">
                            <!-- Desktop Actions -->
                            <div class="hidden md:flex justify-end gap-2">
                                <a href="{{ route('admin.layanan.edit', $layanan) }}" class="p-2 text-primary hover:bg-primary-container/20 rounded-lg transition-all">
                                    <span class="material-symbols-outlined">edit</span>
                                </a>
                                <form id="form-delete-layanan-{{$layanan->id}}" action="{{ route('admin.layanan.destroy', $layanan) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" @click="openConfirm('form-delete-layanan-{{$layanan->id}}', 'Apakah Anda yakin ingin menghapus layanan ini?')" class="p-2 text-error hover:bg-error-container/20 rounded-lg transition-all">
                                        <span class="material-symbols-outlined">delete</span>
                                    </button>
                                </form>
                            </div>
                            <!-- Mobile Actions Bottom Sheet -->
                            <template x-teleport="body">
                                <div x-show="open" style="display: none;" class="md:hidden fixed inset-0 z-[100] flex items-end sm:items-center justify-center">
                                    <div x-show="open" x-transition.opacity @click="open = false" class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
                                    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="translate-y-full opacity-0" x-transition:enter-end="translate-y-0 opacity-100" class="relative w-full bg-surface-container rounded-t-3xl p-4 shadow-2xl border-t border-emerald-100 dark:border-emerald-800">
                                        <div class="w-12 h-1.5 bg-emerald-100 dark:bg-emerald-800 rounded-full mx-auto mb-4"></div>
                                        <h3 class="text-center font-bold text-sm text-on-surface-variant mb-4">Aksi Layanan</h3>
                                        <div class="flex flex-col gap-2">
                                            <a href="{{ route('admin.layanan.edit', $layanan) }}" class="w-full text-center px-4 py-3 bg-primary/10 text-primary rounded-xl font-bold flex items-center justify-center gap-2">
                                                <span class="material-symbols-outlined text-[18px]">edit</span> Edit
                                            </a>
                                            <form id="form-mobile-delete-layanan-{{$layanan->id}}" action="{{ route('admin.layanan.destroy', $layanan) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" @click="openConfirm('form-mobile-delete-layanan-{{$layanan->id}}', 'Apakah Anda yakin ingin menghapus layanan ini?'); open = false;" class="w-full text-center px-4 py-3 bg-error/10 text-error rounded-xl font-bold flex items-center justify-center gap-2">
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
                        <td colspan="5" class="py-10 text-center text-on-surface-variant">Belum ada data layanan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection
