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

        Models::create([
            'brandId'       => 'LG',
            'typeId'        => 'MON',
            'modelFamily'   => '24MS',
            'modelSerie'    => '550-B',
        ]);

        Models::create([
            'brandId'       => 'HIK',
            'typeId'        => 'UPS',
            'modelFamily'   => 'DS-UPS',
            'modelSerie'    => '3000',
        ]);

        Models::create([
            'brandId'       => 'DELL',
            'typeId'        => 'SFF',
            'modelFamily'   => 'OPTIFLEX',
            'modelSerie'    => '5050',
        ]);
    }
}
