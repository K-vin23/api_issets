<?php

namespace App\Services;

// Models
use App\Models\Asset;
use App\Models\User;
use App\Models\Area;
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
                ->when($filters['companyId'] ?? null, fn($q, $v) => $q->company($v))
                ->when($filters['areaId'] ?? null, fn($q, $v) => $q->where('areaId', $v))
                ->when($filters['status'] ?? null, fn($q, $v) => $q->active($v))
                ->count();

        $users = User::query()
                ->when($filters['companyId'] ?? null, fn($q, $v) => $q->where('companyId', $v))
                ->count();

        $maintenances = Maintenance::query()
                        ->count();
        
        // Próximos mantenimientos (todos los pendientes)
        $nextMaintenances = Asset::query()
            ->when($filters['companyId'] ?? null, fn($q, $v) => $q->where('companyId', $v))
            ->when($filters['areaId'] ?? null, fn($q, $v) => $q->where('areaId', $v))
            ->whereNotNull('nextMaintenance')
            ->where('nextMaintenance', '>=', now())
            ->count();

        
        return [
            'assets'            => $assets,
            'users'             => $users,
            'maintenances'      => $maintenances,
            'nextMaintenances'  => $nextMaintenances
        ];
    }

    protected function upcomingMaintenances (array $filters) {
        return DB::table('maintenances')
                ->join('assets', 'assets.assetId', '=', 'maintenances.assetId')
                ->join('asset_types', 'asset_types.typeId', '=', 'assets.typeId')
                ->join('models', 'models.modelId', '=', 'assets.modelId')
                ->when($filters['companyId'] ?? null, fn($q, $v) => $q->where('assets.companyId', $v))
                ->whereBetween('assets.nextMaintenance', [now(), now()->addDays(30)])
                ->orderBy('assets.nextMaintenance')
                ->limit(5)
                ->get([
                    'asset_types.assetType as assetType',
                    DB::raw('models."brandId" || \' \' || models."modelFamily" || \' \' || models."modelSerie"  as model'),
                    'assets.internalId as internalId',
                ]);
    }

    protected function assetByArea(array $filters) {
        return Area::query()
                ->whereHas('assets', function ($q) use ($filters) {
                        $q->when($filters['companyId'] ?? null, fn($q, $v) => $q->company($v))
                          ->when($filters['status'] ?? null, fn($q, $v) => $q->active($v));
                })
                ->select('area')
                ->withCount([
                    'assets as total' => function($q) use ($filters) {
                        $q->when($filters['companyId'] ?? null, fn($q, $v) => $q->company($v))
                          ->when($filters['status'] ?? null, fn($q, $v) => $q->active($v));
                    }
                ])
                ->orderByDesc('total')
                ->get();
        
        // DB::table('assets')
        //         ->join('areas', 'areas.areaId', '=', 'assets.areaId')
        //         ->when($filters['companyId'] ?? null, fn($q, $v) => $q->where('assets.companyId', $v))
        //         ->select(
        //             'areas.area as area',
        //             DB::raw('COUNT(*) as total')
        //         )
        //         ->groupBy('areas.area')
        //         ->orderBy('total', 'desc')
        //         ->get();
    }
}
