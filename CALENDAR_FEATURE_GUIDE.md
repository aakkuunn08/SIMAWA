# Panduan Fitur Manajemen Kegiatan Kalender

## Fitur yang Telah Diimplementasikan

### 1. **Database**
- Tabel `daftar_kegiatan` telah ditambahkan 3 kolom baru:
  - `tempat` (VARCHAR 200) - Lokasi kegiatan
  - `waktu_mulai` (TIME) - Waktu mulai kegiatan
  - `waktu_selesai` (TIME) - Waktu selesai kegiatan

### 2. **Backend (Controller & Routes)**
- **DaftarKegiatanController** dengan method:
  - `store()` - Menambah kegiatan baru
  - `show($id)` - Melihat detail kegiatan
  - `update($id)` - Mengupdate kegiatan
  - `destroy($id)` - Menghapus kegiatan
  - `getEvents()` - Mendapatkan semua events untuk kalender

- **Routes** (hanya untuk adminbem):
  - POST `/kegiatan` - Tambah kegiatan
  - GET `/kegiatan/{id}` - Detail kegiatan
  - PUT `/kegiatan/{id}` - Update kegiatan
  - DELETE `/kegiatan/{id}` - Hapus kegiatan

### 3. **Frontend (Dashboard)**
- **Button "Tambah Kegiatan"** - Muncul di bawah kalender (hanya untuk admin BEM)
- **Modal Input Kegiatan** dengan field:
  - Jadwal (date picker)
  - Waktu Mulai (time picker)
  - Waktu Selesai (time picker)
  - Kegiatan (text input)
  - Tempat (text input)
- **Modal Detail Kegiatan** - Menampilkan informasi lengkap kegiatan
- **Kalender Interaktif** - Kegiatan muncul di bawah tanggal dan bisa diklik

## Cara Testing

### A. Persiapan
1. Pastikan server berjalan: `php artisan serve`
2. Buka browser: `http://127.0.0.1:8000`
3. Login sebagai admin BEM

### B. Test Tambah Kegiatan
1. Login sebagai admin BEM
2. Buka halaman Dashboard
3. Scroll ke bagian kalender
4. Klik button **"+ Tambah Kegiatan"** di bawah kalender (kanan)
5. Modal akan muncul dengan form input
6. Isi form:
   - **Jadwal**: Pilih tanggal (contoh: 2025-12-15)
   - **Waktu Mulai**: Pilih waktu (contoh: 07:30)
   - **Waktu Selesai**: Pilih waktu (contoh: 09:10)
   - **Kegiatan**: Isi nama kegiatan (contoh: "Seminar Robotika")
   - **Tempat**: Isi lokasi (contoh: "Aula Kampus 2 ITH")
7. Klik **"Simpan"**
8. Halaman akan reload dan kegiatan muncul di kalender pada tanggal yang dipilih

### C. Test Lihat Detail Kegiatan
1. Di kalender, cari tanggal yang ada kegiatannya (teks merah di bawah tanggal)
2. Klik pada nama kegiatan
3. Modal detail akan muncul menampilkan:
   - Judul kegiatan di header (background merah)
   - Jadwal lengkap (Hari, Tanggal, Waktu)
   - Nama kegiatan
   - Lokasi/tempat
4. Untuk admin BEM, ada 3 tombol: **Tutup**, **Edit**, **Hapus**
5. Untuk mahasiswa biasa, hanya ada tombol **Tutup**

### D. Test Edit Kegiatan
1. Buka detail kegiatan (klik pada kegiatan di kalender)
2. Klik button **"Edit"**
3. Modal input akan muncul dengan data kegiatan yang sudah terisi
4. Ubah data yang diinginkan
5. Klik **"Simpan"**
6. Halaman akan reload dengan data yang sudah diupdate

### E. Test Hapus Kegiatan
1. Buka detail kegiatan (klik pada kegiatan di kalender)
2. Klik button **"Hapus"**
3. Konfirmasi penghapusan akan muncul
4. Klik **"OK"** untuk menghapus
5. Halaman akan reload dan kegiatan hilang dari kalender

### F. Test Tampilan untuk Mahasiswa
1. Logout dari admin BEM
2. Login sebagai mahasiswa biasa
3. Buka Dashboard
4. Kegiatan tetap terlihat di kalender
5. Button "Tambah Kegiatan" TIDAK muncul (hanya admin BEM yang bisa menambah)
6. Klik kegiatan untuk melihat detail
7. Di modal detail, button Edit dan Hapus TIDAK muncul (hanya admin BEM yang bisa edit/hapus)

## Format Tampilan

### Modal Input Kegiatan
```
┌─────────────────────────────────────┐
│ Input Kegiatan                    × │ (Header merah)
├─────────────────────────────────────┤
│ 🕐 Jadwal                           │
│    [Date Picker]                    │
│                                     │
│ 🕐 Waktu Mulai    Waktu Selesai    │
│    [07:30]         [09:10]         │
│                                     │
│ 📋 Kegiatan                         │
│    [Seminar Robotika]              │
│                                     │
│ 📍 Tempat                           │
│    [Aula Kampus 2 ITH]             │
│                                     │
│              [Batal]  [Simpan]     │
└─────────────────────────────────────┘
```

### Modal Detail Kegiatan
```
┌─────────────────────────────────────┐
│ Seminar Robotika                  × │ (Header merah)
├─────────────────────────────────────┤
│ 🕐 Kamis, 15 Desember 2025,        │
│    7.30 >> 09.10                   │
│                                     │
│ 📋 Seminar Robotika                │
│                                     │
│ 📍 Aula Kampus 2 ITH               │
│                                     │
│    [Tutup]  [Edit]  [Hapus]        │ (Admin BEM)
│    [Tutup]                          │ (Mahasiswa)
└─────────────────────────────────────┘
```

### Kalender dengan Kegiatan
```
Desember 2025

Min  Sen  Sel  Rab  Kam  Jum  Sab
 1    2    3    4    5    6    7
 8    9   10   11   12   13   14
15   16   17   18   19   20   21
Seminar
Robotika
22   23   24   25   26   27   28
29   30   31
```

## Teknologi yang Digunakan

1. **Backend**: Laravel 10
2. **Frontend**: Blade Templates + Tailwind CSS
3. **JavaScript**: Vanilla JS (Fetch API untuk AJAX)
4. **Database**: MySQL (via Laravel Migration)
5. **Authentication**: Laravel Breeze + Spatie Roles

## Keamanan

- ✅ CSRF Protection (token di semua form)
- ✅ Role-based Access Control (hanya adminbem yang bisa CRUD)
- ✅ Middleware protection di routes
- ✅ Input validation di controller
- ✅ SQL Injection protection (Laravel Eloquent ORM)

## Troubleshooting

### Problem: Button "Tambah Kegiatan" tidak muncul
**Solusi**: Pastikan user login sebagai adminbem. Cek role di database.

### Problem: Modal tidak muncul saat klik button
**Solusi**: 
1. Buka browser console (F12)
2. Cek error JavaScript
3. Pastikan CSRF token ada di meta tag

### Problem: Error saat submit form
**Solusi**:
1. Cek network tab di browser console
2. Lihat response error dari server
3. Pastikan semua field required terisi
4. Cek validasi di controller

### Problem: Kegiatan tidak muncul di kalender
**Solusi**:
1. Cek database apakah data tersimpan
2. Refresh halaman (Ctrl+F5)
3. Cek console untuk error JavaScript
4. Pastikan format tanggal sesuai (YYYY-MM-DD)

## File yang Dimodifikasi/Dibuat

1. ✅ `database/migrations/2025_12_03_081457_add_tempat_and_waktu_to_daftar_kegiatan_table.php`
2. ✅ `app/Models/DaftarKegiatan.php`
3. ✅ `app/Http/Controllers/DaftarKegiatanController.php`
4. ✅ `routes/web.php`
5. ✅ `resources/views/dashboard.blade.php`
6. ✅ `resources/views/layouts/main.blade.php`

## Catatan Penting

- Kegiatan yang ditambahkan akan **terlihat oleh semua user** (admin dan mahasiswa)
- Hanya **admin BEM** yang bisa menambah, edit, dan hapus kegiatan
- Mahasiswa hanya bisa **melihat** kegiatan di kalender
- Format waktu menggunakan format 24 jam (HH:MM)
- Tampilan waktu di detail menggunakan format Indonesia (7.30 >> 09.10)

## Next Steps (Opsional)

Fitur tambahan yang bisa dikembangkan:
1. Filter kegiatan berdasarkan bulan/tahun
2. Search kegiatan
3. Export kegiatan ke PDF/Excel
4. Notifikasi untuk kegiatan yang akan datang
5. Upload gambar/poster kegiatan
6. Kategori kegiatan (Seminar, Workshop, dll)
7. Status kegiatan (Scheduled, Ongoing, Completed, Cancelled)
