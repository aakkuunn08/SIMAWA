<?php

// Script untuk mengecek user dan role mereka
// Jalankan dengan: php check-users-roles.php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Spatie\Permission\Models\Role;

echo "\n=== CHECKING USERS AND ROLES ===\n\n";

// Get all users
$users = User::all();

if ($users->isEmpty()) {
    echo "❌ No users found in database!\n";
    exit;
}

echo "Total users: " . $users->count() . "\n\n";

foreach ($users as $user) {
    echo "-----------------------------------\n";
    echo "ID: " . $user->id . "\n";
    echo "Name: " . $user->name . "\n";
    echo "Username: " . $user->username . "\n";
    echo "Legacy Role Column: " . ($user->role ?? 'NULL') . "\n";
    echo "is_admin: " . ($user->is_admin ?? 'NULL') . "\n";
    
    // Check Spatie roles
    $spatieRoles = $user->roles->pluck('name')->toArray();
    if (empty($spatieRoles)) {
        echo "Spatie Roles: NONE\n";
    } else {
        echo "Spatie Roles: " . implode(', ', $spatieRoles) . "\n";
    }
    
    // Test hasRole method
    echo "\nTesting hasRole() method:\n";
    echo "  hasRole('adminbem'): " . ($user->hasRole('adminbem') ? 'YES' : 'NO') . "\n";
    echo "  hasRole('adminukm'): " . ($user->hasRole('adminukm') ? 'YES' : 'NO') . "\n";
    echo "  hasRole('adminbem','adminukm'): " . ($user->hasRole('adminbem','adminukm') ? 'YES' : 'NO') . "\n";
    
    // Test hasAnyRole method
    echo "\nTesting hasAnyRole() method:\n";
    echo "  hasAnyRole(['adminbem','adminukm']): " . ($user->hasAnyRole(['adminbem','adminukm']) ? 'YES' : 'NO') . "\n";
    
    echo "\n";
}

echo "\n=== AVAILABLE ROLES IN DATABASE ===\n\n";
$roles = Role::all();
if ($roles->isEmpty()) {
    echo "❌ No roles found! Run: php artisan db:seed --class=RolePermissionSeeder\n";
} else {
    foreach ($roles as $role) {
        echo "- " . $role->name . " (ID: " . $role->id . ")\n";
    }
}

echo "\n=== END ===\n\n";
