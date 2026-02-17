<?php

namespace App\Http\Controllers;

//models
use App\Models\Maintenance;
//requests
use App\Http\Requests\StoreMantenimientoRequest;
use App\Http\Requests\UpdateMantenimientoRequest;
//services
use App\Services\Asset\MaintenanceService;

class MaintenanceController extends Controller
{
    public function __construct(
        protected MaintenanceService $maintenanceService
    )
    {
        $this->middleware('auth:sanctum'); 
    }

    // All maintenances
    public function index(IndexMaintenanceRequest $request) {

        $this->authorize('viewAny', Maintenance::class);

        return response()->json(
            $this->maintenanceService->index($request->validated(), $request->integer('perPage', 15))
        );
    }

    public function store(StoreMaintenanceRequest $request, Maintenance $maintenance) {

        $maintenance = $this->maintenanceService->register(
            $request->validated(),
            $maintenance,
            auth()->id()
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

        return response()->json(
            $this->maintenanceService->getByAsset($asset)
        );
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
