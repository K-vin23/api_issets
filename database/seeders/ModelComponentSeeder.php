<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ModelComponent;

class ModelComponentSeeder extends Seeder
{
    public function run(): void
    {
        ModelComponent::create([
            'modelId'       => 1,
            'componentId'   => 3
        ]);
    }
}
