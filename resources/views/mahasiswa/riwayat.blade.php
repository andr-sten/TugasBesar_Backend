@extends('layouts.template')

@section('title', 'Semua Riwayat - Campus Queue')

@section('content')
<main class="pt-24 pb-12 px-4 md:px-8 max-w-4xl mx-auto min-h-screen">
    <header class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="font-h1 text-2xl md:text-3xl text-on-surface mb-2">Riwayat Antrian</h1>
            <p class="text-on-surface-variant text-sm md:text-base">Daftar semua antrian yang pernah Anda ambil.</p>
        </div>
        <a href="{{ route('dashboard') }}" class="px-4 py-2 border border-emerald-100 dark:border-emerald-800 text-primary dark:text-emerald-400 rounded-xl font-bold hover:bg-emerald-50 dark:hover:bg-emerald-900/30 transition-colors shadow-sm text-sm">
            Kembali
        </a>
    </header>

    <div class="glass-card p-6 md:p-8">
        @if($riwayats->isEmpty())
            <div class="text-center py-12">
                <span class="material-symbols-outlined text-6xl text-slate-300 dark:text-slate-600 mb-4">history</span>
                <p class="text-on-surface-variant font-medium">Anda belum memiliki riwayat antrian.</p>
            </div>
        @else
            <div class="flex flex-col gap-4">
                @foreach($riwayats as $riwayat)
                <div class="flex items-center gap-4 p-4 rounded-2xl bg-surface-container-low border border-emerald-50 hover:border-primary/30 transition-all">
                    <span class="material-symbols-outlined text-[32px] text-primary shrink-0">history</span>
                    <div class="flex-grow">
                        <p class="font-bold text-on-surface text-base md:text-lg">{{ $riwayat->layanan->nama }}</p>
                        <p class="text-sm text-on-surface-variant">{{ $riwayat->created_at->translatedFormat('l, d F Y - H:i') }}</p>
                    </div>
                    <div class="shrink-0 text-right">
                        @if($riwayat->status === 'selesai')
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-400 rounded-full text-[10px] font-bold uppercase tracking-wider">SELESAI</span>
                        @else
                            <span class="px-3 py-1 bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-400 rounded-full text-[10px] font-bold uppercase tracking-wider">BATAL</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</main>
@endsection
