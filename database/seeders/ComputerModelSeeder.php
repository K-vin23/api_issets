<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ComputerModel;

class ComputerModelSeeder extends Seeder
{
    public function run(): void
    {
        ComputerModel::create([
            'brandId'       => 'DELL',
            'modelFamily'   => 'LATITUDE',
            'modelSerie'    => '3440',
            'processorId'   => 1
        ]);
    }
}
