<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RealSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Permission List as array
        $permissions = [

            [
                'group_name' => 'dashboard',
                'permissions' => [
                    'dashboard.view',
                    'dashboard.edit',
                ]
            ],
            [
                'group_name' => 'user',
                'permissions' => [
                    // user Permissions
                    'user.create',
                    'user.view',
                    'user.edit',
                    'user.delete',
                    'user.approve',
                ]
            ],
            [
                'group_name' => 'admin',
                'permissions' => [
                    // admin Permissions
                    'admin.create',
                    'admin.view',
                    'admin.edit',
                    'admin.delete',
                    'admin.approve',
                ]
            ],
            [
                'group_name' => 'role',
                'permissions' => [
                    // role Permissions
                    'role.create',
                    'role.view',
                    'role.edit',
                    'role.delete',
                    'role.approve',
                ]
            ],
            [
                'group_name' => 'vendor',
                'permissions' => [
                    // role Permissions
                    'vendor.create',
                    'vendor.view',
                    'vendor.edit',
                    'vendor.delete',
                    'vendor.approve',
                ]
            ],
        ];

        // Insert the permisison with group in the database
        for ($i = 0; $i < count($permissions); $i++) {
            // Group name
            $permissionGroup = $permissions[$i]['group_name'];
            // Permissions
            for ($j = 0; $j < count($permissions[$i]['permissions']); $j++) {
                // Create permission
                $permission = Permission::create(['name' => $permissions[$i]['permissions'][$j], 'group_name' => $permissionGroup]);
            }
        }

        // Create roles
        $role1 = Role::create(['name' => 'user']);
        $role2 = Role::create(['name' => 'admin']);
        $role3 = Role::create(['name' => 'vendor']);
        $role4 = Role::create(['name' => 'super-admin']);

        // create demo users
        $user = \App\Models\User::factory()->create([
            'name' => 'User',
            'email' => 'test@gmail.com',
            'profile_image' => 'default.jpg',
            'last_activity' => time(), // user inactivity
        ]);
        $user->assignRole($role1);

        $user = \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'profile_image' => 'default.jpg',
            'last_activity' => time(),
        ]);
        $user->assignRole($role2);

        $user = \App\Models\User::factory()->create([
            'name' => 'Vendor',
            'email' => 'vendor@gmail.com',
            'profile_image' => 'default.jpg',
            'last_activity' => time(),
        ]);
        $user->assignRole($role3);

        $user = \App\Models\User::factory()->create([
            'name' => 'Super-Admin',
            'email' => 'superadmin@gmail.com',
            'profile_image' => 'default.jpg',
            'last_activity' => time(),
        ]);
        $user->assignRole($role4);
    }
}
