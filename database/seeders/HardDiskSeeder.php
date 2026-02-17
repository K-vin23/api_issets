<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Enums\DiskType;
use App\Models\HardDisk;

class HardDiskSeeder extends Seeder
{
    public function run(): void
    {
        HardDisk::create([
            'disktype'      => DiskType::M2,
            'gbCapacity'    => 512
        ]);
    }
}
