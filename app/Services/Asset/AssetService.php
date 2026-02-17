<?php
namespace App\Services\Asset;

// Models
use App\Models\Asset;
// Enums
use App\Enums\AssignmentStatus;
// Services
use App\Services\Asset\Computer\ComputerService;
// Utilities
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AssetService
{
    public function __construct(
        protected ComputerService $computerService,
    ) 
    {}

    public function index(array $filters = [], int $perPage = 15): LengthAwarePaginator {
       return Asset::query()
       ->when($filters['companyId'] ?? null, fn($q, $v) => $q->company($v))
       ->when($filters['assetType'] ?? null, fn($q, $v) => $q->type($v))
       ->when($filter['search'] ?? null, fn($q, $v) => $q->search($v))
       ->with([
            'company',
            'type',
            'registerUser'
       ])
       ->orderBy('serialNumber')
       ->paginate($perPage);
    }

    public function create(array $data, int $userId): Asset
    {
        return DB::transaction(function () use ($data, $userId) {

            $asset = Asset::create([
                'serialNumber'  => $data['serialNumber'],
                'companyId'     => $data['companyId'],
                'assetType'     => $data['assetType'],
                'invoice'       => $data['invoice'] ?? null,
                'purchaseDate'  => $data['purchaseDate'] ?? null,
                'registeredBy'  => $userId,
            ]);

            if ($asset->isComputer()) {
                $computerData = [
                    'internalId' => $data['internalId'],
                    'areaId'     => $data['areaId'],
                    'modelId'    => $data['modelId']
                ];

                if(isset($data['assignedUser'])){
                    $this->computerService->createWithAssignment($asset, $data['assignedUser'], $userId);
                }else{
                    $this->computerService->create($asset, $computerData);
                }
            }

            return $asset;
        });
    }

    public function update(Asset $asset, array $data, int $userId): void
    {
        DB::transaction(function () use ($asset, $data, $userId) {

            $asset->update([
                'serialNumber' => $data['serialNumber'] ?? $asset->serialNumber,
                'invoice'       => $data['invoice'] ?? $asset->invoice,
                'companyId'    => $data['companyId'] ?? $asset->companyId,
                'assetType'    => $data['assetType'] ?? $asset->assetType,
                'purchaseDate' => $data['purchaseDate'] ?? $asset->purchaseDate,
                'registeredBy'    => $userId,
            ]);
        });
    }
}
