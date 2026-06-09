# Sistem Booking & Antrian Pengambilan Raport

Berdasarkan dokumen `PRD_Booking_System.md` dan kebutuhan yang Anda sampaikan, berikut adalah ringkasan alur dan rencana implementasi sistem booking pengambilan raport:

## Gambaran Umum Produk
Sistem ini memfasilitasi pengambilan raport secara terstruktur untuk menghindari antrian fisik yang panjang. Orang tua dapat memilih slot waktu 20 menit, mendapatkan kepastian waktu, dan melakukan check-in via QR Code di sekolah.

## Alur Sistem

### 1. Modul Admin (Persiapan Data)
- **Input Data:** Admin mengatur semua kebutuhan sistem dengan mengunggah data siswa (beserta relasi kelas dan wali kelas).
- **Manajemen Event:** Admin membuat jadwal event pengambilan raport (tanggal berapa saja) yang secara otomatis akan mem-generate slot waktu (20 menit per sesi) yang bisa dipilih oleh orang tua.
- **Manajemen Wali Kelas:** Admin mendaftarkan wali kelas, dan sistem akan meng-generate PIN 6 digit unik agar wali kelas dapat login nantinya.

### 2. Modul Orang Tua (Booking Online)
- **Akses & Pemilihan:** Orang tua membuka website, memilih kelas dan mengisi nama serta nama anak. Sistem akan mencocokkan data secara otomatis.
- **Pemilihan Jadwal:** Orang tua memilih tanggal dan slot jam (20 menit) yang masih tersedia.
- **Konfirmasi:** Setelah dikonfirmasi, sistem memberikan bukti booking berupa **QR Code** beserta kode unik di bawahnya yang menyerupai boarding pass.

### 3. Modul Resepsionis (Hari H - Di Sekolah)
- **Check-in:** Saat orang tua datang, resepsionis akan men-scan QR Code atau memasukkan kode unik secara manual.
- **Masuk Antrian:** Setelah berhasil di-scan, orang tua otomatis masuk ke dalam sistem antrian digital milik wali kelas anaknya sesuai waktu check-in.

### 4. Modul Wali Kelas (Dashboard Pemanggilan)
- **Login:** Wali kelas login menggunakan PIN unik yang diberikan oleh admin.
- **Dashboard Antrian:** Wali kelas dapat melihat daftar orang tua yang sudah hadir (diurutkan berdasarkan waktu check-in).
- **Pemanggilan:** Wali kelas memanggil orang tua secara berurutan. Nama yang dipanggil akan tampil di layar TV ruang tunggu secara real-time.

---

> [!NOTE]
> Sistem akan menggunakan **PostgreSQL Transaction** untuk menghindari bentrok jadwal (race condition), sehingga jika ada dua orang tua yang mencoba memilih slot yang sama bersamaan, hanya satu yang akan berhasil.

## User Review Required

> [!IMPORTANT]
> Mohon konfirmasi apakah ringkasan alur sistem ini sudah sesuai dengan ekspektasi Anda? Jika ya, kita dapat melanjutkan ke tahap implementasi (pembuatan database dan halaman admin/user).

## Proposed Changes
Implementasi akan dibagi menjadi beberapa fase komponen:
- Setup Database & Schema dengan Prisma
- Pembuatan Modul Admin (Data & Event Management)
- Pembuatan Modul Orang Tua (Booking & QR Generation)
- Pembuatan Modul Resepsionis (QR Scanner & Check-in)
- Pembuatan Modul Wali Kelas & Layar TV (Real-time Queue)

## Verification Plan
1. **Automated Tests:** Memastikan koneksi database dan API routes berjalan dengan baik.
2. **Manual Verification:** 
   - Mensimulasikan pembuatan event oleh admin.
   - Mensimulasikan proses booking oleh orang tua dan memastikan QR Code ter-generate dengan benar.
   - Mensimulasikan scan QR oleh resepsionis dan perpindahan data ke antrian wali kelas.
