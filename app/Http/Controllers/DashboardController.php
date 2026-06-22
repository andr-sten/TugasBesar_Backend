<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\Jadwal;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('landing');
    }

    public function dashboard(Request $request)
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            $stats = [
                'total' => Antrian::whereIn('status', ['menunggu', 'dipanggil'])->count(),
                'menunggu' => Antrian::where('status', 'menunggu')->count(),
                'dipanggil' => Antrian::where('status', 'dipanggil')->count(),
                'selesai' => Antrian::where('status', 'selesai')->count(),
            ];
            $antrians = Antrian::whereIn('status', ['menunggu', 'dipanggil'])
                ->with(['user', 'layanan'])
                ->latest()
                ->take(5)
                ->get();
            $jadwals = \App\Models\Jadwal::with('layanan')
                ->orderBy('tanggal', 'desc')
                ->orderBy('jam_mulai', 'desc')
                ->get();
                
            $antrianAktif = \App\Models\Antrian::where('user_id', $user->id)
                ->whereIn('status', ['menunggu', 'dipanggil'])
                ->with(['layanan', 'jadwal'])
                ->first();
                
            $antrianDiDepan = 0;
            if ($antrianAktif && $antrianAktif->status === 'menunggu') {
                $antrianDiDepan = \App\Models\Antrian::where('jadwal_id', $antrianAktif->jadwal_id)
                    ->where('nomor', '<', $antrianAktif->nomor)
                    ->where('status', 'menunggu')
                    ->count();
            }
                
            return view('admin.dashboard', compact('stats', 'antrians', 'jadwals', 'antrianAktif', 'antrianDiDepan'));
        }

        // For Mahasiswa
        $antrianAktif = Antrian::where('user_id', $user->id)
            ->whereIn('status', ['menunggu', 'dipanggil'])
            ->with(['layanan', 'jadwal'])
            ->first();

        $antrianDiDepan = 0;
        if ($antrianAktif && $antrianAktif->status === 'menunggu') {
            $antrianDiDepan = Antrian::where('jadwal_id', $antrianAktif->jadwal_id)
                ->where('nomor', '<', $antrianAktif->nomor)
                ->where('status', 'menunggu')
                ->count();
        }

        $jadwals = Layanan::with(['jadwal' => function($query) {
            $query->orderBy('tanggal', 'desc')
                  ->orderBy('jam_mulai', 'desc');
        }])->take(3)->get();

        $riwayats = Antrian::where('user_id', $user->id)
            ->whereIn('status', ['selesai', 'batal'])
            ->with('layanan')
            ->latest()
            ->take(3)
            ->get();

        $scannedJadwalId = $request->query('jadwal_id');
        $scannedLayanan = null;
        if ($scannedJadwalId) {
            $jadwal = Jadwal::find($scannedJadwalId);
            if ($jadwal) {
                $scannedLayanan = $jadwal->layanan_id;
            }
        }

        return view('mahasiswa.dashboard', compact('user', 'antrianAktif', 'jadwals', 'riwayats', 'antrianDiDepan', 'scannedLayanan'));
    }

    public function pilihLayanan()
    {
        $layanans = Layanan::with(['jadwal' => function($query) {
            $query->orderBy('tanggal', 'asc')
                  ->orderBy('jam_mulai', 'asc');
        }])->get();
        return view('mahasiswa.pilih-layanan', compact('layanans'));
    }

    public function manajemenAntrian(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $query = Antrian::with(['user', 'layanan', 'jadwal']);

        if ($request->has('status') && in_array($request->status, ['menunggu', 'dipanggil', 'selesai', 'batal'])) {
            $query->where('status', $request->status);
        }

        $antrians = $query->latest()->get();
        return view('admin.manajemen-antrian', compact('antrians'));
    }

    public function registerForm()
    {
        return view('auth.register');
    }

    public function scanQr()
    {
        return view('mahasiswa.scan');
    }

    public function riwayat()
    {
        $riwayats = Antrian::where('user_id', Auth::id())
            ->whereIn('status', ['selesai', 'batal'])
            ->with(['layanan', 'jadwal'])
            ->latest()
            ->get();
        return view('mahasiswa.riwayat', compact('riwayats'));
    }
}
