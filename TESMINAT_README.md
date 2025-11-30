# Tes Minat UKM - Dokumentasi

## 📋 Deskripsi
Sistem Tes Minat UKM adalah fitur untuk membantu mahasiswa menemukan Unit Kegiatan Mahasiswa (UKM) yang sesuai dengan minat dan bakat mereka melalui kuesioner.

## 🎯 Fitur Utama

### 1. Form Multi-Step (3 Halaman)
- **Halaman 1**: Form Biodata Mahasiswa
- **Halaman 2**: Kuesioner dengan 4 pertanyaan (Skala Likert 1-5)
- **Halaman 3**: Hasil Rekomendasi UKM

### 2. Validasi Input
- **NIM**: Hanya menerima angka (contoh: 230130019)
- **Angkatan**: Dropdown otomatis dari 2022 hingga tahun sekarang + 1
- **Form Validation**: Semua field wajib diisi

### 3. UI/UX
- Radio button berbentuk circle dengan angka
- Hover effect dan animasi smooth
- Responsive design (mobile & desktop)
- Progress indicator (Hal 1 of 3, 2 of 3, 3 of 3)

## 📁 Struktur File

```
app/Http/Controllers/
└── TesMinatController.php          # Controller utama

resources/views/
└── tesminat.blade.php               # View form multi-step

routes/
└── web.php                          # Routes definition

database/seeders/
├── SoalSeeder.php                   # Seeder untuk pertanyaan
└── DatabaseSeeder.php               # Main seeder

app/Models/
├── Soal.php                         # Model pertanyaan
├── TesMinat.php                     # Model hasil tes
└── Ormawa.php                       # Model UKM
```

## 🚀 Cara Menggunakan

### Akses Halaman
```
http://localhost/tesminat
atau
http://simawa.test/tesminat
```

### Flow Penggunaan
1. **Isi Biodata**
   - Nama Lengkap
   - NIM (hanya angka)
   - Program Studi
   - Angkatan (pilih dari dropdown)
   - Klik "Selanjutnya"

2. **Jawab Kuesioner**
   - Baca setiap pertanyaan
   - Pilih jawaban 1-5 (klik circle)
   - Klik "Submit"

3. **Lihat Rekomendasi**
   - Logo UKM
   - Nama UKM
   - Deskripsi UKM
   - Klik "Kembali ke Beranda"

## 🔧 Instalasi & Setup

### 1. Jalankan Migration
```bash
php artisan migrate
```

### 2. Jalankan Seeder
```bash
php artisan db:seed --class=SoalSeeder
```

Atau jalankan semua seeder:
```bash
php artisan migrate:fresh --seed
```

## 📊 Database

### Tabel: `soal`
- `id_soal` (Primary Key)
- `pertanyaan` (Text)
- `skala_likert` (Integer, default: 5)
- `created_at`, `updated_at`

### Tabel: `tes_minat`
- `id_tes` (Primary Key)
- `user_id` (Foreign Key)
- `id_jawaban` (Foreign Key)
- `id_soal` (Foreign Key)
- `hasil_rekomendasi` (Text)
- `created_at`, `updated_at`

## 🎨 Kustomisasi

### Menambah Pertanyaan
Edit file `database/seeders/SoalSeeder.php`:
```php
$soals = [
    [
        'pertanyaan' => 'Pertanyaan baru...',
        'skala_likert' => 5,
    ],
    // tambahkan pertanyaan lainnya
];
```

### Mengubah Tahun Mulai Angkatan
Edit file `resources/views/tesminat.blade.php`:
```javascript
const startYear = 2022; // Ubah sesuai kebutuhan
```

### Mengubah Algoritma Rekomendasi
Edit file `app/Http/Controllers/TesMinatController.php` method `submit()`:
```php
// TODO: Implementasi algoritma rekomendasi berdasarkan jawaban
// Saat ini menggunakan random, bisa diganti dengan algoritma scoring
```

## 🐛 Troubleshooting

### Error: "Tidak ada UKM yang tersedia"
**Solusi**: Pastikan tabel `ormawa` sudah terisi dengan data UKM
```bash
php artisan db:seed --class=OrmawaSeeder
```

### NIM tidak bisa diisi huruf
**Status**: ✅ Ini adalah fitur, bukan bug. NIM hanya menerima angka.

### Dropdown angkatan kosong
**Solusi**: Refresh halaman atau clear cache browser

## 📝 Catatan Pengembangan

### TODO Future Enhancement
- [ ] Implementasi algoritma rekomendasi berbasis scoring
- [ ] Simpan hasil tes ke database
- [ ] Riwayat tes untuk user yang login
- [ ] Export hasil tes ke PDF
- [ ] Dashboard admin untuk melihat statistik tes
- [ ] Tambah lebih banyak pertanyaan
- [ ] Kategori UKM (Olahraga, Seni, Teknologi, dll)

### Known Issues
- Rekomendasi saat ini masih random (belum ada algoritma scoring)
- Hasil tes belum tersimpan ke database

## 👨‍💻 Developer Notes

### Code Style
- PHP: PSR-12 Standard
- JavaScript: ES6+
- CSS: Tailwind CSS utility classes
- Blade: Laravel Blade Template

### Best Practices
- Semua function memiliki dokumentasi
- Validasi input di client & server side
- Error handling dengan try-catch
- Responsive design first approach

## 📞 Support

Jika ada pertanyaan atau issue, silakan hubungi tim developer SIMAWA ITH.

---

**Version**: 1.0.0  
**Last Updated**: 2025  
**Developed by**: SIMAWA ITH Development Team
