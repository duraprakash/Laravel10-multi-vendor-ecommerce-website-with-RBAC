<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class RealAdditionalPermissionSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Additional Permission List as array
        $permissions = [
            [
                'group_name' => 'product',
                'permissions' => [
                    // role Permissions
                    'product.create',
                    'product.view',
                    'product.edit',
                    'product.delete',
                    'product.approve',
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
    }
}
