<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Enums\MemoryType;
use App\Models\Memory;

class MemorySeeder extends Seeder
{

    public function run(): void
    {
        Memory::create([
            'memorytype'    => MemoryType::D4,
            'gbCapacity'    => 4,
        ]);

        Memory::create([
            'memorytype'    => MemoryType::D4,
            'gbCapacity'    => 8,
        ]);
    }
}
