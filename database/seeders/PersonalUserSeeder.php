<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class PersonalUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'userId'         =>  1193228979,
            'rolId'          =>  'ADM',
            'companyId'      =>  1,
            'firstname'      => 'KEVIN',
            'middlename'     => 'ISMAEL',
            'lastname'       => 'ZAMORA',
            's_lastname'     => 'ALVAREZ',
            'email'          => 'kevinismaelz@gmail.com',
            'pw_encrypt'     => 'admin123=',
            'areaId'         => 1,
            'locationId'     => 1,
            'registBy'       => null
        ]);
    }
}
