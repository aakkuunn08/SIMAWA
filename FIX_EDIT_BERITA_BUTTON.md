# Fix: Button "Edit Berita" Tidak Muncul

## Masalah
Button "Edit Berita" tidak muncul di halaman dashboard, sedangkan button "Tambah Kegiatan" berfungsi normal.

## Akar Masalah
- Button "Edit Berita" menggunakan directive Spatie `@hasanyrole('adminbem|adminukm')` yang hanya mengecek role dari tabel Spatie
- User masih menggunakan sistem role lama (kolom `role` di tabel `users`)
- Directive Spatie tidak memiliki fallback ke sistem role lama

## Solusi
Mengganti directive Spatie dengan method `hasRole()` yang sudah di-override di User model untuk support kedua sistem (Spatie + legacy).

## Perubahan File

### File: `resources/views/dashboard.blade.php`

**Sebelum:**
```blade
@hasanyrole('adminbem|adminukm')
<div class="flex justify-end mt-6">
    <button class="modern-btn modern-btn-primary">
        Edit Berita
    </button>
</div>
@endhasanyrole
```

**Sesudah:**
```blade
@auth
    @if(auth()->user()->hasRole('adminbem','adminukm'))
    <div class="flex justify-end mt-6">
        <button class="modern-btn modern-btn-primary">
            Edit Berita
        </button>
    </div>
    @endif
@endauth
```

## Cara Testing
1. Login sebagai adminbem atau adminukm
2. Buka halaman dashboard
3. Scroll ke section "NEWS"
4. Button "Edit Berita" seharusnya muncul

## Troubleshooting: Button Kadang Hilang Kadang Muncul

Jika button masih tidak konsisten muncul, lakukan clear cache:

### Via Laragon Terminal:
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan permission:cache-reset
```

### Via Browser:
- Hard refresh: `Ctrl + Shift + R` atau `Ctrl + F5`
- Clear browser cache: `Ctrl + Shift + Delete`

### Manual:
Hapus folder:
- `storage/framework/cache/data/*`
- `storage/framework/views/*`
- `bootstrap/cache/*` (kecuali .gitignore)

## Status
✅ FIXED - Button "Edit Berita" sekarang muncul dengan konsisten untuk user dengan role adminbem atau adminukm
