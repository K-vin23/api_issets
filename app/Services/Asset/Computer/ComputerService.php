<?php

namespace App\Services\Asset\Computer;

//Models
use App\Models\Computer;
use App\Models\Asset;
use App\Models\User;
use App\Models\Maintenance;
use App\Models\ComputerMemory;
use App\Models\ComputerDisk;
use App\Models\ComputerModelMemory;
use App\Models\ComputerModelDisk;
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
        ->when($filters['modelId'] ?? null, fn($q, $v) => $q->model($v))
        ->when($filters['search'] ?? null, fn($q, $v) => $q->search($v))
        ->with([
            'area',
            'computerModel',
            'computerModel.computerBrand',
            'computerModel.processor',
            'assignedUser',
            'assignedByUser',
            'asset',
            'asset.company',
            'asset.type',
        ])
        ->paginate($perPage);
        
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

            $this->addModelComponents($computerId, $data['modelId']);
        });
    }

    public function createWithAssignment(Asset $asset, array $data, int $assignedUser, int $assignedBy): void
    {
        $computer = $asset->computer;
        $this->create($asset, $data);
        $this->assignService->assignUser($computer, $assignedUser, $assignedBy);
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

            $computer->update([
                'internalId' => $data['internalId'] ?? $computer->internalId,
                'areaId'     => $data['invoice'] ?? $computer->areaId,
                'modelId'    => $data['modelId'] ?? $computer->modelId
            ]);

            if(isset($data['modelId'])) {
                //Delete memorie(s) and disk(s) from the previous model
                $computer->memories()->delete();
                $computer->disks()->delete();
                //Added the components from the right model
                $this->addModelComponents($computer->computerId, $data['modelId']);
            }
        });
    }

    public function addModelComponents(int $computerId, int $modelId)
    {
        $modelMemories = ComputerModelMemory::where('modelId', $modelId)->pluck('memoryId'); //obtain memories of the model

        ComputerMemory::insert(
            $modelMemories->map(fn ($id) => [
                'computerId' => $computerId,
                'memoryId'   => $id
            ])->toArray()
        );
        
        $modelDisks = ComputerModelDisk::where('modelId', $modelId)->pluck('diskId'); //obtain disks of the model

        ComputerDisk::insert(
            $modelDisks->map(fn ($id) =>[
                'computerId' => $computerId,
                'diskId' => $id
            ])->toArray()
        );
    }

    public function delete(Computer $computer, String $reason, int $performedBy): void //Asset is the root, but the user wants to delete the specific asset on frontend through the route 'DELETE asset/computer/{id}', consequently the respective computer controller calls this service and after call the assetDeletion
    {
        $asset = $computer->asset;
        $removed = $this->deleteAssetService->delete($asset, $performedBy); //create history in the service asset
        $this->deleteComputerService->delete($computer, $removed, $reason, $performedBy); //Then, pass to the deletion service and delete computer, then asset

    }

}