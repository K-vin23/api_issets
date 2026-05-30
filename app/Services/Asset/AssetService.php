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
use App\Services\Asset\AssetAssignationService;
use App\Services\Asset\AssetDeletionService;
// Utilities
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

class AssetService
{
    public function __construct(protected AssetComponentService $componentService, protected MaintenanceService $maintService, protected AssetAssignationService $assignService, protected AssetDeletionService $deleteService) { 
    }

    public function index(array $filters = [], int $perPage = 15): LengthAwarePaginator {
       return Asset::query()
                ->active('active')
                ->when($filters['companyId'] ?? null, fn($q, $v) => $q->company($v))
                ->when($filters['areaId'] ?? null, fn($q, $v) => $q->area($v))
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
        return Asset::query()
                ->active('inactive')
                ->when($filters['search'] ?? null, function($q, $v){
                        $q->where(function($query) use ($v) {
                            $query->where('internalId', 'ILIKE', "%$v%")
                                ->orWhereHas('assetModels', fn($m) => $m->search($v));
                        });
                    })
                ->with([
                    'latestRemoval',
                    'assetModels',
                    'type'
                ])
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
                'serialNumber'      => $data['serialNumber'],
                'companyId'         => $data['companyId'],
                'typeId'            => $data['categoryId'],
                'invoice'           => $data['invoice'] ?? '',
                'purchaseDate'      => $data['purchaseDate'] ?? now(),
                'internalId'        => $data['internalId'],        
                'areaId'            => $data['areaId'],
                'modelId'           => $data['modelId'],
                'assignedUser'      => null,
                'networkName'       => $data['networkName'] ?? '',
                'nextMaintenance'   => Carbon::parse($data['purchaseDate'])->addMonthsNoOverflow(6),
                'details'           => $data['details'] ?? '',
                'registeredBy'      => $userId,
            ]);

            $asset->refresh();

            //Assign
            if(!empty($data['responsable'])) {
                $this->assignService->assign($asset, $data['responsable'], $userId);
            }

            //Add components
            $this->componentService->addComponents($data, $asset);
        });
    }

    public function update(Asset $asset, array $data, int $userId) {
        DB::transaction(function () use ($asset, $data, $userId) {

            $asset->update([
                'serialNumber'  => $data['serialNumber'] ?? $asset->serialNumber,
                'companyId'     => $data['companyId'] ?? $asset->companyId,
                'typeId'        => $data['categoryId'] ?? $asset->typeId,
                'invoice'       => $data['invoice'] ?? $asset->invoice,
                'purchaseDate'  => $data['purchaseDate'] ?? $asset->purchaseDate,
                'internalId'    => $data['internalId'] ?? $asset->internalId,
                'areaId'        => $data['areaId'] ?? $asset->areaId,
                'modelId'       => $data['modelId'] ?? $asset->modelId,
                'assignedUser'  => $asset->assignedUser,
                'networkName'   => $data['networkName'] ?? $asset->networkName,
                'lastUpdate'    => now()->format('Y-m-d'), 
                'updateBy'      => $userId,
                'details'       => $data['details'] ?? $asset->details,
            ]);

            $asset->refresh();

            if(!empty($data['memories']) || !empty($data['disks'])){
                $mt = $this->maintService->autoMaintenance($asset, $userId);
                //update components 
                $this->componentService->changeComponents($data, $asset, $mt->maintenanceId);
            }
        });
    }

    public function delete(Asset $asset, string $reason, int $userId) {
        if(!empty($reason)){
            $this->deleteService->delete($asset, $reason, $userId);

            $this->assignService->unassign($asset, $userId);
        }
    }

    public function restore(Asset $asset) {
        DB::transaction(function () use ($asset) {
            $asset->update([
                'isActive' => true
            ]);
        });
    }
}
