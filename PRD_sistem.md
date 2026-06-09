# Product Requirements Document (PRD) - Sistem Booking Pengambilan Raport

## 1. Ringkasan Proyek
Proyek ini adalah aplikasi web (berbasis Laravel) untuk memfasilitasi proses booking atau pemesanan jadwal pengambilan raport siswa di sekolah. Sistem ini bertujuan agar jadwal kunjungan orang tua/wali lebih teratur, terstruktur, dan tidak terjadi penumpukan antrean, dengan memanfaatkan teknologi QR Code yang berfungsi menyerupai *boarding pass*.

## 2. Alur Pengguna (User Flow)

### A. Alur Orang Tua / Wali (User)
1. **Pilih Kelas**: Pengguna memilih kelas anak.
2. **Isi Data**: Pengguna memasukkan nama diri (sebagai wali) dan nama anak.
3. **Pilih Waktu**: 
   - Memilih tanggal pengambilan raport.
   - Memilih slot jam yang masih tersedia.
4. **Konfirmasi Booking**: Mengonfirmasi rincian jadwal yang telah dipilih.
5. **Dapatkan E-Tiket**: Mendapatkan tiket digital (*boarding pass*) yang berisi **QR Code** beserta kode unik di bawahnya.

### B. Alur Admin (Master Data & Settings)
Admin mengatur seluruh kebutuhan data sebelum sistem bisa diakses oleh wali murid:
1. **Data Wali Kelas**: Menginput nama-nama wali kelas.
2. **Data Kelas**: Membuat daftar kelas.
3. **Data Siswa**: Menginput nama siswa dan menghubungkannya (relasi) dengan Kelas serta Wali Kelas masing-masing.
4. **Manajemen Jadwal**: Mengatur tanggal event dan membagi slot waktu (*time slots*) yang bisa dipilih oleh orang tua nantinya.

### C. Alur Resepsionis (Saat Hari-H)
1. **Scan/Input Tiket**: Saat orang tua tiba di sekolah, resepsionis akan melakukan *scan* QR Code atau menginput secara manual kode unik yang ada pada e-tiket.
2. **Masuk Antrean**: Setelah tervalidasi, tamu akan terhitung sebagai "Hadir" dan secara otomatis masuk ke dalam sistem antrean kelas masing-masing.

### D. Alur Wali Kelas (Pemanggilan)
1. **Akses Dashboard (PIN)**: Wali kelas masuk ke halaman khusus menggunakan sistem **PIN** (lebih praktis tanpa email/password).
2. **Manajemen Antrean**: Wali kelas dapat melihat daftar orang tua yang statusnya sudah "Hadir" di sekolah berdasarkan hasil scan resepsionis.
3. **Panggil Ke Kelas**: Wali kelas memanggil tiap orang tua sesuai dengan antrean untuk masuk dan mengambil raport.

---

## 3. Keputusan & Aturan Bisnis (Business Rules)
Berdasarkan diskusi, berikut adalah aturan main sistem yang telah disepakati:

1. **Input Nama Anak**: Menggunakan **dropdown** yang datanya bersumber dari input Admin, dilengkapi fitur pencarian (searchable dropdown) agar orang tua mudah mencari nama anak.
2. **Manajemen Kuota & Slot Waktu**:
   - Event akan berlangsung selama 2 hari, dari jam 08:00 - 15:00.
   - Tiap sesi (slot waktu) berdurasi 20 menit (misal: 08:00, 08:20, 08:40, dst).
   - Admin akan men-generate slot waktu tersebut.
   - Kuota per slot adalah **1 orang**. Jika suatu slot di jam tertentu sudah dipilih oleh pengguna lain, maka slot tersebut tidak dapat dipilih lagi (disabled).
3. **Sistem Autentikasi**: Menggunakan sistem **Guest** (tanpa perlu mendaftar akun/login). E-Tiket (beserta QR Code) wajib di-screenshot untuk disimpan, atau sistem akan menyimpannya sementara di *local cache* browser HP orang tua untuk akses cepat keesokan harinya.
4. **Layar Antrean (Display)**: Akan disediakan halaman **Monitor Live Queue** yang dirancang untuk ditampilkan di monitor besar, memudahkan orang tua melihat antrean berjalan.
5. **Distribusi E-Tiket**: Tiket dimunculkan di layar pada sesi akhir booking untuk di-screenshot. Selain itu, disediakan tombol tambahan untuk **Download PDF** dan **Kirim via WhatsApp / Email** (opsional sesuai konfigurasi).
