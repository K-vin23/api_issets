<?php

namespace App\Http\Controllers;

// Models
use App\Models\Company;
// Requests
use App\Http\Requests\IndexCompanyRequest;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Http\Requests\RestoreCompanyRequest;
// Services
use App\Services\CompanyService;
// Resources
use App\Http\Resources\CompanyListResource;

class CompanyController extends Controller
{
    public function __construct(protected CompanyService $companyService) {
        $this->middleware('auth:sanctum');
    }

    public function index(IndexCompanyRequest $request) {
        $this->authorize('viewAny', Company::class);

        $comps = $this->companyService->index($request->validated());
        
        return CompanyListResource::collection($comps);
    }

    public function store(StoreCompanyRequest $request) {
        $this->authorize('create', Company::class);

        $this->companyService->create($request->validated());

        return response()->json([
            'message' => 'Empresa creada correctamente'
        ], 201);
    }

    public function update(UpdateCompanyRequest $request, Company $company) {
        $this->authorize('update', $company);

        $company = $this->companyService->update($company, $request->validated());

        return response()->json([
            'message' => 'Empresa actualizada correctamente'
        ], 200);
    }

    public function delete(Company $company) {
        $this->authorize('delete', $company);

        $this->companyService->delete($company, auth()->id());

        return response(201);
    }

    public function restore(RestoreCompanyRequest $request, Company $company) {
        $this->authorize('delete', $company);

        $validated = $request->validated();

        $this->companyService->restore($company, $validated['restoreAll'], auth()->id());

        return response()->json([
            'message'   => 'Empresa restaurada correctamente'
        ], 200);
    }
}
