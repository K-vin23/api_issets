<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ComponentCategory;

class ComponentCategorySeeder extends Seeder
{
    public function run(): void
    {
        ComponentCategory::create([
        'categoryId'    => 'MEM',
        'category'      => 'MEMORY'
        ]);

        ComponentCategory::create([
        'categoryId'    => 'STOR',
        'category'      => 'STORAGE'
        ]);

        ComponentCategory::create([
        'categoryId'    => 'PROC',
        'category'      => 'PROCESSOR'
        ]);
    }
}
