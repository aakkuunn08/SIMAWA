# ⚡ Quick Fix: Error 419 (CSRF Token Mismatch)

## 🎯 Masalah

**Di laptop Anda:** Buat akun adminukm → ✅ BERHASIL  
**Di laptop teman:** Buat akun adminukm → ❌ ERROR 419

## 🔍 Penyebab

**APP_KEY berbeda** antara laptop Anda dan laptop teman!

File `.env` tidak ter-push ke GitHub (memang seharusnya), jadi setiap developer punya APP_KEY berbeda.

## ✅ Solusi Super Cepat

### Untuk Anda (Yang Berhasil):

**1. Dapatkan APP_KEY Anda:**
```bash
get-app-key.bat
```

**2. Bagikan APP_KEY ke teman:**
- Copy APP_KEY yang muncul
- Kirim ke teman via chat/email (JANGAN di public!)

**3. Update .env.shared (opsional tapi recommended):**
```bash
# Buka file .env.shared
# Ganti baris:
APP_KEY=

# Menjadi:
APP_KEY=base64:xxxxx... (paste APP_KEY Anda)

# Commit dan push ke GitHub
git add .env.shared
git commit -m "Update APP_KEY for team"
git push
```

### Untuk Teman Anda (Yang Error 419):

**1. Terima APP_KEY dari Anda**

**2. Update .env:**
```bash
# Buka file .env
# Cari baris:
APP_KEY=xxxxx

# Ganti dengan APP_KEY yang diterima dari Anda:
APP_KEY=base64:xxxxx... (paste dari Anda)

# Save file
```

**3. Jalankan fix script:**
```bash
fix-error-419.bat
```

**4. Restart:**
- Restart Laragon/XAMPP
- Close semua browser
- Buka browser baru (Incognito mode lebih baik)

**5. Coba lagi:**
- Login sebagai AdminBEM
- Buat akun adminukm
- Seharusnya BERHASIL! ✅

## 🔄 Untuk Developer Baru di Masa Depan

**Jika sudah update .env.shared:**

```bash
# 1. Pull dari GitHub
git pull

# 2. Copy .env.shared ke .env
copy .env.shared .env

# 3. Update database credentials di .env
# JANGAN ubah APP_KEY!

# 4. Run setup
setup-dev.bat
```

## ⚠️ PENTING!

**DO ✅**
- Gunakan APP_KEY yang SAMA dengan tim
- Share APP_KEY hanya ke tim development
- Update .env.shared dengan APP_KEY yang benar

**DON'T ❌**
- JANGAN run `php artisan key:generate` (akan buat APP_KEY baru!)
- JANGAN ubah APP_KEY setelah di-set
- JANGAN share APP_KEY di public (GitHub issues, forum, dll)

## 📞 Masih Error?

Cek dokumentasi lengkap: [FIX_ERROR_419_CSRF.md](FIX_ERROR_419_CSRF.md)

---

**TL;DR:**
1. Anda: Run `get-app-key.bat` → Copy APP_KEY
2. Teman: Paste APP_KEY ke `.env` → Run `fix-error-419.bat`
3. Restart server & browser
4. Done! ✅
