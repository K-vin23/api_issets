<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\AssetSeeder;
use Database\Seeders\AssetComponentSeeder;
use Database\Seeders\AssetLicenseSeeder;

class AssetsSeeder extends Seeder
{

    public function run(): void
    {
        $this->call([
            AssetSeeder::class,
            AssetComponentSeeder::class,
            AssetLicenseSeeder::class
        ]);
    }
}
