<?php

namespace App\Http\Controllers;

// Models
use App\Models\Location;
use App\Models\Company;
// Requests
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

    public function index(Company $company) {

        $this->authorize('viewAny', $company);

        $locations = $this->companyService->locations($company);

        return response()->json([
            'data' => $locations
        ]);
    }

    public function store(StoreLocationRequest $request, Company $company) {

        $this->authorize('create', $company);

        $location = $this->companyService->newLocation($company, $request->validated());

        return response()->json([
            'data' => $location
        ]);
    }

    public function update(UpdateLocationRequest $request, Location $location) {
        
        $this->authorize('update', $location->company);

        $location = $this->companyService->updateLocation($location, $request->validated());

        return response()->json([
            'data' => $location
        ]);
    }

    public function delete() {
        // Pending
    }
}
