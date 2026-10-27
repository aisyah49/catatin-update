# Deploy Catatin ke Railway (dengan login)

## 1. File di GitHub
Pastikan `Dockerfile` ada di folder paling luar repo (sejajar `composer.json`).
Hapus file lama `app/Http/Middleware/CatatinGate.php` (diganti login asli).

## 2. Variables di service Laravel (Railway)
| Nama | Isi |
|---|---|
| APP_KEY | `php artisan key:generate --show` (buat baru; jangan pakai yang ada di `.env` repo) |
| APP_ENV | production |
| APP_DEBUG | false |
| DB_CONNECTION | mysql |
| DB_URL | `${{MySQL.MYSQL_URL}}` |
| SESSION_DRIVER | database |
| CATATIN_REGISTER | (opsional) `false` untuk menutup pendaftaran setelah akunmu dibuat |

Hapus variabel `CATATIN_PASSWORD` kalau masih ada.

## 3. Database
TIDAK perlu import `db_catatin.sql`. Saat start, `php artisan catatin:setup` otomatis membuat tabel, trigger, view, dan kolom login.
Aman dijalankan berulang dan tidak menghapus data.

## 4. Akun
`catatin:setup` otomatis membuat akun bawaan: **user@gmail.com** / **usercatatin** (data lama otomatis jadi miliknya).
Akun yang didaftarkan sesudahnya selalu mulai KOSONG, dan tiap akun hanya melihat datanya sendiri.
Ganti kata sandi akun bawaan dengan membuat akunmu sendiri; setelah itu `CATATIN_REGISTER=false` bila pendaftaran mau ditutup.

## 5. Aplikasi Android & sinkronisasi
- Di aplikasi: ketuk lencana status di bagian atas (mis. "Masuk untuk sinkron") -> isi alamat server (https://....up.railway.app), email, kata sandi.
- Kata sandi hanya dikirim sekali. Server memberi **token Sanctum** (disimpan di database dalam bentuk hash, hanya berhak "sync", kedaluwarsa 30 hari,
  diperbarui otomatis tiap 7 hari, dicabut saat Keluar). Di HP token disimpan **terenkripsi** (Android Keystore, AES-256-GCM).
- Sinkron otomatis: tiap 5 menit saat aplikasi terbuka, saat internet kembali, saat aplikasi dibuka lagi, dan 4 detik setelah ada perubahan.
- Lencana: Tersinkron / Menyinkronkan / Membangunkan server / Offline / Gagal, plus jumlah perubahan yang menunggu dikirim.
- Konflik versi: memo & tabel yang diubah di dua tempat disimpan dua-duanya; barang yang paling baru menang; folder versi server.

## 6. Cold start (server "tidur")
- Railway: **Settings -> Serverless / App Sleeping = OFF** (paling ampuh; layanan tetap hidup). `railway.json` sudah menyetel health check `/up`.
- Dockerfile memakai OPcache + `php artisan optimize` supaya start dan tiap permintaan lebih cepat.
- Bila server tetap sempat tidur: aplikasi Android memanggil `/up` lebih dulu, menampilkan "Membangunkan server…" dan mencoba ulang (timeout 30-60 dtk).
  Data tetap aman di HP selama menunggu.

## 7. Lokal (Laragon)
Ganti file, lalu jalankan di folder proyek: `php artisan catatin:setup`. Jangan jalankan `setup.bat` lagi.

## Keamanan
`.env` ikut ter-commit di repo; anggap APP_KEY-nya bocor. Pakai APP_KEY baru di Railway, dan tambahkan `.env` ke `.gitignore`.
