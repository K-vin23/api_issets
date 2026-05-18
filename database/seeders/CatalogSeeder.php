<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\AssetTypeSeeder;
use Database\Seeders\BranSeeder;
use Database\Seeders\ModelsSeeder;
use Database\Seeders\ComponentCategorySeeder;
use Database\Seeders\ComponentTypeSeeder;
use Database\Seeders\ComponentSeeder;
use Database\Seeders\ModelComponentSeeder;

class CatalogSeeder extends Seeder
{

    public function run(): void
    {
        $this->call([
            AssetTypeSeeder::class,
            BrandSeeder::class,
            ModelsSeeder::class,
            ComponentCategorySeeder::class,
            ComponentTypeSeeder::class,
            ComponentSeeder::class,
            ModelComponentSeeder::class,
        ]);
    }
}
