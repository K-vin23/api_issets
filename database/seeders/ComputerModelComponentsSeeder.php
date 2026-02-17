<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ComputerModelMemory;
use App\Models\ComputerModelDisk;

class ComputerModelComponentsSeeder extends Seeder
{
    public function run(): void
    {
        ComputerModelMemory::create([
            'modelId'   => 1,
            'memoryId'  => 2
        ]);

        ComputerModelDisk::create([
            'modelId'   => 1,
            'diskId'    => 1
        ]);
    }
}
