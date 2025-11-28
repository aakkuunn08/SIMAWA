# Spatie Laravel Permission - Implementation Guide

## ✅ Installation Complete

Spatie Laravel Permission telah berhasil diinstall dan dikonfigurasi di proyek SIMAWA.

---

## 📋 Roles & Permissions Structure

### Roles:
1. **adminbem** (Super Admin)
   - Akses penuh ke semua fitur
   - Dapat mengelola users, admin, dan semua content
   - Dapat mengakses system settings

2. **admin** (Admin)
   - Dapat mengelola content (berita, kegiatan, LPJ)
   - Dapat mengelola ormawa
   - Dapat mengelola tes minat
   - Dapat melihat users (tapi tidak bisa create/edit/delete)
   - Tidak dapat mengakses system settings

3. **user** (Regular User)
   - Dapat melihat content
   - Dapat melihat ormawa
   - Dapat mengikuti tes minat

### Permissions:
```
User Management:
- manage-users (full CRUD)
- view-users
- create-users
- edit-users
- delete-users

Content Management:
- manage-content (full CRUD)
- view-content
- create-content
- edit-content
- delete-content

Ormawa Management:
- manage-ormawa (full CRUD)
- view-ormawa
- create-ormawa
- edit-ormawa
- delete-ormawa

Tes Minat Management:
- manage-tes-minat (full CRUD)
- view-tes-minat
- create-tes-minat
- edit-tes-minat
- delete-tes-minat

System Settings:
- manage-settings
- view-settings
```

---

## 🚀 Usage Examples

### 1. Checking Roles in Controllers

```php
// Check if user has specific role
if (auth()->user()->hasRole('adminbem')) {
    // Super admin only code
}

// Check if user has any of the roles
if (auth()->user()->hasAnyRole(['admin', 'adminbem'])) {
    // Admin or AdminBEM code
}

// Check if user has all roles
if (auth()->user()->hasAllRoles(['admin', 'editor'])) {
    // Code for users with both roles
}
```

### 2. Checking Permissions in Controllers

```php
// Check if user has specific permission
if (auth()->user()->can('manage-users')) {
    // User management code
}

// Check if user has any of the permissions
if (auth()->user()->hasAnyPermission(['create-content', 'edit-content'])) {
    // Content creation/editing code
}

// Check if user has all permissions
if (auth()->user()->hasAllPermissions(['create-content', 'delete-content'])) {
    // Code requiring both permissions
}
```

### 3. Using Middleware in Routes

```php
// Using custom middleware (recommended for backward compatibility)
Route::middleware(['auth', 'admin'])->group(function () {
    // Admin and AdminBEM can access
});

Route::middleware(['auth', 'adminbem'])->group(function () {
    // Only AdminBEM can access
});

// Using Spatie's role middleware
Route::middleware(['auth', 'role:adminbem'])->group(function () {
    // Only AdminBEM can access
});

Route::middleware(['auth', 'role:admin|adminbem'])->group(function () {
    // Admin or AdminBEM can access
});

// Using Spatie's permission middleware
Route::middleware(['auth', 'permission:manage-users'])->group(function () {
    // Users with manage-users permission can access
});

Route::middleware(['auth', 'permission:create-content|edit-content'])->group(function () {
    // Users with either permission can access
});
```

### 4. Blade Directives

```blade
{{-- Check role --}}
@role('adminbem')
    <p>You are a Super Admin!</p>
@endrole

@hasrole('admin')
    <p>You are an Admin!</p>
@endhasrole

{{-- Check any role --}}
@hasanyrole('admin|adminbem')
    <p>You are an admin!</p>
@endhasanyrole

{{-- Check permission --}}
@can('manage-users')
    <a href="{{ route('users.index') }}">Manage Users</a>
@endcan

{{-- Check multiple permissions --}}
@canany(['create-content', 'edit-content'])
    <a href="{{ route('content.create') }}">Create Content</a>
@endcanany

{{-- Inverse checks --}}
@unlessrole('admin')
    <p>You are not an admin</p>
@endunlessrole
```

### 5. Assigning Roles & Permissions

```php
// Assign role to user
$user = User::find(1);
$user->assignRole('admin');

// Assign multiple roles
$user->assignRole(['admin', 'editor']);

// Remove role
$user->removeRole('admin');

// Sync roles (removes all current roles and assigns new ones)
$user->syncRoles(['admin']);

// Assign permission directly to user
$user->givePermissionTo('manage-users');

// Remove permission
$user->revokePermissionTo('manage-users');

// Sync permissions
$user->syncPermissions(['create-content', 'edit-content']);
```

### 6. Managing Roles & Permissions

```php
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

// Create new role
$role = Role::create(['name' => 'editor']);

// Create new permission
$permission = Permission::create(['name' => 'publish-content']);

// Assign permission to role
$role->givePermissionTo('publish-content');

// Remove permission from role
$role->revokePermissionTo('publish-content');

// Sync permissions for role
$role->syncPermissions(['create-content', 'edit-content', 'publish-content']);

// Get all permissions for a role
$permissions = $role->permissions;

// Get all users with a role
$admins = User::role('admin')->get();

// Get all users with a permission
$users = User::permission('manage-users')->get();
```

---

## 🔧 Helper Methods (Backward Compatibility)

User model memiliki helper methods untuk backward compatibility:

```php
// Check if user is admin
$user->isAdmin(); // Returns true if user has 'admin' role

// Check if user is adminbem
$user->isAdminBem(); // Returns true if user has 'adminbem' role

// Check if user is any admin
$user->isAnyAdmin(); // Returns true if user has 'admin' or 'adminbem' role
```

---

## 📝 Database Seeding

### Initial Setup (Run Once)
```bash
php artisan migrate:fresh --seed
```

Ini akan:
1. Create semua tables
2. Create roles & permissions
3. Create AdminBEM user pertama (adminbem/adminbem123)
4. Seed ormawa data

### Login Credentials (Default)
- **Username:** adminbem
- **Password:** adminbem123
- ⚠️ **PENTING:** Ganti password ini di production!

---

## 🎯 Best Practices

### 1. Gunakan Seeder untuk Setup Awal
- Hanya untuk AdminBEM pertama
- Jalankan sekali saat deploy

### 2. Gunakan Database untuk Operasional
- Semua user lain dibuat via UI oleh AdminBEM
- Tersimpan di database untuk persistensi
- Mudah di-query dan dikelola

### 3. Gunakan Permissions untuk Fine-Grained Control
```php
// Good: Check specific permission
if ($user->can('delete-content')) {
    // Delete content
}

// Also Good: Check role for broader access
if ($user->hasRole('adminbem')) {
    // Super admin features
}
```

### 4. Cache Clearing
Jika ada perubahan pada roles/permissions, clear cache:
```bash
php artisan permission:cache-reset
```

### 5. Testing
```php
// In tests, you can assign roles easily
$user = User::factory()->create();
$user->assignRole('admin');

$this->actingAs($user)
    ->get('/admin/dashboard')
    ->assertStatus(200);
```

---

## 🔄 Migration from Legacy System

Sistem lama (kolom `role` dan `is_admin`) masih berfungsi untuk backward compatibility:

```php
// Legacy way (still works)
if ($user->role === 'admin') {
    // ...
}

// New way (recommended)
if ($user->hasRole('admin')) {
    // ...
}

// Both work together
if ($user->hasRole('admin') || $user->role === 'admin') {
    // ...
}
```

---

## 📚 Additional Resources

- [Spatie Permission Documentation](https://spatie.be/docs/laravel-permission)
- [GitHub Repository](https://github.com/spatie/laravel-permission)

---

## 🐛 Troubleshooting

### Cache Issues
```bash
php artisan permission:cache-reset
php artisan config:clear
php artisan cache:clear
```

### Role Not Found
```bash
# Re-run seeders
php artisan db:seed --class=RolePermissionSeeder
```

### Permission Denied Errors
```php
// Check if user has role
dd($user->roles);

// Check if user has permission
dd($user->permissions);

// Check all permissions for user (including via roles)
dd($user->getAllPermissions());
```

---

## ✅ Next Steps

1. ✅ Install Spatie Permission - **DONE**
2. ✅ Create migrations - **DONE**
3. ✅ Update User model - **DONE**
4. ✅ Create seeders - **DONE**
5. ✅ Update middleware - **DONE**
6. ✅ Register middleware - **DONE**
7. 🔲 Create User Management UI (AdminBEM only)
8. 🔲 Add role/permission checks in views
9. 🔲 Test all functionality
10. 🔲 Deploy to production

---

**Status:** ✅ Implementation Complete - Ready for Testing
