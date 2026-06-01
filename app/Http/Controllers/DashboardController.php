<?php

namespace App\Http\Controllers;

// Models
use App\Models\Asset;
// Requests
use App\Http\Requests\IndexDashboardRequest;
// Services
use App\Services\DashboardService;
// Resources
use App\Http\Resources\DashboardResource;
use App\Http\Resources\UpcomingMaintenanceResource;

class DashboardController extends Controller
{
    public function __construct(protected DashboardService $dashboardService) {
        $this->middleware('auth:sanctum');
    }

    public function index(IndexDashboardRequest $request) {
        $this->authorize('viewAny', Asset::class);

        $dash = $this->dashboardService->index($request->validated());

        return new DashboardResource($dash);
    }

    public function upcomings(IndexDashboardRequest $request) {
        $this->authorize('viewAny', Asset::class);

        $dash = $this->dashboardService->upcomingMaintenances($request->validated());

        return UpcomingMaintenanceResource::collection($dash);
    }
    
}
