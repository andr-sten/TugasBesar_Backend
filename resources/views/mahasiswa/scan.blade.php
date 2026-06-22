@extends('layouts.template')

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
    <div id="scan-result" class="mt-4 text-emerald-700 font-bold">Mempersiapkan kamera...</div>
</main>
@endsection


@section('scripts')
<!-- Memuat library html5-qrcode v2.3.8 dari CDN Cloudflare resmi -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const readerElement = document.getElementById('reader');
        const scanResultEl = document.getElementById('scan-result');
        let html5QrCode;

        const qrCodeSuccessCallback = (decodedText, decodedResult) => {
            scanResultEl.textContent = `Berhasil memindai... Mengalihkan...`;
            scanResultEl.className = "mt-4 text-emerald-700 font-bold";
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
                    scanResultEl.className = "mt-4 text-red-600 font-bold";
                }
            } catch (e) {
                scanResultEl.textContent = 'Format QR Code salah.';
                scanResultEl.className = "mt-4 text-red-600 font-bold";
            }
        };

        const container = document.getElementById('scanner-container');
        const size = Math.min(container.offsetWidth, container.offsetHeight);
        const boxSize = Math.floor(size * 0.65);

        const config = { 
            fps: 10, 
            qrbox: { width: boxSize, height: boxSize },
            aspectRatio: 1.0
        };

        const startScanner = () => {
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                scanResultEl.innerHTML = `<span class="text-red-600">Error: Browser Anda memblokir kamera karena koneksi tidak aman.<br>Gunakan alamat <strong>http://127.0.0.1:8000</strong></span>`;
                return;
            }

            html5QrCode = new Html5Qrcode("reader");

            html5QrCode.start(
                { facingMode: "environment" }, 
                config,
                qrCodeSuccessCallback,
                (errorMessage) => { }
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
                ).then(() => {
                    scanResultEl.textContent = 'Webcam aktif! Silakan arahkan ke QR Code.';
                    scanResultEl.className = "mt-4 text-emerald-700 font-bold animate-pulse";
                }).catch(err2 => {
                    scanResultEl.textContent = 'Gagal mengakses kamera.';
                    scanResultEl.className = "mt-4 text-red-600 font-bold";
                    console.error("Camera error:", err2);
                });
            });
        };

        startScanner();
    });
</script>
@endsection
