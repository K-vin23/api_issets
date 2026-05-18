<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AssetType;

class AssetTypeSeeder extends Seeder
{
    public function run(): void
    {
        AssetType::create([
            'typeId'    => 'LAP',
            'assetType' => 'LAPTOP'
        ]);

        AssetType::create([
            'typeId'    => 'SFF',
            'assetType' => 'MINI-PC'
        ]);

        AssetType::create([
            'typeId'    => 'TORR',
            'assetType' => 'TORRE'
        ]);

        AssetType:: create([
            'typeId'    => 'MON',
            'assetType' => 'MONITOR'
        ]);

        AssetType:: create([
            'typeId'    => 'UPS',
            'assetType' => 'UPS'
        ]);

    }
}
