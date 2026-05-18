<?php

namespace App\Services\Asset\Computer;

// Enums
// use App\Enums\ComponentType;
// Models
use App\Models\Models;
// use App\Models\ComputerModelMemory;
// use App\Models\ComputerModelDisk;
// use App\Models\Memory;
// use App\Models\HardDisk;
use App\Models\Component;
use App\Models\Brand;
use App\Models\License;
// Utilities
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CatalogService 
{
    public function brand() {
        return Brand::all();
    }

    public function processor() {
        return Component::category('PROC')->get();
    }

    public function memory() {
        return Component::category('MEM')->get();
    }

    public function disk() {
        return Component::category('STOR')->get();
    }

    public function license() {
        return License::all();
    }

    public function catalog(array $filters = [], int $perPage = 15): LengthAwarePaginator{
        return Models::query()
        ->when($filters['brandId'] ?? null, fn($q, $v) => $q->brand($v))
        ->when($filters['search'] ?? null, fn($q, $v) => $q->search($v))
        ->with([
            'brands',
            'modelComponents.component'
        ])
        ->paginate($perPage);
    }

    public function create(array $data) {
        return DB::transaction(function () use ($data) {
            ComputerModel::create([
                'brandId'       => $data['brandId'],
                'modelFamily'   => $data['modelFamily'],
                'modelSerie'    => $data['modelSerie'] ?? 'NO SERIE',
                'processorId'   => $data['processorId']
            ]);
        });
    }
}