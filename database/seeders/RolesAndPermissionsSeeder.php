<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = $this->getPermissions();

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                ['guard_name' => $permission['guard_name']]
            );
        }

        // Create Roles
        $roles = $this->getRoles();

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['name' => $role['name']],
                ['guard_name' => $role['guard_name']]
            );
        }

        // * Super Admin Permissions
        $superAdminRole = Role::firstWhere('name', 'super-admin');

        foreach ($permissions as $permission) {
            $permission = Permission::where('guard_name', $permission['guard_name'])
                ->where('name', $permission['name'])
                ->first();

            $superAdminRole->givePermissionTo($permission);
        }
    }

    private function getPermissions(): array
    {
        return [
            [
                'name' => 'admin_create',
                'guard_name' => 'web'
            ],
            [
                'name' => 'admin_edit',
                'guard_name' => 'web'
            ],
            [
                'name' => 'admin_show',
                'guard_name' => 'web'
            ],
            [
                'name' => 'admin_delete',
                'guard_name' => 'web'
            ],
        ];
    }

    private function getRoles(): array
    {
        return [
            [
                'name' => 'super-admin',
                'guard_name' => 'web'
            ],
            [
                'name' => 'admin',
                'guard_name' => 'web'
            ],
            [
                'name' => 'customer',
                'guard_name' => 'web'
            ],
        ];
    }
}
