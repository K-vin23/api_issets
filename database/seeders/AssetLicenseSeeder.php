<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AssetLicense;

class AssetLicenseSeeder extends Seeder
{
    public function run(): void
    {
        AssetLicense::create([
            'assetId'       => 1,
            'licenseId'     => 2,
            'licenseKey'    => 'W269N-WFGWX-YVC9B-4J6C9-T83GX'
        ]);
        
        AssetLicense::create([
            'assetId'       => 1,
            'licenseId'     => 8,
            'licenseKey'    => 'AD3XE-7FZDV-VMMB9-6M5SD-VODYF'
        ]);

        AssetLicense::create([
            'assetId'       => 1,
            'licenseId'     => 1,
            'licenseKey'    => 'RHGJR-N7FVY-Q3B8F-KBQ6V-46YP4'
        ]);

        AssetLicense::create([
            'assetId'       => 1,
            'licenseId'     => 9,
            'licenseKey'    => '366NX-BQ62X-PQT9G-GPX4H-VT7TX'
        ]);
    }
}
