<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Enums\ProcessManufact;
use App\Models\Processor;

class ProcessorSeeder extends Seeder
{
    public function run(): void
    {
        Processor::create([
            'manufacturer'   => ProcessManufact::IN,
            'processorModel' => 'CORE I5-1235U'
        ]);
    }
}
