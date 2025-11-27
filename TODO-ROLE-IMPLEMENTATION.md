# TODO: Role System Implementation

## Progress Tracking

### 1. Update User Model ✓
- [ ] Tambah helper methods: isAdmin(), isAdminBem(), hasRole()
- [ ] Tambah is_admin ke fillable array

### 2. Update IsAdmin Middleware ✓
- [ ] Ubah logic untuk cek role 'admin' ATAU 'adminbem'

### 3. Create IsAdminBem Middleware ✓
- [ ] Buat middleware baru untuk super admin only

### 4. Register Middleware ✓
- [ ] Tambah 'admin' alias di Kernel.php
- [ ] Tambah 'adminbem' alias di Kernel.php

### 5. Update Database Seeder ✓
- [ ] Buat user dengan role 'adminbem'
- [ ] Buat user dengan role 'admin'

### 6. Update Routes ✓
- [ ] Tambah contoh route dengan middleware 'admin'
- [ ] Tambah contoh route dengan middleware 'adminbem'

## Notes
- adminbem = super admin (bisa akses semua)
- admin = admin biasa (tidak bisa mengelola adminbem)
