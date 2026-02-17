<?php

namespace App\Http\Controllers;

// Models
use App\Models\Asset;
// Requests
use App\Http\Requests\IndexDashboardRequest;
// Services
use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService
    )
    {
        $this->middleware('auth:sanctum');
    }

    public function index(IndexDashboardRequest $request) {
        $this->authorize('viewAny', Asset::class);

        return response()->json(
            $this->dashboardService->index($request->validated())
        );
    }

    // public function activos(Request $request)
    // {
    //     $company = $request->query('id_empresa');
    //     $area = $request->query('id_area');

    //     $query = Activo::query();

    //     if($company) {
    //         $query->where('id_empresa', $company);
    //     }

    //     if($area) {
    //         $query->where('id_area', $area);
    //     }

    //     return response()->json([
    //         'total' => $query->count(),
    //         'byCompany' => Activo::select('id_empresa')
    //             ->selectRaw('COUNT(*) AS total')
    //             ->groupBy('id_empresa')
    //             ->get(),
    //         'byArea' => Activo::select('id_area')
    //             ->selectRaw('COUNT(*) AS total')
    //             ->groupBy('id_area')
    //             ->get(),
    //     ]);
    // }
}
