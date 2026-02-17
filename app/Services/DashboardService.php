<?php

namespace App\Services;

// Models
use App\Models\Asset;
use App\Models\User;
use App\Models\Maintenance;
// Utilities
use Illuminate\Support\Facades\DB;


class DashboardService 
{
    public function index (array $filters = []) {
        return [
            'totals'                => $this->totals($filters),
            'upcomingMaintenances'  => $this->upcomingMaintenances($filters),
            'assetsByArea'          => $this->assetByArea($filters), 
        ];
    }

    protected function totals (array $filters): array {
        $assets = Asset::query()
                ->when($filters['companyId'] ?? null, fn($q, $v) => $q->where('companyId', $v))
                ->when($filters['areaId'] ?? null, fn($q, $v) => $q->where('areaId', $v))
                ->count();

        $users = User::query()
                ->when($filters['companyId'] ?? null, fn($q, $v) => $q->where('companyId', $v))
                ->count();

        $maintenances = Maintenance::query()
                        ->count();
        
        return [
            'assets'        => $assets,
            'users'         => $users,
            'maintenances'  => $maintenances,
        ];
    }

    protected function upcomingMaintenances (array $filters) {
        return DB::table('maintenances')
                ->join('assets', 'assets.assetId', '=', 'maintenances.assetId')
                ->join('asset_types', 'asset_types.typeId', '=', 'assets.assetType')
                ->join('computers', 'computers.assetId', '=', 'assets.assetId')
                ->join('computer_models', 'computer_models.modelId', '=', 'computers.modelId')
                ->when($filters['companyId'] ?? null, fn($q, $v) => $q->where('assets.companyId', $v))
                ->whereBetween('maintenances.nextMaintenance', [now(), now()->addDays(30)])
                ->orderBy('maintenances.nextMaintenance')
                ->limit(5)
                ->get([
                    'asset_types.assetType as assetType',
                    DB::raw('computer_models."brandId" || \' \' || computer_models."modelFamily" || \' \' || computer_models."modelSerie"  as model'),
                    'computers.internalId as internalId',
                ]);
    }

    protected function assetByArea(array $filters) {
        return DB::table('computers')
                ->join('areas', 'areas.areaId', '=', 'computers.areaId')
                ->when($filters['companyId'] ?? null, fn($q, $v) => $q->where('computers.companyId', $v))
                ->select(
                    'areas.area as area',
                    DB::raw('COUNT(*) as total')
                )
                ->groupBy('areas.area')
                ->orderBy('total', 'desc')
                ->get();
    }
}
