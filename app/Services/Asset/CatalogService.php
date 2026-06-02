<?php

namespace App\Services\Asset;

// Enums
// use App\Enums\ComponentType;
// Models
use App\Models\Models;
use App\Models\Component;
use App\Models\ModelComponent;
use App\Models\Brand;
use App\Models\License;
use App\Models\AssetType;
use App\Models\ComponentCategory;
use App\Models\ComponentType;
// Utilities
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CatalogService 
{
    public function types() {
        return AssetType::all();
    }

    public function brand() {
        return Brand::all();
    }

    public function componentCategories() {
        return ComponentCategory::all();
    }

    public function componentTypes() {
        return ComponentType::all();
    }

    public function components() {
        return Component::all();
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

    public function assignComponent(Models $models, array $data) {
        DB::transaction(function () use ($models, $data) {
            ModelComponent::create([
                'modelId'       => $models->modelId,
                'componentId'   => $data['componentId']
            ]);
        });
    }

    public function createModel(array $data) {
        DB::transaction(function () use ($data) {
            $model = strtoupper(trim($data['model']));

            preg_match('/^([A-Z]+)\s*([0-9].*)$/i', $model, $matches);

            $model = Models::create([
                'brandId'       => $data['brandId'],
                'typeId'        => $data['typeId'],
                'modelFamily'   => $matches[1] ?? $data['model'],
                'modelSerie'    => $matches[2] ?? 'NO SERIE'
            ]);
        });
    }

    public function createComponent(array $data) {
        return DB::transaction(function () use ($data) {
            Component::create([
                'ctypeId'     => $data['ctypeId'],
                'component'   => strtoupper($data['component'])      
            ]);
        });
    }

    public function createBrand(array $data) {
        return DB::transaction(function () use ($data) {
            $brandId = strtoupper(substr($data['brand'], 0, 4));
            Brand::create([
                'brandId'   => $brandId,
                'brand'     => strtoupper($data['brand'])          
            ]);
        });
    }
}