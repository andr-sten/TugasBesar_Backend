# 📘 Sistem Reservasi Antrian Layanan Administrasi Kampus (Q-Campus)

Sistem Informasi Manajemen Antrian berbasis Web App (PWA) yang modern, interaktif, dan real-time. Proyek ini mendemonstrasikan penyelesaian masalah antrian fisik di kampus melalui antarmuka web modern dengan implementasi responsivitas tingkat tinggi, animasi canggih, fitur *scan* kamera, text-to-speech, dan Web Push Notification.

---

## 👥 Anggota Kelompok

1. Inez Dea Ariska — STI202303642  
2. Rido Kurniawan — STI202303434  
3. Andrean Syah Putra — STI202303719  
4. Turiman — STI202303581    
5. Fani Amalia — STI202303653  

---

**Hasil deploy website (vercel) :**  

🌐 [Q-campus aplikasi antrian berbasis website](https://tugas-besar-backend.vercel.app/)

## 🚀 Fitur, Alur Penggunaan, dan Logika Koding

Aplikasi ini memiliki 2 peran (*Role*) utama: **Mahasiswa** (pengguna layanan) dan **Admin** (pengelola layanan). Di bawah ini adalah alur penggunaan beserta penjelasan dan potongan logika (*snippet*) kodenya baik dari sisi *Frontend* maupun *Controller Backend/Database*.

### 1. Halaman Landing Page & Autentikasi
Saat pertama kali membuka website, pengguna disuguhkan dengan antarmuka dan animasi yang dinamis dengan *layout* yang adaptif pada landing page, dilanjutkan dengan alur masuk/daftar.
<p align="center">
  <img src="img/landingpage.png" width="48%" />
  <img src="img/loginpage.png" width="48%" />
</p>
<p align="center">
  <img src="img/registerpage.png" width="48%" />
</p>

**💡 Logika Koding: GSAP, Grid Order & Controller Auth**
Pada halaman (*landing page*) ini, ditampilkan visual seperti animasi pengetikan yang dikendalikan sepenuhnya oleh sebuah library animasi JavaScript **GSAP**. dan Untuk responsivitas, tata letak khusus pada mode mobile diatur lewat utilitas *Order* Grid CSS Tailwind. Setelah pengguna tertarik, proses masuk (Autentikasi) diamankan menggunakan sistem Eloquent & `Auth::attempt` murni bawaan Laravel.

```javascript
// Frontend: Animasi GSAP Typing
gsap.to("#typewriter", { duration: 2, text: "Antri Lebih Pintar,", repeat: -1, yoyo: true });
```
```php
// Backend Controller: Register & Login Authentication
User::create(['nim' => $request->nim, 'password' => Hash::make($request->password)]);

if (Auth::attempt(['nim' => $request->nim, 'password' => $request->password])) {
    $request->session()->regenerate();
    return redirect()->intended('/mahasiswa/dashboard');
}
```

---

### 2. Halaman Dashboard Mahasiswa (PWA & Dark Mode)
Sistem mendukung fitur global **Dark Mode** secara utuh dan reaktif.
<p align="center">
  <img src="img/dashboardmahasiswa.png" width="48%" />
  <img src="img/darkmodedemomahasiswa.png" width="48%" />
</p>

**💡 Logika Koding: Dark Mode State & Relasi Eloquent**
Memasuki antarmuka *Dashboard* utama, transisi tema reaktif dikendalikan oleh **Alpine.js** yang tersinkronisasi langsung dengan *LocalStorage* peramban. Di balik layar (*Backend*), data antrian yang tampil diambil secara dinamis berdasarkan hari ini beserta relasi tabel layanannya menggunakan Eloquent ORM.

```html
<!-- Frontend: Toggle Alpine.js tersinkronisasi dengan browser storage -->
<html x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }" 
      x-init="$watch('darkMode', v => localStorage.setItem('theme', v ? 'dark' : 'light'))" 
      :class="{ 'dark': darkMode }">
```
```php
// Backend Controller: Mengambil Jadwal Aktif & Ketersediaan Kuota
$jadwalHariIni = Jadwal::with('layanan')->where('hari', now()->locale('id')->dayName)->get();
```

---

### 3. Fitur Pengambilan Antrian (Scan QR Code & Manual)
Mahasiswa dapat melihat daftar layanan, lalu memindai QR Code dari kamera HP langsung di *browser*.
<p align="center">
  <img src="img/pindaiqrpagemahasiswa.png" width="32%" />
  <img src="img/modalambilantrian.png" width="32%" />
  <img src="img/sucsesambilantrianpage.png" width="32%" />
</p>

**💡 Logika Koding: AJAX Post & Controller Insert Database**
Untuk memfasilitasi pengambilan antrian secara fisik di lokasi, sistem memanfaatkan library `html5-qrcode` yang akan mengakses perangkat keras kamera. Begitu kode QR terdeteksi, algoritma backend akan otomatis menghitung (*generate*) nomor urut terbaru dan memasukkannya ke *Database* tanpa memuat ulang halaman (*Ajax Fetch*).

```javascript
// Frontend: Ekstrak ID dari QR dan POST via Fetch
let urlParams = new URLSearchParams(decodedText.split('?')[1]);
fetch('/mahasiswa/antrian', { method: 'POST', body: JSON.stringify({ layanan_id: urlParams.get('layanan_id') }) });
```
```php
// Backend Controller: Generate Nomor Urut Otomatis & Insert Antrian Baru
$lastAntrian = Antrian::where('jadwal_id', $jadwal->id)->max('nomor_urut');

Antrian::create([
    'user_id' => Auth::id(),
    'jadwal_id' => $jadwal->id,
    'nomor_urut' => $lastAntrian + 1,
    'status' => 'menunggu'
]);
```

---

### 4. Fitur Real-Time Status & Push Notification (Service Worker)
Ketika dipanggil, UI Mahasiswa otomatis menampilkan popup dan **Notifikasi Sistem Operasi** berbunyi (lengkap dengan aksi tombol).
<p align="center">
  <img src="img/antriangeneratemodalmahasiswa.png" width="48%" />
  <img src="img/antriandipanggilmahasiswa.png" width="48%" />
</p>
<p align="center">
  <img src="img/nomorantriancard.png" width="48%" />
</p>

**💡 Logika Koding: Controller Query & Service Worker Action**
Mekanisme *real-time* notifikasi ini mengandalkan teknik *Long-Polling* Javascript yang mengecek secara berkala ke Controller spesifik. Guna mengimplementasikan notifikasi ketat di perangkat *Mobile*, sistem mengeksekusi instruksi pembunyian dan pemunculan *pop-up* melalui celah arsitektur **Service Worker** di (`sw.js`).

```php
// Backend Controller: Polling Check Status Antrian
return response()->json(
    Antrian::where('user_id', Auth::id())->where('status', 'dipanggil')->first()
);
```
```javascript
// Frontend: Membuka Push Notification OS (Bypass Blokir Android)
navigator.serviceWorker.ready.then(reg => {
    reg.showNotification("Panggilan!", {
        body: `Nomor A-${data.nomor} silakan ke Loket.`,
        actions: [{ action: 'oke', title: 'Oke, Menuju Kesana' }]
    });
});
```

---

### 5. Fitur Manajemen Antrian Admin & Text-to-Speech
Browser admin akan otomatis menjadi "speaker" pemanggil antrian.
<p align="center">
  <img src="img/manajemenantrianadmin.png" width="48%" />
  <img src="img/antrianaktiflistadmin.png" width="48%" />
</p>
<p align="center">
  <img src="img/berhasilpanggilantrianadmindashboard.png" width="48%" />
  <img src="img/admindashboard.png" width="48%" />
</p>

**💡 Logika Koding: Update Database & ResponsiveVoice Synthesis**
Pada pengelolaan sesi antrian di halaman ini, ketika Admin menekan tombol "Panggil", sistem menggeser status di basis data secara asinkronus. Kemudian, respon *JSON* yang dikembalikan akan langsung dikonversi menjadi *Text-to-Speech* (Teks ke suara) oleh *browser* admin yang bisa di maksimalkan menggunakan speaker fisik konvensional.

```php
// Backend Controller: Update Status menjadi Dipanggil
$antrian->update(['status' => 'dipanggil']);
return response()->json(['nomor' => $antrian->nomor_urut, 'loket' => $antrian->jadwal->loket]);
```
```javascript
// Frontend: Sintesis Respon JSON Backend menjadi Suara Manusia
let text = `Nomor antrian, A-${data.nomor}, silakan menuju ke ${data.loket}`;
responsiveVoice.speak(text, "Indonesian Female", { rate: 0.85, volume: 1 });
```

---

### 6. Fitur Kelola Data & Generate QR Code (Admin)
Setiap jadwal yang dibuat dapat dicetak menjadi sebuah QRCode untuk dipindai (*scan*).
<p align="center">
  <img src="img/kelolalayananadmin.png" width="32%" />
  <img src="img/kelolajadwaladmin.png" width="32%" />
  <img src="img/generateqronjadwaladmin.png" width="32%" />
</p>
<p align="center">
  <img src="img/generateqrcarddashboardadmin.png" width="48%" />
  <img src="img/tambahadminpageadmin.png" width="48%" />
</p>

**💡 Logika Koding: CRUD Controller & QrCode Frontend**
Sebagai lapisan manajemen master data, setiap *input* dilindungi ketat oleh standar validasi *Backend* Laravel. dalam proses pencetakan visual QR Code, sistem sepenuhnya mengandalkan Javascript di sisi pengguna (*Client-Side Rendering*) demi menjaga beban server (*Anti-Lag*).

```php
// Backend Controller: Standardisasi CRUD & Validasi
Layanan::create($request->validate([
    'nama_layanan' => 'required|string|max:255',
    'deskripsi'    => 'nullable|string'
]));
```
```javascript
// Frontend: Render Objek QR secara langsung di Browser (Anti-Lag Server)
let qr = qrcode(0, 'M');
qr.addData(`${urlAplikasi}?action=scan&layanan_id=${jadwalId}`);
qr.make();
document.getElementById('qr-container').innerHTML = qr.createImgTag(6);
```

---

## 🛠️ Tech Stack & Alat Lingkungan
- **Backend Framework:** Laravel 11 (PHP 8.2), MySQL / Eloquent ORM
- **Frontend & CSS:** Tailwind CSS v3, Konsep *Glassmorphism* UI
- **DOM Scripting / Modals:** Alpine.js (komunikasi Modals lintas *Views* memakai `x-data`)
- **Animations:** GSAP (`Timeline` & `TextPlugin`)
- **Fitur Khusus:** ResponsiveVoice (TTS), Service Worker (Notifikasi PWA HP), HTML5-Qrcode (Akses Kamera QR)
- **Deployment & Hosting Setup:** File `vercel.json` dikonfigurasi untuk menyesuaikan aturan kompilasi PHP-Serverless di infrastruktur *hosting* Vercel secara langsung.
