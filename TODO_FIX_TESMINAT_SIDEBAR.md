# TODO: Perbaikan Sidebar Tes Minat

## Masalah yang Diperbaiki:
1. ✅ Sidebar "Tes Minat" tidak berwarna oren saat berada di halaman tesminat
2. ✅ Sidebar "Tes Minat" sekarang selalu scroll ke section, bukan ke halaman menu
3. ✅ Button "Kelola Tes Minat" ditambahkan di dashboard untuk admin BEM

## Perubahan yang Dilakukan:

### 1. File: `resources/views/components/sidebar.blade.php`
**Perubahan:**
- Menambahkan variabel `$isDashboard` untuk deteksi halaman dashboard
- Menambahkan variabel `$isTesMinatPage` untuk highlighting sidebar saat di halaman tesminat
- Mengubah logika link "Tes Minat" untuk admin BEM:
  - Sebelumnya: Jika di home gunakan anchor, jika tidak ke `route('tesminatbem.menu')`
  - Sekarang: Selalu gunakan anchor `#tes-minat` (jika di home/dashboard) atau `url('/dashboard#tes-minat')` (jika di halaman lain)
- Menggunakan `$isTesMinatPage` untuk active class agar sidebar berwarna oren saat di halaman tesminat

**Hasil:**
- ✅ Sidebar "Tes Minat" sekarang berwarna oren saat berada di halaman tesminatbem (menu, results, pertanyaan)
- ✅ Klik sidebar "Tes Minat" akan scroll ke section, bukan navigasi ke menu page

### 2. File: `resources/views/dashboard.blade.php`
**Perubahan:**
- Menambahkan section `#tes-minat` dengan `scroll-mt-16` untuk smooth scroll
- Section sekarang ditampilkan untuk semua user (tidak hanya admin BEM)
- Menambahkan conditional button:
  - Admin BEM: "Kelola Tes Minat" → menuju `route('tesminatbem.menu')`
  - User biasa/Guest: "Ayo Mulai Tes!" → menuju `route('tesminat.index')`

**Hasil:**
- ✅ Admin BEM melihat button "Kelola Tes Minat" yang menuju halaman menu kelola
- ✅ User biasa melihat button "Ayo Mulai Tes!" yang menuju halaman tes
- ✅ Section dapat di-scroll dari sidebar

## Cara Kerja Sekarang:

### Untuk Admin BEM:
1. **Klik Sidebar "Tes Minat"** → Scroll ke section Tes Minat di dashboard
2. **Klik Button "Kelola Tes Minat"** (yang oren) → Navigasi ke halaman menu kelola tesminat
3. **Saat di halaman tesminatbem** → Sidebar "Tes Minat" berwarna oren (active)

### Untuk User Biasa:
1. **Klik Sidebar "Tes Minat"** → Scroll ke section Tes Minat di home/dashboard
2. **Klik Button "Ayo Mulai Tes!"** → Navigasi ke halaman tes minat

## Testing Checklist:
- [ ] Login sebagai admin BEM
- [ ] Klik sidebar "Tes Minat" dari dashboard → harus scroll ke section
- [ ] Klik button "Kelola Tes Minat" → harus ke halaman menu
- [ ] Saat di halaman menu/results/pertanyaan → sidebar "Tes Minat" harus berwarna oren
- [ ] Klik sidebar "Tes Minat" dari halaman menu → harus kembali ke dashboard dan scroll ke section
- [ ] Login sebagai user biasa → button harus "Ayo Mulai Tes!"
- [ ] Logout → button tetap "Ayo Mulai Tes!"

## Status: ✅ SELESAI
Semua perubahan telah diimplementasikan dan siap untuk testing.
