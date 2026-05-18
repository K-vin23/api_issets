<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Models;

class ModelsSeeder extends Seeder
{
    public function run(): void
    {
        Models::create([
            'brandId'       => 'DELL',
            'typeId'        => 'LAP',
            'modelFamily'   => 'LATITUDE',
            'modelSerie'    => '3440',
        ]);
    }
}
