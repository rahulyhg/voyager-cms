<?php

namespace Tjventurini\VoyagerCMS\Seeds;

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class VoyagerCMSUsersSeeder extends Seeder
{
    /**
     * Run the voyager tags package database seeders.
     *
     * @return void
     */
    public function run()
    {
        // create admin user if not existent
        $admin = User::firstOrCreate([
            'email' => 'admin@admin.com',
        ], [
            'name' => 'Admin',
            'password' => Hash::make('password'),
            'role_id' => 1,
            'avatar' => 'users/default.png',
        ]);
    }
}
