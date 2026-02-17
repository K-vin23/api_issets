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
            'typeId'    => 'PORT',
            'assetType' => 'PORTATIL'
        ]);

        AssetType::create([
            'typeId'    => 'TORR',
            'assetType' => 'TORRE'
        ]);

        AssetType::create([
            'typeId'    => 'SFF',
            'assetType' => 'MINI-PC'
        ]);
    }
}
