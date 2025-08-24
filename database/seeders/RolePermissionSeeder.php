<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            'user.view',
            'user.create',
            'user.edit',
            'user.delete',
            'user.manage',
            'role.view',
            'role.create',
            'role.edit',
            'role.delete',
            'role.manage',
            'dashboard.view',
            'profile.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // Assign all permissions to super-admin
        $superAdminRole->givePermissionTo(Permission::all());

        // Assign limited permissions to admin
        $adminRole->givePermissionTo([
            'user.view',
            'user.create',
            'user.edit',
            'dashboard.view',
            'profile.manage',
        ]);

        // Assign basic permissions to user
        $userRole->givePermissionTo([
            'dashboard.view',
            'profile.manage',
        ]);

        // Create super-admin user
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'phone_number' => '1234567890',
            'country_code' => '+93',
            'password' => Hash::make('12345678'),
            'status' => true,
        ]);

        $superAdmin->assignRole('super-admin');
    }
}
