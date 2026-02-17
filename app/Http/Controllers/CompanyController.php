<?php

namespace App\Http\Controllers;

// Models
use App\Models\Company;
// Requests
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
// Services
use App\Services\CompanyService;

class CompanyController extends Controller
{
    public function __construct(
        protected CompanyService $companyService
    )
    {
        $this->middleware('auth:sanctum');
    }

    public function index() {
        $this->authorize('viewAny', Company::class);
        
        return response()->json(
            $this->companyService->index()
        );
    }

    public function store(StoreCompanyRequest $request) {
        $this->authorize('create', Company::class);

        $company = $this->companyService->create($request->validated());

        return response()->json([
            'message' => 'Empresa creada correctamente',
            'data' => $company
        ], 201);
    }

    public function update(UpdateCompanyRequest $request, Company $company) {
        $this->authorize('update', $company);

        $company = $this->companyService->update($company, $request->validated());

        return response()->json([
            'message' => 'Empresa actualizada correctamente',
            'data' => $company
        ], 201);
    }

    public function delete(Company $company) {
        $this->authorize('delete', $company);

        $this->companyService->delete($company);

        return response()->json([
            'message' => 'Empresa eliminada correctamente'
        ], 201);
    }
}
