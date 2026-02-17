<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CitiesSeeder extends Seeder
{

    public function run(): void
    {
        City::create([
            'cityId' => 'CALI',
            'city'   => 'CALI'
        ]);
    }
}
