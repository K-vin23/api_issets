<?php

namespace App\Services\Asset\Computer;

//Models
use App\Models\Computer;
use App\Models\Asset;
use App\Models\User;
use App\Models\Maintenance;
use App\Models\ComputerMemory;
use App\Models\ComputerDisk;
use App\Models\ComputerLicense;
use App\Models\ComputerModelMemory;
use App\Models\ComputerModelDisk;
use App\Models\RemovedAssetHistory;
//Enums
use App\Enums\AssignmentStatus;
//Services
use App\Services\Asset\Computer\ComputerDeletionService;
use App\Services\Asset\AssetDeletionService;
use App\Services\UserComputerAssignService;
//Utilities
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ComputerService 
{
    public function __construct(
        protected AssetDeletionService $deleteAssetService,
        protected ComputerDeletionService $deleteComputerService,
        protected UserComputerAssignService $assignService
    ){}

    public function index(array $filters = [], int $perPage = 15): LengthAwarePaginator {
        //filters
        return Computer::query()
        ->when($filters['companyId'] ?? null, fn($q, $v) => $q->company($v))
        ->when($filters['areaId'] ?? null, fn($q, $v) => $q->area($v))
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
                    ->orWhereHas('computerModel', fn($m) => $m->search($v));
            });
        })
        ->with([
            'computerModel',
            'computerModel.computerBrand',
            'asset.company',
            'asset.type',
        ])
        ->paginate($perPage);
        
    }

    public function show(Computer $computer){
        return $computer->load([
            'area',
            'computerModel',
            'computerModel.computerBrand',
            'computerModel.processor',
            'userAssigned',
            'assignedByUser',
            'asset',
            'asset.company',
            'asset.type',
            'memories.memory',
            'disks.disk',
            'licenses.license'
        ]);
    }

    public function create(Asset $asset, array $data): void {
        DB::transaction(function () use ($asset, $data) {
            $asset->computer()->create([
            'assetId'      => $asset->assetId,
            'internalId'   => $data['internalId'],
            'modelId'      => $data['modelId'],
            'areaId'       => $data['areaId'],
            'assignedUser' => null,
            'assignedBy'   => null
            ]);
            $asset->refresh();

            $computerId = $asset->computer->computerId;

            $this->addModelComponents($computerId, $data['memories'], $data['disks'], $data['licenses']);
        });
    }

    public function createWithAssignment(Asset $asset, array $data, int $assignedBy): void
    {
        $this->create($asset, $data);
        $computer = $asset->computer;
        $this->assignService->assignUser($computer, $data['assignedUser'], $assignedBy);
    }

    public function userComputers(int $userId): Collection {

        return Computer::where('assignedUser', $userId)
            ->with([
                'area',
                'computerModel'
            ])->get();
    }

    public function update(Computer $computer, array $data) : void //falta auditoria
    {
        DB::transaction(function () use ($computer, $data) {

            $computer->load('asset');

            $computer->asset->update([
                'serialNumber'  => $data['serialNumber'] ?? $computer->asset->serialNumber,
                'companyId'     => $data['companyId'] ?? $computer->asset->companyId,
                'invoice'       => $data['invoice'] ?? $computer->asset->invoice,
                'assetType'     => $data['assetType'] ?? $computer->asset->assetType,
                'purchaseDate'  => $data['purchaseDate'] ?? $computer->asset->purchaseDate,
            ]);

            $computer->update([
                'internalId'    => $data['internalId'] ?? $computer->internalId,
                'networkName'   => $data['networkName'] ?? $computer->networkName,
                'areaId'        => $data['areaId'] ?? $computer->areaId,
                'modelId'       => $data['modelId'] ?? $computer->modelId,
            ]);

            $computerId = $computer->computerId;

            if(isset($data['memories']) && !empty($data['memories'])) { 
                ComputerMemory::where('computerId', $computerId)->delete();
                foreach ($data['memories'] as $memory) {
                    ComputerMemory::create([
                        'computerId' => $computer->computerId,
                        'memoryId'   => $memory['id']
                    ]);
                }
            }
            if(isset($data['disks']) && !empty($data['disks'])) {
                ComputerDisk::where('computerId', $computerId)->delete();

                foreach ($data['disks'] as $disk) {
                    ComputerDisk::create([
                        'computerId' => $computer->computerId,
                        'diskId'   => $disk['id']
                    ]);
                }
            }
            if(isset($data['licenses']) && !empty($data['licenses'])) {
                computerLicense::where('computerId', $computerId)->delete();

                foreach ($data['licenses'] as $license) {
                    ComputerLicense::create([
                        'computerId' => $computer->computerId,
                        'licenseId'  => $license['licenseId'],
                        'licenseKey' => $license['licenseKey']
                    ]);
                }
            }
        });
    }

    public function addModelComponents(int $computerId, array $memories, array $disks, array $licenses)
    {
        // Save memories
        if (!empty($memories)) {
            foreach ($memories as $memory) {
                ComputerMemory::create([
                    'computerId' => $computerId,
                    'memoryId'   => $memory['id'],
                ]);
            }
        }

        // Save disks
        if (!empty($disks)) {
            foreach ($disks as $disk) {
                ComputerDisk::create([
                    'computerId' => $computerId,
                    'diskId'     => $disk['id'],
                ]);
            }
        }

        // Save licenses (OFFICE and OS)
        if(!empty($licenses)) {
            foreach ($licenses as $license) {
                ComputerLicense::create([
                    'computerId' => $computerId,
                    'licenseId'  => $license['licenseId'],
                    'licenseKey' => $license['licenseKey']
                ]);
            }
        }
    }

    public function delete(Computer $computer, array $data, int $performedBy): void //Asset is the root, but the user wants to delete the specific asset on frontend through the route 'DELETE asset/computer/{id}', consequently the respective computer controller calls this service and after call the assetDeletion
    {
        $asset = $computer->asset;
        $removed = $this->deleteAssetService->delete($asset, $performedBy); //   [OK]   create history in the service asset
        $this->deleteComputerService->delete($computer, $removed, $data, $performedBy); //Then, pass to the deletion service and delete computer, then asset
        $this->assignService->unassign($computer, $performedBy); // [OK]

    }

    public function removed(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return RemovedAssetHistory::query()
        ->when($filters['search'] ?? null, fn($q, $v) => $q->search($v))
        ->with([
            'removedComputer'
        ])
        ->paginate($perPage);

    }

}