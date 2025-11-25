# TODO: Database Cleanup - Hapus Tabel Akun

## Progress Tracking

### A. Hapus Tabel & Model Akun
- [x] Hapus file `app/Models/Akun.php` (sudah tidak ada)
- [x] Hapus file `database/migrations/2025_11_16_110128_create_akun_table.php` (sudah tidak ada)

### B. Update Migrasi (Ubah Foreign Key dari `akun` ke `users`)
- [x] `database/migrations/2025_11_16_112257_create_dataorganisasi_table.php`
- [x] `database/migrations/2025_11_16_112258_create_daftar_kegiatan_table.php`
- [x] `database/migrations/2025_11_16_112301_create_berita_table.php`
- [x] `database/migrations/2025_11_16_112304_create_tes_minat_table.php`

### C. Update Models (Ubah Relasi dari `Akun` ke `User`)
- [x] `app/Models/DataOrganisasi.php`
- [x] `app/Models/DaftarKegiatan.php`
- [x] `app/Models/Berita.php`
- [x] `app/Models/TesMinat.php`

### D. Update Model User (Tambah Relasi Balik)
- [x] `app/Models/User.php`

### E. Followup Steps
- [x] Drop database dan migrate ulang: `php artisan migrate:fresh`
- [x] Jalankan seeder jika ada: `php artisan db:seed`
- [x] Cek controller untuk referensi `Akun` (tidak ada ✅)
- [x] Cek views untuk referensi `akun` (tidak ada ✅)

## ✅ SELESAI!

Semua perubahan telah berhasil diterapkan. Database sekarang menggunakan tabel `users` untuk autentikasi dan semua relasi sudah diupdate.

### Perubahan yang Dilakukan:

#### 1. Migrasi
- Semua kolom `id_akun` atau `akun_id` → `user_id`
- Semua foreign key dari `akun` → `users`
- Fix primary key di `dataorganisasi` dari `id_kegiatan` → `id_organisasi`
- Fix kolom di `dataorganisasi` sesuai dengan model

#### 2. Models
- Semua relasi `akun()` → `user()`
- Semua `belongsTo(Akun::class)` → `belongsTo(User::class)`
- Semua foreign key `id_akun` → `user_id`
- Tambah 4 relasi di model User:
  - `dataOrganisasi()`
  - `daftarKegiatan()`
  - `berita()`
  - `tesMinat()`

#### 3. Verifikasi
- ✅ Tidak ada controller yang menggunakan model `Akun`
- ✅ Tidak ada views yang menggunakan referensi `akun`
- ✅ Database berhasil di-migrate
- ✅ Seeder berhasil dijalankan

### Dokumentasi Lengkap
Lihat file `DATABASE_CLEANUP_SUMMARY.md` untuk dokumentasi lengkap tentang perubahan yang telah dilakukan.
