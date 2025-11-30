# Panduan Tes Minat UKM - SIMAWA ITH

## 📋 Deskripsi

Sistem Tes Minat UKM adalah fitur untuk membantu mahasiswa menemukan Unit Kegiatan Mahasiswa (UKM) yang sesuai dengan minat dan bakat mereka melalui kuesioner interaktif.

## 🎨 Tampilan

Sistem ini terdiri dari 3 halaman:

### Halaman 1: Form Biodata Mahasiswa
- Input: Nama Lengkap
- Input: NIM
- Input: Program Studi
- Input: Angkatan
- Tombol: "Selanjutnya"

### Halaman 2: Tes Minat UKM (Kuesioner)
- 4 pertanyaan dengan skala Likert 1-5
- Pertanyaan 1: Tentang minat Sains & Teknologi
- Pertanyaan 2: Tentang minat Olahraga
- Pertanyaan 3: Tentang minat Seni
- Pertanyaan 4: Tentang minat Kegiatan Kelompok
- Tombol: "Kembali" dan "Submit"

### Halaman 3: Rekomendasi UKM
- Logo UKM yang direkomendasikan
- Nama UKM
- Deskripsi singkat
- Tombol: "Kembali ke Beranda"

## 🚀 Cara Menggunakan

### 1. Persiapan Database

Jalankan seeder untuk mengisi data soal:

```bash
php artisan db:seed --class=SoalSeeder
```

Atau jalankan semua seeder:

```bash
php artisan migrate:fresh --seed
```

### 2. Akses Halaman

Buka browser dan akses:
```
http://localhost/tesminat
```

Atau jika menggunakan Laragon:
```
http://simawa.test/tesminat
```

### 3. Alur Penggunaan

1. **Isi Biodata**
   - Masukkan Nama Lengkap
   - Masukkan NIM
   - Masukkan Program Studi
   - Masukkan Angkatan
   - Klik "Selanjutnya"

2. **Jawab Pertanyaan**
   - Pilih angka 1-5 untuk setiap pertanyaan
   - 1 = Sangat tidak setuju
   - 5 = Sangat setuju
   - Klik "Submit" setelah semua pertanyaan dijawab

3. **Lihat Rekomendasi**
   - Sistem akan menampilkan UKM yang direkomendasikan
   - Lihat logo, nama, dan deskripsi UKM
   - Klik "Kembali ke Beranda" untuk kembali

## 📁 File yang Dibuat/Dimodifikasi

### 1. Controller
**File**: `app/Http/Controllers/TesMinatController.php`
- Method `index()`: Menampilkan form tes minat
- Method `submit()`: Memproses jawaban dan memberikan rekomendasi

### 2. View
**File**: `resources/views/tesminat.blade.php`
- Form multi-step dengan JavaScript
- Styling menggunakan Tailwind CSS
- Responsive design

### 3. Routes
**File**: `routes/web.php`
- GET `/tesminat` → TesMinatController@index
- POST `/tesminat/submit` → TesMinatController@submit

### 4. Seeder
**File**: `database/seeders/SoalSeeder.php`
- Mengisi tabel `soal` dengan 4 pertanyaan sample

**File**: `database/seeders/DatabaseSeeder.php`
- Ditambahkan pemanggilan SoalSeeder

## 🎯 Fitur

✅ Multi-step form dengan navigasi smooth
✅ Validasi form di frontend dan backend
✅ Desain responsive (mobile & desktop)
✅ Animasi transisi antar halaman
✅ CSRF protection
✅ Rekomendasi UKM berdasarkan jawaban
✅ Tampilan sesuai mockup yang diberikan

## 🔧 Kustomisasi

### Menambah Pertanyaan

Edit file `database/seeders/SoalSeeder.php` dan tambahkan pertanyaan baru:

```php
[
    'pertanyaan' => 'Pertanyaan baru Anda',
    'skala_likert' => 5,
],
```

Kemudian update view `resources/views/tesminat.blade.php` untuk menampilkan pertanyaan tambahan.

### Mengubah Algoritma Rekomendasi

Edit method `submit()` di `app/Http/Controllers/TesMinatController.php` untuk mengimplementasikan logika rekomendasi yang lebih kompleks.

## 🐛 Troubleshooting

### Error: Route not found
**Solusi**: Jalankan `php artisan route:clear`

### Error: Class not found
**Solusi**: Jalankan `composer dump-autoload`

### Rekomendasi tidak muncul
**Solusi**: 
1. Pastikan tabel `ormawa` sudah terisi data
2. Jalankan `php artisan db:seed --class=OrmawaSeeder`

### Form tidak submit
**Solusi**: 
1. Buka Console browser (F12)
2. Periksa error JavaScript
3. Pastikan CSRF token valid

## 📞 Support

Jika ada pertanyaan atau masalah, silakan hubungi tim developer SIMAWA ITH.

---

**Dibuat dengan ❤️ untuk SIMAWA ITH**
