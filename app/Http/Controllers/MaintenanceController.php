<?php

namespace App\Http\Controllers;

// Models
use App\Models\Maintenance;
use App\Models\Asset;
// Requests
use App\Http\Requests\IndexMaintenanceRequest;
use App\Http\Requests\StoreMaintenanceRequest;
use App\Http\Requests\UpdateMaintenanceRequest;
// Services
use App\Services\Asset\MaintenanceService;
// Resources
use App\Http\Resources\MaintenanceListResource;

class MaintenanceController extends Controller
{
    public function __construct(protected MaintenanceService $maintenanceService) {
        $this->middleware('auth:sanctum'); 
    }

    // All maintenances
    public function index(IndexMaintenanceRequest $request) {

        $this->authorize('viewAny', Maintenance::class);

        return response()->json(
            $this->maintenanceService->index($request->validated(), $request->integer('perPage', 15))
        );
        
    }

    public function store(StoreMaintenanceRequest $request, Asset $asset) {

        $maintenance = $this->maintenanceService->register(
            $asset,
            $request->validated()
        );

        return response()->json([
            'message' => 'Mantenimiento registrado correctamente',
            'data' => $maintenance
        ], 201);
    }

    public function show(Maintenance $maintenance) { //show specific maintenance
        $this->authorize('view', $maintenance);

        return response()->json(
            $maintenance->load('changes.changeType')
        );
    }

    public function showAsset(Asset $asset) { 
        $this->authorize('view', $asset);

        $mnts = $this->maintenanceService->getByAsset($asset);

        return MaintenanceListResource::collection($mnts);
    }

    public function update(UpdateMaintenanceRequest $request, Maintenance $maintenance) { 

        $this->authorize('update', $maintenance);

        $this->maintenanceService->update($maintenance, $request->validated());

        return response()->json([
            'message' => 'Mantenimiento actualizado correctamente'
        ], 200); 
    }

    public function destroy($id_manten) { //Pending
        
    }
}
