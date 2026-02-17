<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Area;

class AreasSeeder extends Seeder
{
    public function run(): void
    {
        Area::create([
            'area'  => 'SISTEMAS'
        ]);

        Area::create([
            'area'  => 'VENTAS'
        ]);
    }
}
