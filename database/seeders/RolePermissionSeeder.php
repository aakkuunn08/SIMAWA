<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $permissions = [
            // User Management
            'manage-users',
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',

            // Content Management (Berita, Kegiatan, LPJ)
            'manage-content',
            'view-content',
            'create-content',
            'edit-content',
            'delete-content',

            // Ormawa Management
            'manage-ormawa',
            'view-ormawa',
            'create-ormawa',
            'edit-ormawa',
            'delete-ormawa',

            // Tes Minat Management
            'manage-tes-minat',
            'view-tes-minat',
            'create-tes-minat',
            'edit-tes-minat',
            'delete-tes-minat',

            // System Settings
            'manage-settings',
            'view-settings',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create Roles and Assign Permissions

        // 1. AdminBEM Role (Super Admin) - Has ALL permissions
        $adminBemRole = Role::create(['name' => 'adminbem']);
        $adminBemRole->givePermissionTo(Permission::all());

        // 2. AdminUKM Role (Admin UKM/SC) - Has most permissions except user management
        $adminUkmRole = Role::create(['name' => 'adminukm']);
        $adminUkmRole->givePermissionTo([
            'view-users',
            'manage-content',
            'view-content',
            'create-content',
            'edit-content',
            'delete-content',
            'manage-ormawa',
            'view-ormawa',
            'create-ormawa',
            'edit-ormawa',
            'delete-ormawa',
            'manage-tes-minat',
            'view-tes-minat',
            'create-tes-minat',
            'edit-tes-minat',
            'delete-tes-minat',
            'view-settings',
        ]);

        $this->command->info('Roles and Permissions created successfully!');
        $this->command->info('- adminbem: Super Admin with all permissions');
        $this->command->info('- adminukm: Admin UKM/SC with content management permissions');
        $this->command->info('Note: No user role needed - guests can access public features without login');
    }
}
