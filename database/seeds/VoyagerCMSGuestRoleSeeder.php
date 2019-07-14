<?php

namespace Tjventurini\VoyagerCMS\Seeds;

use TCG\Voyager\Models\Role;
use Illuminate\Database\Seeder;

class VoyagerCMSGuestRoleSeeder extends Seeder
{
    /**
     * Run the voyager tags package database seeders.
     *
     * @return void
     */
    public function run()
    {
        $guest = Role::updateOrCreate([
            'name' => 'guest'
        ], [
            'display_name' => 'Guest',
        ]);
    }
}
