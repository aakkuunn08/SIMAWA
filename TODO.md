# Analisis File SIMAWA - File yang Tidak Digunakan

## Ringkasan Analisis

Berdasarkan pemeriksaan routes (web.php, auth.php, api.php), controllers, models, dan views yang aktif digunakan, berikut adalah daftar file yang teridentifikasi TIDAK DIGUNAKAN dalam proyek SIMAWA.

---

## ✅ FILE YANG DIGUNAKAN (JANGAN DIHAPUS)

### Routes
- ✅ routes/web.php - Digunakan (home, dashboard, profile, ormawa, admin users)
- ✅ routes/auth.php - Digunakan (login, logout, password reset)
- ✅ routes/api.php - Digunakan (minimal, tapi standar Laravel)
- ✅ routes/channels.php - Standar Laravel
- ✅ routes/console.php - Standar Laravel

### Controllers yang Digunakan
- ✅ app/Http/Controllers/ProfileController.php - Digunakan di routes/web.php
- ✅ app/Http/Controllers/OrmawaController.php - Digunakan di routes/web.php
- ✅ app/Http/Controllers/Auth/* - Semua digunakan di routes/auth.php

### Models yang Digunakan
- ✅ app/Models/User.php - Model utama
- ✅ app/Models/Ormawa.php - Digunakan di OrmawaController

### Views yang Digunakan
- ✅ resources/views/home.blade.php - Route '/'
- ✅ resources/views/dashboard.blade.php - Route '/dashboard'
- ✅ resources/views/ormawa.blade.php - Route '/ormawa/{slug}'
- ✅ resources/views/auth/* - Semua digunakan untuk autentikasi
- ✅ resources/views/layouts/app.blade.php - Layout utama
- ✅ resources/views/layouts/guest.blade.php - Layout guest
- ✅ resources/views/layouts/navigation.blade.php - Navigation

---

## ❌ FILE YANG TIDAK DIGUNAKAN (DAPAT DIHAPUS)

### 1. Controllers yang Tidak Digunakan
```
❌ app/Http/Controllers/DaftarKegiatanController.php
   - Tidak ada route yang menggunakan controller ini
   - Method index() mencoba load view 'kegiatan.index' yang tidak ada

❌ app/Http/Controllers/SoalController.php
   - Tidak ada route yang menggunakan controller ini
   - Semua method (index, create, store, edit, update, destroy) tidak terhubung
```

### 2. Models yang Tidak Digunakan
```
❌ app/Models/Akun.php
   - Tidak digunakan di controller manapun
   - Tidak ada relasi yang menggunakannya

❌ app/Models/Berita.php
   - Tidak digunakan di controller manapun

❌ app/Models/DaftarKegiatan.php
   - Hanya digunakan di DaftarKegiatanController yang juga tidak digunakan

❌ app/Models/DataOrganisasi.php
   - Tidak digunakan di controller manapun

❌ app/Models/Jawaban.php
   - Tidak digunakan di controller manapun

❌ app/Models/Lpj.php
   - Tidak digunakan di controller manapun

❌ app/Models/Soal.php
   - Hanya digunakan di SoalController yang juga tidak digunakan

❌ app/Models/TesMinat.php
   - Tidak digunakan di controller manapun
```

### 3. Views yang Tidak Digunakan
```
❌ resources/views/welcome.blade.php
   - File default Laravel, tidak digunakan (home.blade.php yang digunakan)

❌ resources/views/create.blade.php
   - Tidak ada controller yang memanggil view ini

❌ resources/views/edit.blade.php
   - Tidak ada controller yang memanggil view ini

❌ resources/views/index.blade.php
   - Tidak ada controller yang memanggil view ini

❌ resources/views/navigation-menu.blade.php
   - Sepertinya dari Jetstream, tapi tidak digunakan (navigation.blade.php yang digunakan)

❌ resources/views/policy.blade.php
   - Tidak ada route yang mengarah ke view ini

❌ resources/views/terms.blade.php
   - Tidak ada route yang mengarah ke view ini
```

### 4. View Components yang Tidak Digunakan (Jetstream/Breeze Unused)
```
❌ resources/views/components/action-message.blade.php
❌ resources/views/components/action-section.blade.php
❌ resources/views/components/application-mark.blade.php
❌ resources/views/components/banner.blade.php
❌ resources/views/components/confirmation-modal.blade.php
❌ resources/views/components/confirms-password.blade.php
❌ resources/views/components/danger-button.blade.php
❌ resources/views/components/dialog-modal.blade.php
❌ resources/views/components/form-section.blade.php
❌ resources/views/components/modal.blade.php
❌ resources/views/components/secondary-button.blade.php
❌ resources/views/components/section-border.blade.php
❌ resources/views/components/section-title.blade.php
❌ resources/views/components/switchable-team.blade.php
❌ resources/views/components/welcome.blade.php
```

### 5. Folder API Views (Tidak Digunakan)
```
❌ resources/views/api/api-token-manager.blade.php
❌ resources/views/api/index.blade.php
```

### 6. Folder Emails (Kosong/Tidak Digunakan)
```
❌ resources/views/emails/ (folder kosong atau tidak digunakan)
```

### 7. View Components PHP Classes
```
❌ app/View/Components/GuestLayout.php
   - Tidak digunakan, guest.blade.php langsung di layouts
```

### 8. Migrations yang Tidak Digunakan (Model tidak digunakan)
```
❌ database/migrations/2025_11_16_110128_create_akun_table.php
❌ database/migrations/2025_11_16_112257_create_dataorganisasi_table.php
❌ database/migrations/2025_11_16_112258_create_daftar_kegiatan_table.php
❌ database/migrations/2025_11_16_112300_create_lpj_table.php
❌ database/migrations/2025_11_16_112301_create_berita_table.php
❌ database/migrations/2025_11_16_112302_create_soal_table.php
❌ database/migrations/2025_11_16_112303_create_jawaban_table.php
❌ database/migrations/2025_11_16_112304_create_tes_minat_table.php
```

### 9. Seeders yang Tidak Digunakan
```
⚠️ database/seeders/OrmawaSeeder.php
   - Perlu dicek apakah masih digunakan untuk seeding data ormawa
```

### 10. Test Files (Jetstream/Breeze Default - Tidak Relevan)
```
❌ tests/Feature/ApiTokenPermissionsTest.php
❌ tests/Feature/BrowserSessionsTest.php
❌ tests/Feature/CreateApiTokenTest.php
❌ tests/Feature/DeleteAccountTest.php
❌ tests/Feature/DeleteApiTokenTest.php
❌ tests/Feature/TwoFactorAuthenticationSettingsTest.php
```

### 11. Markdown Files (Tidak Digunakan)
```
❌ resources/markdown/policy.md
❌ resources/markdown/terms.md
```

### 12. Auth Views yang Tidak Digunakan
```
❌ resources/views/auth/two-factor-challenge.blade.php
   - Two-factor authentication tidak diimplementasikan
❌ resources/views/auth/verify-email.blade.php
   - Email verification tidak digunakan
```

---

## 📊 RINGKASAN JUMLAH FILE

### Total File yang Dapat Dihapus:
- **Controllers**: 2 file
- **Models**: 8 file
- **Views**: 7 file utama
- **View Components**: 15 file
- **API Views**: 2 file
- **Migrations**: 8 file
- **Test Files**: 6 file
- **Markdown**: 2 file
- **Auth Views**: 2 file

**TOTAL: ~52 file yang tidak digunakan**

---

## ⚠️ CATATAN PENTING

1. **Backup Dulu**: Sebelum menghapus, pastikan backup database dan kode
2. **Cek Dependencies**: Beberapa file mungkin digunakan secara tidak langsung
3. **OrmawaSeeder**: Perlu dicek apakah masih digunakan untuk populate data
4. **Migrations**: Jika sudah di-migrate di production, jangan hapus migration files
5. **Test Files**: Bisa dihapus jika tidak ada rencana testing

---

## 🔄 LANGKAH SELANJUTNYA

1. Review daftar file di atas
2. Konfirmasi file mana yang benar-benar ingin dihapus
3. Backup proyek
4. Hapus file secara bertahap
5. Test aplikasi setelah penghapusan

---

## ❓ PERTANYAAN UNTUK USER

1. Apakah Anda ingin menghapus semua file yang tidak digunakan?
2. Apakah ada fitur yang sedang dalam development yang menggunakan file-file tersebut?
3. Apakah migrations sudah dijalankan di production? (jika ya, jangan hapus migration files)
4. Apakah OrmawaSeeder masih digunakan untuk populate data?
