# Panduan Fitur Manajemen Akun untuk AdminBEM

## 📋 Ringkasan

Fitur ini memungkinkan **AdminBEM** (Super Admin) untuk mengelola akun-akun organisasi mahasiswa (Unit Kegiatan Mahasiswa) melalui halaman khusus yang hanya dapat diakses oleh role adminbem.

## 🎯 Fitur Utama

### 1. **Halaman Daftar Akun** (`/adminbem/accounts`)
- Menampilkan semua akun organisasi dalam bentuk card
- Setiap card menampilkan:
  - Logo organisasi
  - Nama organisasi
  - Username
  - Informasi organisasi terkait
  - Tombol Edit dan Hapus
- Tombol "Tambah Akun" di pojok kanan atas

### 2. **Tambah Akun Baru** (`/adminbem/accounts/create`)
- Form untuk membuat akun baru dengan field:
  - **Nama Organisasi**: Nama lengkap organisasi
  - **Username**: Username untuk login (unik)
  - **Password**: Password minimal 8 karakter
  - **Konfirmasi Password**: Harus sama dengan password
  - **Upload Logo**: Gambar logo organisasi (opsional, max 2MB)
- Akun otomatis diberi role `adminukm`

### 3. **Edit Akun** (`/adminbem/accounts/{id}/edit`)
- Form untuk mengedit akun yang sudah ada
- Field yang sama dengan tambah akun
- **Password bersifat opsional**: 
  - Kosongkan jika tidak ingin mengubah password
  - Isi jika ingin reset/ubah password
- Dapat mengubah logo organisasi

### 4. **Hapus Akun** 
- Konfirmasi sebelum menghapus
- Menghapus akun dan logo terkait dari storage

## 🔐 Keamanan

### Akses Terbatas
- **Hanya AdminBEM** yang dapat mengakses halaman ini
- Dilindungi oleh middleware `adminbem`
- User dengan role lain akan mendapat error 403

### Validasi
- Username harus unik
- Password minimal 8 karakter
- File upload hanya menerima gambar (JPG, PNG)
- Maksimal ukuran file 2MB
- CSRF protection pada semua form

### Password Management
- Password di-hash menggunakan bcrypt
- AdminBEM dapat reset password tanpa perlu password lama
- Solusi untuk "lupa password" karena tidak ada email

## 📁 Struktur File

### Controller
```
app/Http/Controllers/Admin/AccountController.php
```
- `index()`: Tampilkan daftar akun
- `create()`: Form tambah akun
- `store()`: Simpan akun baru
- `edit($id)`: Form edit akun
- `update($id)`: Update akun
- `destroy($id)`: Hapus akun

### Views
```
resources/views/admin/accounts/
├── index.blade.php    # Halaman daftar akun (seperti gambar 1)
└── form.blade.php     # Form tambah/edit akun (seperti gambar 2)
```

### Routes
```php
// routes/web.php
Route::middleware(['auth', 'adminbem'])->group(function () {
    Route::get('/adminbem/accounts', ...)->name('adminbem.accounts.index');
    Route::get('/adminbem/accounts/create', ...)->name('adminbem.accounts.create');
    Route::post('/adminbem/accounts', ...)->name('adminbem.accounts.store');
    Route::get('/adminbem/accounts/{id}/edit', ...)->name('adminbem.accounts.edit');
    Route::put('/adminbem/accounts/{id}', ...)->name('adminbem.accounts.update');
    Route::delete('/adminbem/accounts/{id}', ...)->name('adminbem.accounts.destroy');
});
```

## 🚀 Cara Menggunakan

### Untuk AdminBEM:

1. **Login** dengan akun adminbem
2. Klik menu **"Akun"** di sidebar
3. Anda akan diarahkan ke halaman manajemen akun

### Membuat Akun Baru:

1. Klik tombol **"Tambah Akun"**
2. Isi form:
   - Nama Organisasi (contoh: "Hobibie Engineering Robotic of Organization")
   - Username (contoh: "hero_ith")
   - Password (minimal 8 karakter)
   - Konfirmasi Password
   - Upload Logo (opsional)
3. Klik **"Buat Akun"**
4. Akun baru akan muncul di daftar

### Mengedit Akun:

1. Klik tombol **"Edit"** pada card akun yang ingin diedit
2. Ubah informasi yang diperlukan
3. Untuk mengubah password:
   - Isi field "Password Baru" dan "Konfirmasi Password"
   - Kosongkan jika tidak ingin mengubah password
4. Klik **"Simpan Perubahan"**

### Menghapus Akun:

1. Klik tombol **"Hapus"** pada card akun
2. Konfirmasi penghapusan di modal yang muncul
3. Klik **"Hapus"** untuk konfirmasi
4. Akun akan dihapus permanen

## 💡 Catatan Penting

### Tentang Password
- **Tidak ada fitur "Lupa Password" via email** karena sistem tidak menggunakan email
- **Solusi**: AdminBEM dapat langsung reset password dari halaman edit akun
- Jika user lupa password, hubungi AdminBEM untuk reset

### Tentang Logo
- Logo disimpan di `storage/app/public/logos/`
- Dapat diakses via `storage/logos/filename.jpg`
- Symbolic link sudah dibuat dengan `php artisan storage:link`

### Tentang Role
- Akun yang dibuat otomatis mendapat role `adminukm`
- Role ini memiliki akses untuk mengelola konten organisasi mereka
- Tidak dapat mengelola akun user lain (hanya AdminBEM yang bisa)

## 🔧 Troubleshooting

### Logo tidak muncul?
```bash
php artisan storage:link
```

### Error 403 saat akses halaman?
- Pastikan login dengan akun yang memiliki role `adminbem`
- Cek di database: `SELECT * FROM users WHERE role = 'adminbem'`

### Error saat upload logo?
- Pastikan ukuran file tidak lebih dari 2MB
- Format file harus JPG atau PNG
- Pastikan folder `storage/app/public/logos` ada dan writable

## 📊 Database

### Tabel: users
```sql
- id (primary key)
- name (nama organisasi)
- username (unique, untuk login)
- password (hashed)
- role (adminbem / adminukm)
- profile_photo_path (path ke logo)
- created_at
- updated_at
```

### Relasi
- User hasMany DataOrganisasi
- User hasMany DaftarKegiatan
- User hasMany Berita

## 🎨 Desain UI

### Halaman Index
- Layout grid responsif (1 kolom mobile, 2-3 kolom desktop)
- Card dengan shadow dan hover effect
- Logo bulat di tengah card
- Tombol aksi di bawah card
- Alert success/error di atas

### Halaman Form
- Layout centered dengan max-width
- Preview logo di atas form
- Field dengan label jelas
- Validasi error ditampilkan di bawah field
- Tombol Batal dan Simpan di bawah

## 📝 Testing Checklist

- [ ] Login sebagai adminbem
- [ ] Akses halaman `/adminbem/accounts`
- [ ] Klik "Tambah Akun"
- [ ] Isi form dan submit
- [ ] Verifikasi akun muncul di daftar
- [ ] Klik "Edit" pada akun
- [ ] Ubah informasi dan submit
- [ ] Verifikasi perubahan tersimpan
- [ ] Upload logo baru
- [ ] Verifikasi logo muncul
- [ ] Klik "Hapus" pada akun
- [ ] Konfirmasi dan verifikasi akun terhapus
- [ ] Coba akses dengan user non-adminbem (harus error 403)

## 🔄 Update Sidebar

Sidebar sekarang menampilkan link "Akun" yang berbeda berdasarkan role:
- **AdminBEM**: Link ke `/adminbem/accounts` (Manajemen Akun)
- **User lain**: Link ke `/profile` (Profile Settings)

## ✅ Kesimpulan

Fitur manajemen akun untuk AdminBEM telah berhasil diimplementasikan dengan lengkap. AdminBEM sekarang dapat:
- ✅ Melihat semua akun organisasi
- ✅ Membuat akun baru (tanpa email, hanya username & password)
- ✅ Mengedit informasi akun
- ✅ Reset password akun
- ✅ Upload/ubah logo organisasi
- ✅ Menghapus akun

Semua fitur dilindungi dengan middleware dan hanya dapat diakses oleh role adminbem.
