# 📝 Instruksi Commit ke GitHub

## File-file yang Perlu Di-Push

Berikut adalah file-file baru yang perlu di-commit dan push ke GitHub agar teman Anda bisa menggunakannya:

### ✅ File yang HARUS di-push:

1. **QUICK_FIX_ERROR_419.md** - Panduan cepat fix error 419
2. **FIX_ERROR_419_CSRF.md** - Panduan lengkap error 419
3. **DEVELOPER_SETUP_README.md** - Panduan setup untuk developer
4. **setup-dev.bat** - Script otomatis setup environment
5. **fix-error-419.bat** - Script otomatis fix error 419
6. **get-app-key.bat** - Script untuk mendapatkan APP_KEY
7. **.env.shared** - Template environment (SETELAH diisi APP_KEY!)

### ❌ File yang JANGAN di-push:

- **.env** - File ini sudah ada di .gitignore
- **SECURITY_MULTI_DEVICE_GUIDE.md** - Ini untuk masalah lain (opsional)
- **fix-multi-device-session.bat** - Ini untuk masalah lain (opsional)

## 🔧 Langkah-langkah

### Step 1: Update .env.shared dengan APP_KEY Anda

```bash
# 1. Dapatkan APP_KEY Anda
get-app-key.bat

# 2. Buka file .env.shared
# 3. Cari baris: APP_KEY=
# 4. Ganti dengan: APP_KEY=base64:xxxxx... (dari hasil get-app-key.bat)
# 5. Save file
```

### Step 2: Commit dan Push ke GitHub

```bash
# 1. Add file-file baru
git add QUICK_FIX_ERROR_419.md
git add FIX_ERROR_419_CSRF.md
git add DEVELOPER_SETUP_README.md
git add setup-dev.bat
git add fix-error-419.bat
git add get-app-key.bat
git add .env.shared

# 2. Commit dengan pesan yang jelas
git commit -m "Add developer setup guides and fix scripts for Error 419

- Add quick fix guide for Error 419 (CSRF token mismatch)
- Add comprehensive Error 419 troubleshooting guide
- Add developer setup README with step-by-step instructions
- Add automated setup script (setup-dev.bat)
- Add automated fix script for Error 419 (fix-error-419.bat)
- Add script to get APP_KEY for team sharing (get-app-key.bat)
- Add .env.shared template with shared APP_KEY for team

These files help team members avoid Error 419 when creating adminukm accounts
by ensuring all developers use the same APP_KEY."

# 3. Push ke GitHub
git push origin main
```

### Step 3: Instruksi untuk Teman Anda

Setelah push, kirim pesan ini ke teman Anda:

```
Hi! Saya sudah push fix untuk Error 419 ke GitHub.

Langkah untuk kamu:
1. Pull latest code: git pull origin main
2. Jalankan: setup-dev.bat
3. Ikuti instruksi di layar
4. Coba lagi buat akun adminukm

Kalau masih error, baca: QUICK_FIX_ERROR_419.md

APP_KEY sudah ada di .env.shared, jadi kamu tinggal copy aja.
```

## 📋 Checklist

Sebelum push, pastikan:

- [ ] .env.shared sudah diisi dengan APP_KEY yang benar
- [ ] Semua script (.bat) sudah di-test dan berfungsi
- [ ] Dokumentasi sudah lengkap dan jelas
- [ ] Tidak ada informasi sensitif (password, API keys, dll)
- [ ] .gitignore masih mengabaikan .env

## 🔒 Keamanan

**PENTING:**
- APP_KEY di .env.shared adalah untuk **DEVELOPMENT ONLY**
- JANGAN gunakan APP_KEY yang sama untuk **PRODUCTION**
- Untuk production, generate APP_KEY baru yang berbeda

## ✅ Verifikasi

Setelah push, minta teman untuk:

```bash
# 1. Pull dari GitHub
git pull origin main

# 2. Cek file ada
dir QUICK_FIX_ERROR_419.md
dir setup-dev.bat
dir .env.shared

# 3. Jalankan setup
setup-dev.bat

# 4. Test buat akun adminukm
# Seharusnya berhasil tanpa Error 419!
```

## 🎉 Done!

Setelah teman Anda pull dan setup, masalah Error 419 seharusnya teratasi!

---

**Note:** File ini (COMMIT_INSTRUCTIONS.md) tidak perlu di-push ke GitHub.
Ini hanya untuk panduan Anda saat commit.
