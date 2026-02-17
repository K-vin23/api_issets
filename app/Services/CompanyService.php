<?php

namespace App\Services;

// Models
use App\Models\Company;
use App\Models\Location;
// Utilities
use Illuminate\Support\Facades\DB;

class CompanyService 
{
    public function index() {
        return Company::orderBy('companyId', 'asc')
                ->get();
    }

    public function create(array $data): Company {
        return DB::transaction(function () use ($data) {
            return Company::create([
                'company' => $data['company']
            ]);
        });
    }

    public function update(Company $company, array $companyName): Company {
        DB::transaction(function () use ($company, $companyName) {
            $company->update([
                'company' => $companyName['company']
            ]);
        });

        return $company->refresh();
    }

    public function delete(Company $company) {
        // Pending
    }

    public function locations(Company $company) {
        return Location::where('companyId', $company->companyId)
                ->with([
                    'company',
                    'city'
                ])->get();
    }

    public function newLocation(Company $company, array $data): Location {
        return DB::transaction(function () use ($data, $company) {
            return Location::create([
                'companyId'     =>  $company->companyId,
                'cityId'        =>  $data['cityId'],
                'locationName'  =>  $data['locationName']
            ]);
        });
    }

    public function updateLocation(Location $location, array $data) {
        DB::transaction(function () use ($location, $data) {
            $location->update([
                'companyId'     => $data['companyId'] ?? $location->companyId,
                'cityId'        => $data['cityId'] ?? $location->cityId,
                'locationName'  => $data['locationName'] ?? $location->locationName
            ]);
        });

        return $location->refresh()->load(['company', 'city']);
    }
}