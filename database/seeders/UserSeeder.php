<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = User::firstWhere('username', 'superadmin');

        if (empty($superAdmin)) {
            $superAdmin = User::factory()->createQuietly([
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'email' => "superadmin@fmt.com",
                'password' => Hash::make('password'),
            ]);
            $superAdmin->assignRole('super-admin');
        }
    }
}
