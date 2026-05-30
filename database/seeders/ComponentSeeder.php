<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Component;
use App\Enums\ComponentType;
use App\Enums\TechnologyType;

class ComponentSeeder extends Seeder
{
    public function run(): void
    {
        Component::create([
        'ctypeId'   => 1,
        'component' => '8GB'
        ]);

        Component::create([
        'ctypeId'   => 3,
        'component' => '8GB'
        ]);

        Component::create([
        'ctypeId'   => 6,
        'component' => '256GB'
        ]);

        Component::create([
        'ctypeId'   => 9,
        'component' => 'CORE I5 1235U'
        ]);

        Component::create([
        'ctypeId'   => 9,
        'component' => 'CORE I5 7500'
        ]);
    }
}
