<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\CompaniesSeeder;
use Database\Seeders\CitiesSeeder;
use Database\Seeders\AreasSeeder;
use Database\Seeders\LocationsSeeder;
use Database\Seeders\RolesSeeder;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\TechnicianUserSeeder;

class UserSeeder extends Seeder
{

    public function run(): void
    {
        $this->call([
            CompaniesSeeder::class,
            CitiesSeeder::class,
            AreasSeeder::class,
            LocationsSeeder::class,
            RolesSeeder::class,
            AdminUserSeeder::class,
            TechnicianUserSeeder::class
        ]);
    }
}
