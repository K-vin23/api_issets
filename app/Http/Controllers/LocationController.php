<?php

namespace App\Http\Controllers;

// Models
use App\Models\Location;
use App\Models\Company;
// Requests
use App\Http\Requests\IndexLocationRequest;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
// Services
use App\Services\CompanyService;

class LocationController extends Controller
{
    public function __construct(
        protected CompanyService $companyService
    )
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Company $company, IndexLocationRequest $request) {

        $this->authorize('viewAny', $company);

        $locations = $this->companyService->locations($company, $request->validated());

        return response()->json([
            'data' => $locations
        ], 200);
    }

    public function store(StoreLocationRequest $request, Company $company) {

        $this->authorize('create', $company);

        $this->companyService->newLocation($company, $request->validated());

        return response()->json([
            'message' => "localizacion creada correctamente" 
        ], 201);
    }

    public function update(UpdateLocationRequest $request, Location $location) {
        
        $this->authorize('update', $location->company);

        $this->companyService->updateLocation($location, $request->validated());

        return response()->json([
            'message' => "localizacion actualizada correctamente"
        ], 200);
    }

    public function delete() {
        // Pending
    }
}
