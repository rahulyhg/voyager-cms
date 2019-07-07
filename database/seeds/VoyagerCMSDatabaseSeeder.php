<?php

namespace Tjventurini\VoyagerCMS\Seeds;

use Illuminate\Database\Seeder;

class VoyagerCMSDatabaseSeeder extends Seeder
{
    /**
     * Run the voyager tags package database seeders.
     *
     * @return void
     */
    public function run()
    {
        $this->call(VoyagerCMSUsersSeeder::class);
        // $this->call(VoyagerCMSPermissionsSeeder::class);
        // $this->call(VoyagerCMSDataTypesSeeder::class);
        // $this->call(VoyagerCMSDataRowsSeeder::class);
        // $this->call(VoyagerCMSMenuItemsSeeder::class);
    }
}
