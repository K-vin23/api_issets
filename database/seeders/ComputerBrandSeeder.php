<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ComputerBrand;

class ComputerBrandSeeder extends Seeder
{
    public function run(): void
    {
        ComputerBrand::create([
            'brandId' => 'DELL',
            'brand'   => 'DELL'
        ]);
    }
}
