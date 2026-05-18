<?php
namespace App\Services\Asset;

// Models
use App\Models\Asset;
use App\Models\RemovedAssetHistory;
// Enums
use App\Enums\AssignmentStatus;
// Services
use App\Services\Asset\AssetComponentService;
use App\Services\Asset\MaintenanceService;
// Utilities
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AssetService
{
    public function __construct(protected AssetComponentService $componentService, protected MaintenanceService $maintService) { 
    }

    public function index(array $filters = [], int $perPage = 15): LengthAwarePaginator {
       return Asset::query()
       ->when($filters['companyId'] ?? null, fn($q, $v) => $q->company($v))
       ->when($filters['typeId'] ?? null, fn($q, $v) => $q->type($v))
       ->when($filters['status'] ?? null, function($q, $v) {
            if($v === 'Asignado') {
                $q->whereNotNull('assignedUser');
            }
            if($v === 'Almacen') {
                $q->whereNull('assignedUser');
            }
        })
       ->when($filters['search'] ?? null, function($q, $v){
            $q->where(function($query) use ($v) {
                $query->where('internalId', 'ILIKE', "%$v%")
                    ->orWhereHas('assetModels', fn($m) => $m->search($v));
            });
        })
       ->with([
            'company',
            'type',
            'assetModels'
       ])
       ->orderBy('internalId')
       ->paginate($perPage);
    }

    public function removed(array $filters = [], int $perPage = 15): LengthAwarePaginator {
        return RemovedAssetHistory::query()
        ->when($filters['search'] ?? null, fn($q, $v) => $q->search($v))
        ->paginate($perPage);
    }

    public function show(Asset $asset){
        return $asset->load([
            'company',
            'area',
            'assetModels',
            'assetModels.modelComponents.component',
            'components',
            'type',
            'assignedTo'
        ]);
    }

    public function myAssets(int $userId): Collection {

        return Asset::where('assignedUser', $userId)
            ->with([
                'area',
                'assetModels'
            ])->get();
    }

    public function create(array $data, int $userId) {
        return DB::transaction(function () use ($data, $userId) {

            //CREATE ASSET
            $asset = Asset::create([
                'companyId'     => $data['companyId'],
                'areaId'        => $data['areaId'],
                'typeId'        => $data['typeId'],
                'modelId'       => $data['modelId'],
                'serialNumber'  => $data['serialNumber'],
                'internalId'    => $data['internalId'],        
                'invoice'       => $data['invoice'] ?? null,
                'purchaseDate'  => $data['purchaseDate'] ?? null,
                'networkName'   => $data['networkName'],
                'assignedUser'  => $data['assignedUser'] ?? null,
                'details'       => $data['details'] ?? null,
                'registeredBy'  => $userId,
            ]);

            $asset->refresh();

            //Add components
            $this->componentService->addComponents($data, $asset);
        });
    }

    public function update(Asset $asset, array $data, int $userId) {
        DB::transaction(function () use ($asset, $data, $userId) {

            $asset->update([
                'serialNumber' => $data['serialNumber'] ?? $asset->serialNumber,
                'invoice'       => $data['invoice'] ?? $asset->invoice,
                'companyId'    => $data['companyId'] ?? $asset->companyId,
                'assetType'    => $data['assetType'] ?? $asset->assetType,
                'purchaseDate' => $data['purchaseDate'] ?? $asset->purchaseDate,
                'registeredBy'    => $userId,
            ]);

            if(!empty($data['memories']) || !empty($data['disks'])){
                $mt = $maintService->autoMaintenance($asset, $userId);

                //update components 
                $this->componentService->changeComponents($data, $asset, $mt->maintenanceId);
            }
        });
    }
}
