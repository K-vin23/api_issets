<?php

namespace App\Services;

// Models
use App\Models\Company;
use App\Models\Location;
use App\Models\User;
use App\Models\Asset;
// Services
use App\Services\Asset\AssetService;
// Utilities
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CompanyService 
{
    public function __construct(protected AssetService $assetService, ) {
    }

    public function index(array $filters = [], int $perPage = 10): LengthAwarePaginator {

        //optional filters w/ scopes in the model
        return Company::query()
                ->when($filters['status'] ?? null, fn($q, $v) => $q->active($v))
                ->when($filters['search'] ?? null, fn($q, $v) => $q->search($v))
                ->when($filters['city'] ?? null, fn($q, $v) => $q->principalLocation($v))
                ->orderBy('companyId', 'asc')
                ->paginate($perPage);
    }

    public function create(array $data) {
        return DB::transaction(function () use ($data) {
            $company = Company::create([
                            'company' => $data['company'],
                        ]);
            $loc = [
                'cityId'        => $data['cityId'],
                'locationName'  => "PRINCIPAL"
            ];

            $this->newLocation($company, $loc);
        });
    }

    public function update(Company $company, array $data): Company {
        DB::transaction(function () use ($company, $data) {
            $company->update([
                'company' => $data['company']
            ]);
        });

        return $company->refresh();
    }

    public function delete(Company $company, $performedBy) {
        DB::transaction(function () use ($company, $performedBy) {
            // Searchs
            $user = User::findOrFail($performedBy);
            $assets = Asset::where('companyId', $company->companyId)->get();

            // Actions
            $company->update([
                'isActive'  => false
            ]);
            
            // Automatic Reason for removal assets
            $removal = "Inhabilitación de empresa, realizada por ".$user->getFullName();
            
            foreach ($assets as $asset) {
                $this->assetService->delete($asset, $removal, $performedBy);
            }
        });
    }

    public function restore(Company $company, bool $restore, int $performedBy) {
        DB::transaction(function () use ($company, $restore, $performedBy) {
            $company->update([
                'isActive'  => true
            ]);

            if($restore){
                $assets = Asset::where('companyId', $company->companyId)->get();

                foreach ($assets as $asset) {
                    $this->assetService->restore($asset, $performedBy);
                }
            }
        });
    }

    public function locations(Company $company, array $filetrs = []) {
        return Location::query()
                ->when($filters['cityId'] ?? null, fn($q, $v) => $q->city($v))
                ->where('companyId', $company->companyId)
                ->with([
                    'city'
                ])->get();
    }

    public function newLocation(Company $company, array $data){
        $location = new Location();
        $location->companyId = $company->companyId;
        $location->cityId =  $data['cityId'];
        $location->locationName = $data['locationName'];
        $location->save();
    }

    public function updateLocation(Location $location, array $data) {
        DB::transaction(function () use ($location, $data) {
            $location->update([
                'companyId'     => $data['companyId'] ?? $location->companyId,
                'cityId'        => $data['cityId'] ?? $location->cityId,
                'locationName'  => $data['locationName'] ?? $location->locationName
            ]);
        });
    }
}