<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AssetComponent;

class AssetComponentSeeder extends Seeder
{
    public function run(): void
    {
       AssetComponent::create([
            'assetId'       => 1,
            'componentId'   => 1

        ]);

        AssetComponent::create([
            'assetId'       => 1,
            'componentId'   => 2

        ]);

        AssetComponent::create([
            'assetId'       => 1,
            'componentId'   => 3

        ]);
        
    }
}
