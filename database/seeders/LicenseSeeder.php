<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\License;

class LicenseSeeder extends Seeder
{
    public function run(): void
    {
        License::create([
        'providerId'    => 1,
        'softwareType'  => 'SO',
        'software'      => 'Windows',
        'sofVersion'    => '10 Pro'
        ]);

        License::create([
        'providerId'    => 1,
        'softwareType'  => 'SO',
        'software'      => 'Windows',
        'sofVersion'    => '11 Pro'
        ]);

        License::create([
        'providerId'    => 1,
        'softwareType'  => 'OFFI',
        'software'      => 'Office',
        'sofVersion'    => 'Hogar y Empresas 2007'
        ]);

        License::create([
        'providerId'    => 1,
        'softwareType'  => 'OFFI',
        'software'      => 'Office',
        'sofVersion'    => 'Hogar y Empresas 2010'
        ]);

        License::create([
        'providerId'    => 1,
        'softwareType'  => 'OFFI',
        'software'      => 'Office',
        'sofVersion'    => 'Hogar y Empresas 2013'
        ]);

        License::create([
        'providerId'    => 1,
        'softwareType'  => 'OFFI',
        'software'      => 'Office',
        'sofVersion'    => 'Hogar y Empresas 2016'
        ]);

        License::create([
        'providerId'    => 1,
        'softwareType'  => 'OFFI',
        'software'      => 'Office',
        'sofVersion'    => 'Hogar y Empresas 2019'
        ]);

        License::create([
        'providerId'    => 1,
        'softwareType'  => 'OFFI',
        'software'      => 'Office',
        'sofVersion'    => 'Hogar y Empresas 2021'
        ]);

        License::create([
        'providerId'    => 1,
        'softwareType'  => 'OFFI',
        'software'      => 'Office',
        'sofVersion'    => 'Hogar y Empresas 2024'
        ]);
    }
}
