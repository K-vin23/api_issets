<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        Brand::create([
            'brandId' => 'DELL',
            'brand'   => 'DELL'
        ]);

        Brand::create([
            'brandId' => 'HIK',
            'brand'   => 'HIKVISION'
        ]);

        Brand::create([
            'brandId' => 'LG',
            'brand'   => 'LG'
        ]);
    }
}
