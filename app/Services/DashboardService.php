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

    public function upcomingMaintenances (array $filters = []) {
        $days = $filters['maintenanceDays'] ?? 30;
        return Asset::query()
                ->active('active')
                ->when($filters['companyId'] ?? null, fn($q, $v) => $q->company($v))
                ->whereBetween('nextMaintenance', [now(), now()->addDays($days)])
                ->whereNotNull('nextMaintenance')
                ->orderBy('nextMaintenance')
                ->limit(5)
                ->with([
                    'assetModels.brands'
                ])
                ->get();
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
                        ->when($filters['companyId'] ?? null, fn($q, $v) => $q->company($v))
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
