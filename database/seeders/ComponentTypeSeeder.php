<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ComponentType;

class ComponentTypeSeeder extends Seeder
{
    public function run(): void
    {
        ComponentType::create([
        'categoryId'    => 'MEM',
        'compType'      => 'DDR3'
        ]);

        ComponentType::create([
        'categoryId'    => 'MEM',
        'compType'      => 'DDR3L'
        ]);

        ComponentType::create([
        'categoryId'    => 'MEM',
        'compType'      => 'DDR4'
        ]);

        ComponentType::create([
        'categoryId'    => 'MEM',
        'compType'      => 'DDR4L'
        ]);

        ComponentType::create([
        'categoryId'    => 'MEM',
        'compType'      => 'DDR5'
        ]);

        ComponentType::create([
        'categoryId'    => 'STOR',
        'compType'      => 'M2'
        ]);

        ComponentType::create([
        'categoryId'    => 'STOR',
        'compType'      => 'SSD'
        ]);

        ComponentType::create([
        'categoryId'    => 'STOR',
        'compType'      => 'HDD'
        ]);

        ComponentType::create([
        'categoryId'    => 'PROC',
        'compType'      => 'INTEL'
        ]);

        ComponentType::create([
        'categoryId'    => 'PROC',
        'compType'      => 'AMD'
        ]);
    }
}
