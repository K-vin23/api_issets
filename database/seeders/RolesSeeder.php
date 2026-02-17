<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rol;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        Rol::create([
            'rolId' => 'PER',
            'rol'   => 'PERSONAL'
        ]);

        Rol::create([
            'rolId' => 'TEC',
            'rol'   => 'TECNICO'
        ]);

        Rol::create([
            'rolId' => 'ADM',
            'rol'   => 'ADMIN'
        ]);
        
    }
}
