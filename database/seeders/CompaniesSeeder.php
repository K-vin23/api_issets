<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;

class CompaniesSeeder extends Seeder
{

    public function run(): void
    {
        Company::create([
            'company' => 'WFM Informatica & Tecnologia',
        ]);
    }
}
