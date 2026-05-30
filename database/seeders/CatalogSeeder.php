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
use Database\Seeders\SoftwareTypeSeeder;
use Database\Seeders\ProviderSeeder;
use Database\Seeders\LicenseSeeder;
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
            ProviderSeeder::class,
            SoftwareTypeSeeder::class,
            LicenseSeeder::class,
            ModelComponentSeeder::class,
        ]);
    }
}
