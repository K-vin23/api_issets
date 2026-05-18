<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class TechnicianUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'cedula'         =>  1192931923,
            'rolId'          =>  'TEC',
            'companyId'      =>  1,
            'firstname'      => 'ANDRES',
            'middlename'     => 'JULIAN',
            'lastname'       => 'FAJARDO',
            's_lastname'     => 'MAZUERA',
            'email'          => 'andresfaj@gmail.com',
            'pw_encrypt'     => 'tec123=',
            'areaId'         => 2,
            'locationId'     => 1,
            'registBy'       => null
        ]);
    }
}
