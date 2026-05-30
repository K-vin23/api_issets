<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Asset;
use Carbon\Carbon;

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
            'nextMaintenance'   => Carbon::parse('2026-11-17')->addMonthsNoOverflow(6),
            'registeredBy'  => 1,
        ]);

        Asset::create([
            'companyId'     => 1,
            'areaId'        => 1,
            'typeId'        => 'MON',
            'modelId'       => 2,
            'serialNumber'  => 'MO123A0S1',
            'internalId'    => 'MON-001',
            'invoice'       => 'FV-0013',
            'purchaseDate'  => '2026-05-25',
            'networkName'   => '',
            'assignedUser'  => 2,
            'details'       => 'Monitor IPS de 24 pulgadas',
            'isActive'      => true,
            'nextMaintenance'   => Carbon::parse('2026-05-25')->addMonthsNoOverflow(6),
            'registeredBy'  => 1,
        ]);

        Asset::create([
            'companyId'     => 1,
            'areaId'        => 2,
            'typeId'        => 'MON',
            'modelId'       => 2,
            'serialNumber'  => 'AS348X3DF',
            'internalId'    => 'MON-002',
            'invoice'       => 'FE-10180',
            'purchaseDate'  => '2026-05-28',
            'networkName'   => '',
            'assignedUser'  => 1,
            'details'       => 'Monitor IPS de 24 pulgadas',
            'isActive'      => true,
            'nextMaintenance'   => Carbon::parse('2026-05-28')->addMonthsNoOverflow(6),
            'registeredBy'  => 1,
        ]);

        Asset::create([
            'companyId'     => 2,
            'areaId'        => 1,
            'typeId'        => 'UPS',
            'modelId'       => 3,
            'serialNumber'  => 'UPSA12S03',
            'internalId'    => 'UPS-001',
            'invoice'       => 'FV-0014',
            'purchaseDate'  => '2026-05-12',
            'networkName'   => '',
            'assignedUser'  => 2,
            'details'       => 'UPS de 3000 V',
            'isActive'      => true,
            'nextMaintenance'   => Carbon::parse('2026-05-12')->addMonthsNoOverflow(6),
            'registeredBy'  => 1,
        ]);

        Asset::create([
            'companyId'     => 2,
            'areaId'        => 2,
            'typeId'        => 'SFF',
            'modelId'       => 4,
            'serialNumber'  => 'UTJMYG2DK5',
            'internalId'    => 'SFF-001',
            'invoice'       => 'FE-10100',
            'purchaseDate'  => '2026-05-05',
            'networkName'   => 'VENTAS01',
            'assignedUser'  => 2,
            'isActive'      => true,
            'nextMaintenance'   => Carbon::parse('2026-05-05')->addMonthsNoOverflow(6),
            'registeredBy'  => 1,
        ]);
    }
}
