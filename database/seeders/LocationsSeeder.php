<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationsSeeder extends Seeder
{
    public function run(): void
    {
        Location::create([
            'companyId'     => 1,
            'cityId'        => 'CALI',
            'locationName'  => 'PRINCIPAL'
        ]);
    }
}
