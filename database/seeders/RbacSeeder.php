<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RbacSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'super-admin']);

        $this->seedPermissions();
        $this->assignPermissionsToAdmin();
    }

    public function seedPermissions()
    {
        $permissions = $this->getPermissions();

        $permissions = collect($permissions)->map(function ($permission) {
            return ['name' => $permission, 'guard_name' => 'web'];
        })->toArray();

        foreach($permissions as $permission) {
            Permission::firstOrCreate($permission);
        }
    }

    public function getPermissions()
    {
        return [
            /* ---------------------------------- Users --------------------------------- */
            'Users.create',
            'Users.view',
            'Users.update',
            'Users.delete',

            /* --------------------------------- Member --------------------------------- */
            'Members.create',
            'Members.view',
            'Members.update',
            'Members.delete',

            /* ------------------------------ Subscriptions ----------------------------- */
            'Subscriptions.create',
            'Subscriptions.view',
            'Subscriptions.update',
            'Subscriptions.delete',
        ];
    }

    public function assignPermissionsToAdmin()
    {
        $role = Role::firstOrCreate(['name' => 'admin']);
        $permissions = $this->getPermissions();

        $role->syncPermissions($permissions);
    }
}
