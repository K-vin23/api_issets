<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Asset;

class AssetSeeder extends Seeder
{

    public function run(): void
    {
        Asset::create([
            'companyId'     => 1,
            'areaId'        => 1,
            'typeId'        => 'LAP',
            'modelId'       => 1,
            'serialNumber'  => 'AS278APS3',
            'internalId'    => 'LAP-001',
            'invoice'       => 'FV-0012',
            'purchaseDate'  => '2026-05-17',
            'networkName'   => 'CALSIS-1',
            'assignedUser'  => 1,
            'details'       => '',
            'isActive'      => true,
            'nextMaintenance'   => '2026-11-17',
            'registeredBy'  => 1,
        ]);
    }
}
