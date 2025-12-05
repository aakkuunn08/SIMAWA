# Testing Guide - Account Management Feature

## 🧪 Quick Testing Steps

### Prerequisites
1. Ensure you have an adminbem account in the database
2. Server is running: `php artisan serve`
3. Storage link is created: `php artisan storage:link`

### Test 1: Access Account Management Page
```
1. Login dengan akun adminbem
2. Klik menu "Akun" di sidebar
3. Expected: Halaman "/adminbem/accounts" terbuka
4. Expected: Menampilkan daftar akun atau pesan "Belum Ada Akun"
```

### Test 2: Create New Account
```
1. Dari halaman accounts, klik "Tambah Akun"
2. Isi form:
   - Nama Organisasi: "Test Organization"
   - Username: "testorg"
   - Password: "password123"
   - Konfirmasi Password: "password123"
   - Upload Logo: (pilih gambar)
3. Klik "Buat Akun"
4. Expected: Redirect ke halaman index dengan pesan sukses
5. Expected: Card akun baru muncul di daftar
```

### Test 3: Edit Account
```
1. Klik tombol "Edit" pada salah satu card akun
2. Ubah nama organisasi
3. Kosongkan field password (tidak mengubah password)
4. Klik "Simpan Perubahan"
5. Expected: Redirect ke halaman index dengan pesan sukses
6. Expected: Perubahan tersimpan
```

### Test 4: Change Password
```
1. Klik tombol "Edit" pada akun
2. Isi field "Password Baru": "newpassword123"
3. Isi field "Konfirmasi Password": "newpassword123"
4. Klik "Simpan Perubahan"
5. Expected: Password berhasil diubah
6. Test: Logout dan login dengan password baru
```

### Test 5: Upload/Change Logo
```
1. Klik tombol "Edit" pada akun
2. Klik "Pilih File" di bagian logo
3. Pilih gambar (JPG/PNG, max 2MB)
4. Expected: Preview logo muncul
5. Klik "Simpan Perubahan"
6. Expected: Logo baru muncul di card akun
```

### Test 6: Delete Account
```
1. Klik tombol "Hapus" pada akun
2. Expected: Modal konfirmasi muncul
3. Klik "Hapus" untuk konfirmasi
4. Expected: Akun terhapus dari daftar
5. Expected: Logo terhapus dari storage
```

### Test 7: Access Control
```
1. Logout dari adminbem
2. Login dengan akun adminukm atau user biasa
3. Coba akses "/adminbem/accounts"
4. Expected: Error 403 - Access Denied
5. Klik menu "Akun" di sidebar
6. Expected: Diarahkan ke halaman profile, bukan account management
```

### Test 8: Validation
```
Test A - Username Duplicate:
1. Coba buat akun dengan username yang sudah ada
2. Expected: Error "username sudah digunakan"

Test B - Password Mismatch:
1. Isi password dan konfirmasi password berbeda
2. Expected: Error "password tidak cocok"

Test C - File Upload:
1. Coba upload file non-image (PDF, TXT, dll)
2. Expected: Error "file harus berupa gambar"

Test D - File Size:
1. Coba upload gambar > 2MB
2. Expected: Error "ukuran file terlalu besar"
```

## 🐛 Common Issues & Solutions

### Issue 1: Logo tidak muncul
**Solution:**
```bash
php artisan storage:link
```

### Issue 2: Error 403 saat akses
**Check:**
```sql
SELECT * FROM users WHERE role = 'adminbem';
SELECT * FROM model_has_roles WHERE model_id = [user_id];
```

### Issue 3: Upload error
**Check:**
- Folder `storage/app/public/logos` exists and writable
- PHP upload_max_filesize setting
- PHP post_max_size setting

### Issue 4: Password tidak berubah
**Check:**
- Pastikan field password diisi
- Pastikan konfirmasi password sama
- Check di database: password hash berubah

## ✅ Success Criteria

- [x] AdminBEM dapat mengakses halaman account management
- [x] Dapat membuat akun baru dengan username & password
- [x] Dapat mengedit informasi akun
- [x] Dapat reset password tanpa password lama
- [x] Dapat upload dan ubah logo
- [x] Dapat menghapus akun
- [x] Non-adminbem tidak dapat akses halaman ini
- [x] Validasi form berfungsi dengan baik
- [x] Logo tersimpan dan ditampilkan dengan benar
- [x] Akun baru otomatis mendapat role adminukm

## 📸 Expected Screenshots

### Halaman Index (Empty State)
```
- Header: "Unit Kegiatan Mahasiswa"
- Tombol: "Tambah Akun" (orange, top right)
- Content: Icon + "Belum Ada Akun" message
```

### Halaman Index (With Accounts)
```
- Grid of cards (3 columns on desktop)
- Each card shows:
  * Logo (circular, centered)
  * Organization name
  * Username
  * Edit & Delete buttons
```

### Halaman Form (Create)
```
- Header: "Tambah Akun Baru"
- Logo preview (placeholder icon)
- Fields: Nama Organisasi, Username, Password, Konfirmasi Password
- Upload logo button
- Buttons: Batal (gray), Buat Akun (orange)
```

### Halaman Form (Edit)
```
- Header: [Organization Name]
- Logo preview (existing logo or placeholder)
- Same fields as create
- Password section: "Ubah Password (Opsional)"
- Buttons: Batal (gray), Simpan Perubahan (orange)
```

## 🎯 Performance Checklist

- [ ] Page loads in < 2 seconds
- [ ] Logo upload completes in < 5 seconds
- [ ] No console errors
- [ ] Responsive on mobile devices
- [ ] Smooth transitions and animations
- [ ] Modal opens/closes smoothly

## 📝 Test Report Template

```
Date: [Date]
Tester: [Name]
Browser: [Chrome/Firefox/Safari]
Device: [Desktop/Mobile]

Test Results:
✅ Access Control - PASS
✅ Create Account - PASS
✅ Edit Account - PASS
✅ Change Password - PASS
✅ Upload Logo - PASS
✅ Delete Account - PASS
✅ Validation - PASS
✅ Responsive Design - PASS

Issues Found:
1. [Issue description]
2. [Issue description]

Notes:
[Additional notes]
