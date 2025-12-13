# TODO: Implementasi Kelola Pertanyaan Tes Minat

## Progress Tracking

- [x] 1. Buat view `tesminat-menu.blade.php` (halaman menu 2 card)
- [x] 2. Buat view `kelola-pertanyaan.blade.php` (halaman CRUD pertanyaan realtime)
- [x] 3. Update `TesMinatController.php` (tambah 6 methods baru)
- [x] 4. Update `routes/web.php` (tambah 6 routes baru)
- [x] 5. Update `dashboard.blade.php` (ubah link ke menu)
- [ ] 6. Testing fitur

## Fitur yang Akan Dibuat

### Halaman Menu (tesminat-menu.blade.php)
- Card 1: Kelola Pertanyaan Tes Minat
- Card 2: Hasil Tes Minat Mahasiswa

### Halaman Kelola Pertanyaan (kelola-pertanyaan.blade.php)
- Tombol Tambah Pertanyaan Baru
- Search bar realtime
- Tabel daftar pertanyaan dari database
- Tombol Edit & Hapus per pertanyaan
- Modal tambah/edit pertanyaan
- Modal konfirmasi hapus
- Auto refresh setelah CRUD

### Controller Methods (TesMinatController.php)
- showMenu() - Tampilkan halaman menu
- manageQuestions() - Tampilkan halaman kelola pertanyaan
- storeQuestion() - Simpan pertanyaan baru
- updateQuestion() - Update pertanyaan
- deleteQuestion() - Hapus pertanyaan

### Routes (web.php)
- GET /tesminatbem/menu
- GET /tesminatbem/pertanyaan
- POST /tesminatbem/pertanyaan
- PUT /tesminatbem/pertanyaan/{id}
- DELETE /tesminatbem/pertanyaan/{id}

## Catatan
- Tidak mengubah halaman hasil tes minat (tesminatbem.blade.php)
- Semua operasi realtime dengan database
- Tidak merusak kode yang sudah ada
