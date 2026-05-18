<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\AssetSeeder;
use Database\Seeders\AssetComponentSeeder;

class AssetsSeeder extends Seeder
{

    public function run(): void
    {
        $this->call([
            AssetSeeder::class,
            AssetComponentSeeder::class
        ]);
    }
}
