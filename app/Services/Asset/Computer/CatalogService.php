<?php

namespace App\Services\Asset\Computer;

// Models
use App\Models\ComputerModel;
use App\Models\ComputerModelMemory;
use App\Models\ComputerModelDisk;
use App\Models\Memory;
use App\Models\HardDisk;
use App\Models\Processor;
use App\Models\ComputerBrand;
use App\Models\License;
// Utilities
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CatalogService 
{
    public function brand() {
        return ComputerBrand::all();
    }

    public function processor() {
        return Processor::all();
    }

    public function memory() {
        return Memory::all();
    }

    public function disk() {
        return HardDisk::all();
    }

    public function license() {
        return License::all();
    }

    public function catalog(array $filters = [], int $perPage = 15): LengthAwarePaginator{
        return ComputerModel::query()
        ->when($filters['brandId'] ?? null, fn($q, $v) => $q->brand($v))
        ->when($filters['search'] ?? null, fn($q, $v) => $q->search($v))
        ->with([
            'computerBrand',
            'processor'
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