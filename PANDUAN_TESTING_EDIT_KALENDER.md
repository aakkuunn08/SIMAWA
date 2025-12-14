# Panduan Testing Lengkap - Fitur Edit Kalender

## Persiapan Testing

### 1. Jalankan Server
```bash
php artisan serve
```
Server akan berjalan di: http://localhost:8000

### 2. Login sebagai Admin
- Username: admin (atau sesuai data Anda)
- Password: password admin Anda
- Pastikan user memiliki role `adminbem` atau `adminukm`

### 3. Buka Dashboard
- Setelah login, navigasi ke dashboard
- Scroll ke section kalender

---

## Test Case 1: Mode Tambah Kegiatan ✅

### Langkah Testing:

1. **Klik tombol "+ Tambah Kegiatan"**
   - Lokasi: Di bawah kalender, pojok kanan
   
2. **Verifikasi Modal Terbuka dengan Benar:**
   - ✅ Judul modal: "Input Kegiatan"
   - ✅ TIDAK ada indikator biru
   - ✅ Semua field kosong
   - ✅ Form memiliki field:
     - Jadwal (date)
     - Waktu Mulai (time)
     - Waktu Selesai (time)
     - Kegiatan (text)
     - Tempat (text)

3. **Isi Form dengan Data Test:**
   ```
   Jadwal: [Pilih tanggal hari ini atau besok]
   Waktu Mulai: 09:00
   Waktu Selesai: 11:00
   Kegiatan: Test Kegiatan Baru
   Tempat: Ruang Rapat A
   ```

4. **Klik Tombol "Simpan"**

5. **Verifikasi Hasil:**
   - ✅ Muncul alert sukses: "Kegiatan berhasil ditambahkan"
   - ✅ Modal tertutup otomatis
   - ✅ Halaman refresh
   - ✅ Kegiatan baru muncul di kalender pada tanggal yang dipilih
   - ✅ Nama kegiatan terlihat di kalender

### Expected Result:
✅ Kegiatan baru berhasil ditambahkan dan muncul di kalender

---

## Test Case 2: Mode Edit Kegiatan ✅

### Langkah Testing:

1. **Klik Kegiatan di Kalender**
   - Klik pada kegiatan yang baru saja dibuat
   - Atau klik kegiatan lain yang sudah ada

2. **Verifikasi Modal Detail Terbuka:**
   - ✅ Judul: "Detail Kegiatan"
   - ✅ Menampilkan informasi:
     - Jadwal (hari, tanggal, waktu)
     - Kegiatan (nama)
     - Tempat
   - ✅ Ada 3 tombol: Tutup, Edit, Hapus

3. **Klik Tombol "Edit"**

4. **Verifikasi Modal Edit Terbuka dengan Benar:**
   - ✅ Judul modal berubah menjadi: "Edit Kegiatan"
   - ✅ ADA indikator biru dengan icon pensil
   - ✅ Pesan indikator: "Mode Edit - Ubah data yang ingin Anda edit, field lainnya akan tetap sama"
   - ✅ Semua field TERISI dengan data existing:
     - Jadwal: [tanggal kegiatan]
     - Waktu Mulai: [waktu mulai existing]
     - Waktu Selesai: [waktu selesai existing]
     - Kegiatan: [nama kegiatan existing]
     - Tempat: [tempat existing]

5. **Ubah Beberapa Field (Contoh):**
   ```
   Tempat: Ruang Rapat B (ubah dari A ke B)
   Waktu Mulai: 10:00 (ubah dari 09:00)
   [Field lain biarkan sama]
   ```

6. **Klik Tombol "Simpan"**

7. **Verifikasi Hasil:**
   - ✅ Muncul alert sukses: "Kegiatan berhasil diupdate"
   - ✅ Modal tertutup otomatis
   - ✅ Halaman refresh
   - ✅ Kegiatan TIDAK duplikat (masih 1 kegiatan)
   - ✅ Perubahan terlihat di kalender
   - ✅ Klik lagi kegiatan tersebut untuk verifikasi detail sudah berubah

### Expected Result:
✅ Kegiatan berhasil diupdate, tidak ada duplikasi, perubahan tersimpan

---

## Test Case 3: Cancel Edit ✅

### Langkah Testing:

1. **Klik Kegiatan di Kalender**
2. **Klik Tombol "Edit"**
3. **Ubah Beberapa Field:**
   ```
   Tempat: Test Cancel
   Kegiatan: Test Cancel Edit
   ```
4. **Klik Tombol "Batal"**

5. **Verifikasi Hasil:**
   - ✅ Modal tertutup
   - ✅ Tidak ada perubahan tersimpan

6. **Buka Lagi Kegiatan yang Sama:**
   - ✅ Data masih sama seperti sebelumnya
   - ✅ Tidak ada perubahan

### Expected Result:
✅ Cancel berfungsi dengan baik, tidak ada perubahan tersimpan

---

## Test Case 4: Switch Between Modes ✅

### Langkah Testing:

1. **Test: Tambah → Edit → Tambah**
   
   a. **Klik "+ Tambah Kegiatan"**
      - ✅ Judul: "Input Kegiatan"
      - ✅ Tidak ada indikator biru
      - ✅ Field kosong
   
   b. **Klik "Batal"**
   
   c. **Klik Kegiatan → Edit**
      - ✅ Judul: "Edit Kegiatan"
      - ✅ Ada indikator biru
      - ✅ Field terisi
   
   d. **Klik "Batal"**
   
   e. **Klik "+ Tambah Kegiatan" Lagi**
      - ✅ Judul: "Input Kegiatan"
      - ✅ Tidak ada indikator biru
      - ✅ Field kosong (reset dengan benar)

2. **Test: Edit → Edit Kegiatan Lain**
   
   a. **Klik Kegiatan A → Edit**
      - ✅ Data kegiatan A terisi
   
   b. **Klik "Batal"**
   
   c. **Klik Kegiatan B → Edit**
      - ✅ Data kegiatan B terisi (bukan data A)
      - ✅ Tidak ada data tercampur

### Expected Result:
✅ State management berfungsi dengan baik, tidak ada data tercampur

---

## Test Case 5: Validasi Form ✅

### Langkah Testing:

1. **Test Field Required (Mode Tambah):**
   
   a. **Klik "+ Tambah Kegiatan"**
   
   b. **Kosongkan Semua Field**
   
   c. **Klik "Simpan"**
   
   d. **Verifikasi:**
      - ✅ Browser menampilkan validasi HTML5
      - ✅ Pesan: "Please fill out this field"
      - ✅ Form tidak tersubmit

2. **Test Field Required (Mode Edit):**
   
   a. **Klik Kegiatan → Edit**
   
   b. **Kosongkan Field "Kegiatan"**
   
   c. **Klik "Simpan"**
   
   d. **Verifikasi:**
      - ✅ Browser menampilkan validasi
      - ✅ Form tidak tersubmit

3. **Test Format Tanggal:**
   
   a. **Coba input tanggal invalid (jika memungkinkan)**
   
   b. **Verifikasi:**
      - ✅ Date picker mencegah input invalid

### Expected Result:
✅ Validasi form berfungsi dengan baik

---

## Test Case 6: Calendar Refresh & No Duplication ✅

### Langkah Testing:

1. **Hitung Jumlah Kegiatan Awal:**
   - Catat berapa kegiatan pada tanggal tertentu
   - Contoh: Tanggal 15 Januari ada 2 kegiatan

2. **Edit Salah Satu Kegiatan:**
   - Klik kegiatan pertama
   - Edit (ubah tempat atau waktu)
   - Simpan

3. **Verifikasi Setelah Refresh:**
   - ✅ Jumlah kegiatan TETAP SAMA (masih 2, tidak jadi 3)
   - ✅ Perubahan terlihat
   - ✅ Tidak ada duplikasi

4. **Test Edit Tanggal:**
   - Klik kegiatan pada tanggal 15
   - Edit tanggal menjadi tanggal 16
   - Simpan

5. **Verifikasi:**
   - ✅ Kegiatan pindah dari tanggal 15 ke 16
   - ✅ Tanggal 15 berkurang 1 kegiatan
   - ✅ Tanggal 16 bertambah 1 kegiatan
   - ✅ Tidak ada duplikasi

### Expected Result:
✅ Update berfungsi dengan benar, tidak ada duplikasi

---

## Test Case 7: Delete Kegiatan ✅

### Langkah Testing:

1. **Klik Kegiatan di Kalender**

2. **Klik Tombol "Hapus"**

3. **Verifikasi Konfirmasi:**
   - ✅ Muncul modal konfirmasi
   - ✅ Pesan: "Apakah Anda yakin ingin menghapus kegiatan ini?"
   - ✅ Ada tombol "Batal" dan "OK"

4. **Klik "OK"**

5. **Verifikasi Hasil:**
   - ✅ Muncul alert: "Kegiatan berhasil dihapus"
   - ✅ Modal tertutup
   - ✅ Halaman refresh
   - ✅ Kegiatan hilang dari kalender

6. **Test Cancel Delete:**
   - Klik kegiatan lain
   - Klik "Hapus"
   - Klik "Batal"
   - ✅ Kegiatan tidak terhapus

### Expected Result:
✅ Delete berfungsi dengan konfirmasi yang baik

---

## Test Case 8: Multiple Edits ✅

### Langkah Testing:

1. **Edit Kegiatan Pertama:**
   - Ubah tempat
   - Simpan
   - ✅ Berhasil

2. **Langsung Edit Kegiatan Kedua:**
   - Ubah waktu
   - Simpan
   - ✅ Berhasil

3. **Edit Kegiatan Pertama Lagi:**
   - Ubah nama kegiatan
   - Simpan
   - ✅ Berhasil

4. **Verifikasi:**
   - ✅ Semua perubahan tersimpan dengan benar
   - ✅ Tidak ada data tercampur
   - ✅ Tidak ada error

### Expected Result:
✅ Multiple edits berfungsi tanpa masalah

---

## Test Case 9: Browser Compatibility (Opsional)

### Test di Browser Berbeda:

1. **Google Chrome:**
   - [ ] Semua fungsi bekerja
   - [ ] UI tampil dengan baik
   - [ ] Indikator biru terlihat

2. **Mozilla Firefox:**
   - [ ] Semua fungsi bekerja
   - [ ] UI tampil dengan baik
   - [ ] Indikator biru terlihat

3. **Microsoft Edge:**
   - [ ] Semua fungsi bekerja
   - [ ] UI tampil dengan baik
   - [ ] Indikator biru terlihat

---

## Test Case 10: Responsive Design (Opsional)

### Test di Mobile View:

1. **Buka Developer Tools (F12)**
2. **Toggle Device Toolbar (Ctrl+Shift+M)**
3. **Pilih Device: iPhone 12 Pro atau Samsung Galaxy S20**

4. **Verifikasi:**
   - [ ] Kalender tampil dengan baik
   - [ ] Modal dapat dibuka
   - [ ] Form dapat diisi
   - [ ] Tombol dapat diklik
   - [ ] Indikator biru terlihat

---

## Checklist Hasil Testing

### Fitur Utama:
- [ ] ✅ Mode Tambah berfungsi dengan baik
- [ ] ✅ Mode Edit berfungsi dengan baik
- [ ] ✅ Judul modal berubah sesuai mode
- [ ] ✅ Indikator biru muncul saat edit
- [ ] ✅ Form terisi dengan data existing saat edit
- [ ] ✅ Update tidak membuat duplikasi
- [ ] ✅ Cancel berfungsi dengan baik
- [ ] ✅ Delete berfungsi dengan konfirmasi

### State Management:
- [ ] ✅ Switch mode berfungsi dengan baik
- [ ] ✅ State reset dengan benar
- [ ] ✅ Tidak ada data tercampur

### Validasi:
- [ ] ✅ Required fields tervalidasi
- [ ] ✅ Format data tervalidasi

### UX:
- [ ] ✅ Pesan sukses sesuai dengan aksi
- [ ] ✅ Visual feedback jelas
- [ ] ✅ Modal behavior konsisten

---

## Troubleshooting

### Jika Menemukan Bug:

1. **Catat Detail Bug:**
   - Langkah untuk reproduce
   - Expected behavior
   - Actual behavior
   - Screenshot jika perlu

2. **Cek Console Browser:**
   - Buka Developer Tools (F12)
   - Tab Console
   - Catat error messages

3. **Cek Network Tab:**
   - Verifikasi request ke `/kegiatan/{id}`
   - Cek method (PUT untuk update)
   - Cek response

---

## Kesimpulan Testing

Setelah menyelesaikan semua test case di atas, Anda dapat menyimpulkan:

✅ **PASS** - Jika semua test case berhasil
❌ **FAIL** - Jika ada test case yang gagal (catat detailnya)

---

## Kontak

Jika menemukan bug atau memerlukan bantuan:
- Dokumentasi lengkap: `PERBAIKAN_EDIT_KALENDER.md`
- TODO list: `TODO_PERBAIKAN_EDIT_KALENDER.md`

Selamat Testing! 🚀
