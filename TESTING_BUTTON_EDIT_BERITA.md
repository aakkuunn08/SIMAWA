# Testing Plan: Button "Edit Berita" dan "Tambah Kegiatan"

## Masalah yang Diperbaiki
Button "Edit Berita" tidak muncul untuk user adminukm karena menggunakan `hasRole('adminbem','adminukm')` yang menggunakan AND logic (harus punya SEMUA role), bukan OR logic (punya SALAH SATU role).

## Solusi
Mengganti dengan `hasAnyRole(['adminbem','adminukm'])` yang menggunakan OR logic.

## File yang Diubah
- `resources/views/dashboard.blade.php` (3 perubahan)

---

## THOROUGH TESTING CHECKLIST

### A. Testing untuk User ADMINBEM

#### 1. Login sebagai adminbem
- [ ] Username: `adminbem`
- [ ] Password: `adminbem123`
- [ ] Login berhasil

#### 2. Test Dashboard - Section Kalender
- [ ] Scroll ke section "Kalender"
- [ ] Button "Tambah Kegiatan" **HARUS MUNCUL** di bawah kalender
- [ ] Klik button "Tambah Kegiatan"
- [ ] Modal "Input Kegiatan" **HARUS TERBUKA**
- [ ] Form memiliki field: Jadwal, Waktu Mulai, Waktu Selesai, Kegiatan, Tempat
- [ ] Klik "Batal" - modal tertutup

#### 3. Test Dashboard - Section News
- [ ] Scroll ke section "News"
- [ ] Button "Edit Berita" **HARUS MUNCUL** di bawah berita
- [ ] Button berwarna orange (modern-btn-primary)

#### 4. Test CRUD Kegiatan (Create)
- [ ] Klik "Tambah Kegiatan"
- [ ] Isi form:
  - Jadwal: pilih tanggal hari ini atau besok
  - Waktu Mulai: 09:00
  - Waktu Selesai: 11:00
  - Kegiatan: "Test Kegiatan AdminBEM"
  - Tempat: "Ruang Rapat"
- [ ] Klik "Simpan"
- [ ] Alert "Berhasil" muncul
- [ ] Halaman reload otomatis
- [ ] Kegiatan muncul di kalender pada tanggal yang dipilih

#### 5. Test CRUD Kegiatan (Read/Detail)
- [ ] Klik kegiatan "Test Kegiatan AdminBEM" di kalender
- [ ] Modal "Detail Kegiatan" terbuka
- [ ] Menampilkan: Jadwal, Kegiatan, Tempat dengan benar
- [ ] Button "Tutup", "Edit", "Hapus" **HARUS MUNCUL**

#### 6. Test CRUD Kegiatan (Update)
- [ ] Dari modal detail, klik "Edit"
- [ ] Modal detail tertutup, modal input terbuka
- [ ] Form terisi dengan data kegiatan
- [ ] Ubah nama kegiatan menjadi "Test Kegiatan AdminBEM - Updated"
- [ ] Klik "Simpan"
- [ ] Alert "Berhasil" muncul
- [ ] Halaman reload
- [ ] Kegiatan di kalender terupdate

#### 7. Test CRUD Kegiatan (Delete)
- [ ] Klik kegiatan yang sudah diupdate
- [ ] Klik "Hapus"
- [ ] Alert konfirmasi muncul: "Apakah Anda yakin ingin menghapus kegiatan ini?"
- [ ] Klik "OK"
- [ ] Alert "Berhasil" muncul
- [ ] Halaman reload
- [ ] Kegiatan hilang dari kalender

#### 8. Logout
- [ ] Klik menu logout
- [ ] Berhasil logout

---

### B. Testing untuk User ADMINUKM (HERO)

#### 1. Login sebagai adminukm
- [ ] Username: `adminhero`
- [ ] Password: (password yang sudah dibuat)
- [ ] Login berhasil

#### 2. Test Dashboard - Section Kalender
- [ ] Scroll ke section "Kalender"
- [ ] Button "Tambah Kegiatan" **HARUS MUNCUL** ✅ (INI YANG DIPERBAIKI)
- [ ] Klik button "Tambah Kegiatan"
- [ ] Modal "Input Kegiatan" **HARUS TERBUKA** ✅
- [ ] Form memiliki field: Jadwal, Waktu Mulai, Waktu Selesai, Kegiatan, Tempat
- [ ] Klik "Batal" - modal tertutup

#### 3. Test Dashboard - Section News
- [ ] Scroll ke section "News"
- [ ] Button "Edit Berita" **HARUS MUNCUL** ✅ (INI MASALAH UTAMA YANG DIPERBAIKI)
- [ ] Button berwarna orange (modern-btn-primary)

#### 4. Test CRUD Kegiatan (Create)
- [ ] Klik "Tambah Kegiatan"
- [ ] Isi form:
  - Jadwal: pilih tanggal hari ini atau besok
  - Waktu Mulai: 13:00
  - Waktu Selesai: 15:00
  - Kegiatan: "Test Kegiatan HERO"
  - Tempat: "Lab Robotik"
- [ ] Klik "Simpan"
- [ ] Alert "Berhasil" muncul
- [ ] Halaman reload otomatis
- [ ] Kegiatan muncul di kalender pada tanggal yang dipilih

#### 5. Test CRUD Kegiatan (Read/Detail)
- [ ] Klik kegiatan "Test Kegiatan HERO" di kalender
- [ ] Modal "Detail Kegiatan" terbuka
- [ ] Menampilkan: Jadwal, Kegiatan, Tempat dengan benar
- [ ] Button "Tutup", "Edit", "Hapus" **HARUS MUNCUL**

#### 6. Test CRUD Kegiatan (Update)
- [ ] Dari modal detail, klik "Edit"
- [ ] Modal detail tertutup, modal input terbuka
- [ ] Form terisi dengan data kegiatan
- [ ] Ubah nama kegiatan menjadi "Test Kegiatan HERO - Updated"
- [ ] Klik "Simpan"
- [ ] Alert "Berhasil" muncul
- [ ] Halaman reload
- [ ] Kegiatan di kalender terupdate

#### 7. Test CRUD Kegiatan (Delete)
- [ ] Klik kegiatan yang sudah diupdate
- [ ] Klik "Hapus"
- [ ] Alert konfirmasi muncul
- [ ] Klik "OK"
- [ ] Alert "Berhasil" muncul
- [ ] Halaman reload
- [ ] Kegiatan hilang dari kalender

#### 8. Logout
- [ ] Klik menu logout
- [ ] Berhasil logout

---

### C. Testing untuk User ADMINUKM Lainnya (Sampling)

#### Test dengan adminhcc
- [ ] Login sebagai `adminhcc`
- [ ] Button "Tambah Kegiatan" **HARUS MUNCUL**
- [ ] Button "Edit Berita" **HARUS MUNCUL**
- [ ] Logout

#### Test dengan adminseni
- [ ] Login sebagai `adminseni`
- [ ] Button "Tambah Kegiatan" **HARUS MUNCUL**
- [ ] Button "Edit Berita" **HARUS MUNCUL**
- [ ] Logout

---

### D. Testing Negative Case (User Tanpa Role Admin)

#### 1. Test sebagai Guest (Tidak Login)
- [ ] Buka halaman home (tanpa login)
- [ ] Scroll ke section Kalender
- [ ] Button "Tambah Kegiatan" **TIDAK BOLEH MUNCUL**
- [ ] Scroll ke section News
- [ ] Button "Edit Berita" **TIDAK BOLEH MUNCUL**

---

### E. Testing Cross-Browser (Optional)

#### Chrome
- [ ] Test dengan adminbem - button muncul
- [ ] Test dengan adminukm - button muncul

#### Firefox
- [ ] Test dengan adminbem - button muncul
- [ ] Test dengan adminukm - button muncul

#### Edge
- [ ] Test dengan adminbem - button muncul
- [ ] Test dengan adminukm - button muncul

---

### F. Testing Cache Issue

#### Clear Cache Test
- [ ] Login sebagai adminukm
- [ ] Jika button tidak muncul, lakukan:
  - Hard refresh: `Ctrl + Shift + R`
  - Clear browser cache
  - Restart Laragon
- [ ] Button harus muncul setelah clear cache

---

## EXPECTED RESULTS

### ✅ PASS Criteria:
1. Button "Tambah Kegiatan" muncul untuk adminbem dan adminukm
2. Button "Edit Berita" muncul untuk adminbem dan adminukm
3. Modal dapat dibuka dan ditutup dengan benar
4. CRUD kegiatan berfungsi untuk adminbem dan adminukm
5. Button TIDAK muncul untuk guest/user tanpa role admin

### ❌ FAIL Criteria:
1. Button tidak muncul untuk adminukm
2. Button muncul untuk guest
3. Modal tidak bisa dibuka
4. CRUD kegiatan error

---

## HASIL TESTING

Silakan isi hasil testing di bawah ini:

### User: adminbem
- [ ] PASS / [ ] FAIL
- Catatan: _______________

### User: adminhero (adminukm)
- [ ] PASS / [ ] FAIL
- Catatan: _______________

### User: adminhcc (adminukm)
- [ ] PASS / [ ] FAIL
- Catatan: _______________

### User: Guest (tidak login)
- [ ] PASS / [ ] FAIL
- Catatan: _______________

---

## BUGS FOUND (Jika Ada)

1. Bug: _______________
   - Severity: High / Medium / Low
   - Steps to reproduce: _______________
   - Expected: _______________
   - Actual: _______________

---

## CONCLUSION

- [ ] Semua test PASS - Task selesai
- [ ] Ada test FAIL - Perlu perbaikan

Tanggal Testing: _______________
Tester: _______________
