@extends('layouts.custom')

@section('title', 'Scan QR Code - Campus Queue')

@section('content')
<main class="pt-24 pb-12 px-8 max-w-xl mx-auto text-center">
    <header class="mb-8">
        <h1 class="font-h1 text-h1 text-on-surface mb-2">Pindai Kode QR</h1>
        <p class="text-on-surface-variant font-body-lg">Arahkan kamera ke kode QR jadwal untuk mengambil antrian secara instan.</p>
    </header>

    <div id="scanner-container" class="w-full aspect-square max-w-md mx-auto rounded-2xl border-4 border-primary shadow-lg shadow-primary/20 relative">
        <div id="reader" class="w-full h-full"></div>
    </div>
    <div id="scan-result" class="mt-4 text-emerald-700 font-bold"></div>
    <button id="startButton" class="mt-8 px-8 py-4 bg-primary text-on-primary rounded-xl font-bold hover:brightness-110 transition-all shadow-lg">Mulai Pindai</button>
</main>
@endsection


@section('scripts')
<!-- Memuat library html5-qrcode v2.3.8 dari CDN Cloudflare resmi -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const readerElement = document.getElementById('reader');
        const startButton = document.getElementById('startButton');
        const scanResultEl = document.getElementById('scan-result');
        let html5QrCode;

        const qrCodeSuccessCallback = (decodedText, decodedResult) => {
            scanResultEl.textContent = `Berhasil memindai... Mengalihkan...`;
            try {
                const data = JSON.parse(decodedText);
                if (data.type === 'jadwal' && data.id) {
                    if (html5QrCode && html5QrCode.isScanning) {
                        html5QrCode.stop().then(ignore => {
                            window.location.href = `{{ url('/dashboard') }}?scan_success=true&jadwal_id=${data.id}`;
                        }).catch(err => {
                            console.error("Gagal menghentikan scanner.", err);
                            window.location.href = `{{ url('/dashboard') }}?scan_success=true&jadwal_id=${data.id}`;
                        });
                    }
                } else {
                    scanResultEl.textContent = 'QR Code tidak valid.';
                }
            } catch (e) {
                scanResultEl.textContent = 'Format QR Code salah.';
            }
        };

            // Dengan config dinamis proporsional:
    const container = document.getElementById('scanner-container');
    const size = Math.min(container.offsetWidth, container.offsetHeight);
    const boxSize = Math.floor(size * 0.65); // 65% dari ukuran container

    const config = { 
        fps: 10, 
        qrbox: { width: boxSize, height: boxSize },
        aspectRatio: 1.0
    };

        startButton.addEventListener('click', () => {
            // Verifikasi secure context browser
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                scanResultEl.innerHTML = `<span class="text-red-600">Error: Browser Anda memblokir kamera karena koneksi tidak aman.<br>Gunakan alamat <strong>http://127.0.0.1:8000</strong></span>`;
                return;
            }

            startButton.style.display = 'none';
            scanResultEl.textContent = 'Mempersiapkan kamera...';

            if (html5QrCode) {
                html5QrCode.clear();
            }
            
            // Inisialisasi menggunakan library html5-qrcode yang sudah dimuat
            html5QrCode = new Html5Qrcode("reader");

            // Menggunakan facingMode otomatis untuk performa terbaik
            html5QrCode.start(
                { facingMode: "environment" }, 
                config,
                qrCodeSuccessCallback,
                (errorMessage) => {
                    // Abaikan error pembacaan frame biasa
                }
            )
            .then(() => {
                scanResultEl.textContent = 'Kamera aktif! Silakan arahkan ke QR Code.';
                scanResultEl.className = "mt-4 text-emerald-700 font-bold animate-pulse";
            })
            .catch(err => {
                console.warn("Gagal menggunakan kamera belakang, mencoba webcam...", err);
                
                html5QrCode.start(
                    { facingMode: "user" }, 
                    config,
                    qrCodeSuccessCallback,
                    (errorMessage) => {}
                )
                .then(() => {
                    scanResultEl.textContent = 'Kamera aktif (Webcam). Silakan arahkan ke QR Code.';
                    scanResultEl.className = "mt-4 text-emerald-700 font-bold animate-pulse";
                })
                .catch(err2 => {
                    console.error("Semua inisialisasi kamera gagal:", err2);
                    scanResultEl.innerHTML = `<span class="text-red-600">Gagal menyalakan kamera.<br>Pastikan kamera tidak sedang digunakan aplikasi lain.</span>`;
                    startButton.style.display = 'block';
                });
            });
        });
    });
</script>
@endsection
