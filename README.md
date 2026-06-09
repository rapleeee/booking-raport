<div align="center">
  <h1>Sistem Booking Pengambilan Raport</h1>
  <p>Aplikasi web berbasis Laravel untuk mengelola antrean dan jadwal pengambilan raport siswa secara terstruktur dengan teknologi QR Code Scanner.</p>
</div>

---

## 📖 Ringkasan Proyek
Aplikasi ini dirancang untuk memfasilitasi proses *booking* atau pemesanan jadwal pengambilan raport siswa di sekolah. Tujuannya adalah agar jadwal kunjungan orang tua/wali murid lebih teratur, dan mencegah terjadinya penumpukan antrean pada hari-H. Sistem ini dilengkapi dengan teknologi e-tiket dan **QR Code** yang berfungsi selayaknya *boarding pass* bandara.

## 🚀 Fitur Utama

### 👤 1. Portal Tamu / Orang Tua (Guest System)
- **Tanpa Login:** Orang tua dapat langsung memilih kelas dan nama anak (menggunakan *searchable dropdown*).
- **Pilih Jadwal:** Pemilihan tanggal dan jam (*time slots*) dengan kuota per sesi. Jadwal yang sudah penuh akan otomatis terkunci.
- **E-Tiket & QR Code:** Mencetak tiket digital (*boarding pass*) yang dilengkapi QR Code dan kode registrasi unik.
- **Download & Simpan:** Fitur menyimpan tiket langsung dari browser web.

### 🛡️ 2. Panel Admin
- **Master Data:** Kelola data Wali Kelas, Daftar Kelas, dan Daftar Siswa. Termasuk fitur *import/export* data massal berbasis Excel (`.xlsx`).
- **Manajemen Jadwal:** *Generate* otomatis slot waktu (misal setiap 20 menit) untuk tanggal yang ditentukan (misal 08:00 - 15:00).
- **Laporan:** Monitoring dan manajemen seluruh daftar antrean (*booking*) secara *real-time*.

### 📷 3. Dasbor Resepsionis (Hari-H)
- **Auto-Scanner QR Code:** Memindai e-tiket orang tua menggunakan kamera HP, Webcam, atau *scanner* eksternal secara otomatis dan cepat menggunakan `html5-qrcode` & `QRious`.
- **Input Manual:** Pencarian dan pengecekan menggunakan Kode Unik apabila kamera mengalami kendala.
- **Konfirmasi Hadir:** Begitu berhasil di-*scan*, status orang tua akan tercatat "Hadir" dan otomatis masuk antrean ruangan.

### 👩‍🏫 4. Dasbor Wali Kelas
- **Akses Cepat (PIN):** Akses menggunakan PIN unik milik wali kelas tanpa perlu repot mengetik *password* panjang.
- **Live Queue:** Memantau langsung orang tua mana saja yang sudah tiba (status: Hadir).
- **Pemanggilan Terintegrasi:** Tombol interaktif untuk memanggil orang tua ("Sedang Dipanggil") dan merubah status antrean menjadi "Selesai" jika pengambilan raport sudah usai.

### 📺 5. Live Display Monitor
- **Real-Time Display API:** *Endpoint* API untuk *live queue monitor* yang nantinya akan dikonsumsi oleh *Front-End Next.js* pada layar TV. 
- Hanya menyorot nama yang **Sedang Dipanggil** oleh wali kelas agar orang tua yang sedang menunggu bisa bersiap-siap masuk ruangan.

## 🛠️ Tech Stack & Persyaratan Sistem
- **Framework:** Laravel 11.x (PHP 8.2+)
- **Database:** MySQL / MariaDB
- **Front-End View:** Blade Templating + TailwindCSS (untuk estetika desain).
- **JavaScript & Tools:** `html5-qrcode` (Scanner), `QRious` (Generator), SweetAlert2 (Notifikasi), Alpine.js / Vanilla JS.
- **Excel Module:** Maatwebsite Excel 

## ⚙️ Instalasi (Development)

1. Clone repositori ini
   ```bash
   git clone http://202.200.200.12/raple/booking-sistem.git
   cd booking-web
   ```
2. Install Dependensi
   ```bash
   composer install
   npm install
   npm run build
   ```
3. Siapkan Konfigurasi Lingkungan (`.env`)
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Hubungkan database di file `.env`, lalu jalankan migrasi & *seeder*
   ```bash
   php artisan migrate --seed
   ```
5. Jalankan server lokal
   ```bash
   php artisan serve
   ```

*(Aplikasi berjalan di `http://localhost:8000`)*

## 🛣️ Alur Kerja Singkat (Workflow)
1. **Admin** menginput jadwal dan waktu pembagian raport.
2. **Orang Tua** mendaftar via web untuk waktu tertentu, lalu mendapatkan **QR Code**.
3. **Orang Tua** tiba di sekolah, lalu mendatangi pos **Resepsionis** untuk *scan* QR.
4. Nama orang tua akan otomatis masuk di daftar monitor **Wali Kelas**.
5. **Wali Kelas** menekan tombol Panggil, lalu nama orang tua akan tampil di **Layar TV Antrean**.
6. Orang tua masuk ruangan, selesai.

---
*Dibuat oleh Tim Pengembang (2026).*
