<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SoftwareType;

class SoftwareTypeSeeder extends Seeder
{
    public function run(): void
    {
        SoftwareType::create([
        'typeId'        => 'SO',
        'softwareType'  => 'SISTEMA OPERATIVO'
        ]);

        SoftwareType::create([
        'typeId'        => 'OFFI',
        'softwareType'  => 'OFFICE SUITE'
        ]);
    }
}
