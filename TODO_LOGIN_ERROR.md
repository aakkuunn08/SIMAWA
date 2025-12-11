# TODO: Implementasi Pesan Error Login yang Spesifik

## Progress Tracking

### 1. Update lang/id/auth.php
- [x] Tambah pesan 'username' => 'Username tidak ditemukan.'

### 2. Update LoginRequest.php
- [x] Import model User
- [x] Import Hash facade
- [x] Modifikasi method authenticate() untuk cek username di database
- [x] Tampilkan error spesifik berdasarkan kondisi:
  - Username tidak ada → error di field 'username' dengan pesan 'Username tidak ditemukan.'
  - Password salah → error di field 'password' dengan pesan 'Password salah.'

### 3. Testing
- [ ] Test dengan username yang tidak ada
- [ ] Test dengan username benar tapi password salah
- [ ] Verifikasi pesan muncul di field yang tepat

## Perubahan yang Dilakukan:

### File: `lang/id/auth.php`
- Menambahkan pesan baru: `'username' => 'Username tidak ditemukan.'`

### File: `app/Http/Requests/Auth/LoginRequest.php`
- Import `App\Models\User` dan `Illuminate\Support\Facades\Hash`
- Modifikasi method `authenticate()`:
  1. Cek apakah username ada di database
  2. Jika tidak ada → throw error di field 'username'
  3. Jika ada, cek password dengan Hash::check()
  4. Jika password salah → throw error di field 'password'
  5. Jika keduanya benar → lanjutkan login normal
