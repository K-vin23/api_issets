<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LicenseProvider;

class ProviderSeeder extends Seeder
{
    public function run(): void
    {
        LicenseProvider::create([
        'provider' => 'MICROSOFT'
        ]);
    }
}
