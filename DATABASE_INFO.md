# Informasi Database - Tes Minat UKM

## ✅ Status Database

Database telah berhasil dibuat dan diisi dengan data!

### Tabel yang Dibuat:

1. **soal** - Berisi 4 pertanyaan untuk tes minat
2. **tes_minat** - Menyimpan hasil tes mahasiswa
3. **jawaban** - Menyimpan jawaban mahasiswa
4. **ormawa** - Berisi 6 data UKM (untuk rekomendasi)
5. **users** - Data pengguna
6. Dan tabel lainnya...

## 📊 Data yang Tersedia:

### Tabel `soal` (4 pertanyaan):
1. Saya tertarik belajar hal baru di bidang Sains & Teknologi (Robotik, IoT, dll)
2. Saya suka olahraga dan kegiatan fisik yang menantang adrenalin
3. Saya tertarik membuat karya seni atau hal yang bisa saya ekspresikan
4. Saya suka berkumpul dengan orang lain dan aktif dalam kegiatan kelompok

### Tabel `ormawa` (6 UKM):
- BEM (Badan Eksekutif Mahasiswa)
- HCC (Habibie Computer Club)
- MPM (Mahasiswa Pecinta Mesin)
- HERO (Habibie Esport Organization)
- Dan lainnya...

## 🔍 Cara Cek Database di phpMyAdmin:

1. Buka phpMyAdmin: `http://localhost/phpmyadmin`
2. Pilih database yang Anda gunakan (cek di file `.env`)
3. Lihat tabel:
   - Klik tabel `soal` untuk melihat pertanyaan
   - Klik tabel `ormawa` untuk melihat daftar UKM
   - Klik tabel `tes_minat` untuk melihat hasil tes (akan terisi setelah ada yang mengisi form)

## 🚀 Perintah yang Sudah Dijalankan:

```bash
php artisan migrate:fresh --seed
```

Perintah ini:
- ✅ Menghapus semua tabel lama
- ✅ Membuat ulang semua tabel dari migration
- ✅ Mengisi data awal (seeding):
  - User AdminBEM
  - 6 data Ormawa
  - 4 pertanyaan Soal
  - Roles & Permissions

## 📝 Catatan Penting:

- **Database Name**: Cek di file `.env` pada baris `DB_DATABASE=`
- **Jika data tidak muncul**: Pastikan Anda membuka database yang benar di phpMyAdmin
- **Untuk reset database**: Jalankan lagi `php artisan migrate:fresh --seed`

## 🔐 User Default:

**AdminBEM:**
- Username: `adminbem`
- Password: `adminbem123`

⚠️ **PENTING**: Ganti password ini di production!

## 📞 Troubleshooting:

### Jika tabel tidak muncul di phpMyAdmin:
1. Refresh halaman phpMyAdmin
2. Pastikan database yang dipilih sesuai dengan `.env`
3. Cek koneksi database di file `.env`:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database_anda
   DB_USERNAME=root
   DB_PASSWORD=
   ```

### Jika ingin menambah data soal:
Edit file `database/seeders/SoalSeeder.php` dan jalankan:
```bash
php artisan db:seed --class=SoalSeeder
```

---

**Database siap digunakan! ✅**
