<?php
namespace App\Services\Asset;

// Enums
use App\Enums\MaintenanceType;
// Models
use App\Models\Asset;
use App\Models\Maintenance;
// Utilities
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

class MaintenanceService
{
    public function getByAsset(Asset $asset, int $perPage = 3): LengthAwarePaginator {
        return $asset->maintenance()
                ->with(['technician'])
                ->latest('maintenanceDate')
                ->paginate($perPage);
    }

    public function register(Asset $asset, array $data): Maintenance{
        return DB::transaction(function () use ($asset, $data) {

            $maintenance = Maintenance::create([
                'assetId'           => $asset->assetId,
                'type'              => $data['type'] ?? MaintenanceType::CORR,
                'maintenanceDate'   => $data['maintenanceDate'] ?? now()->format('Y-m-d'),
                'tecId'             => $data['tecId'],
                'observations'      => $data['description']
            ]);

            // if (!empty($data['changes']) && $asset->isComputer()) {
            //     foreach ($data['changes'] as $change) {

            //         $changeType = ChangeType::findOrFail($change['ChangeTypeId']); // Fetch change type details

            //         $handler = ChangeHandlerFactory::make($changeType->component);
            //         $handler->handle($asset, $changeType, $change);

            //         $this->logChange($asset, $maintenance, $changeType, $change);
            //     }
            // }

            return $maintenance;
        });
    }

    public function autoMaintenance(Asset $asset, int $userId): Maintenance { // Automatic maintenance for change components in edit form
        return DB::transaction(function () use ($asset, $userId) {
            $maintenance = Maintenance::create([
                'assetId'           => $asset->assetId,
                'type'              => MaintenanceType::CORR,
                'maintenanceDate'   => now(),
                'tecId'             => $userId,
                'observations'      => 'Actualización automática de componentes por medio de edición de activo'
            ]);

            return $maintenance;
        });
    }

    // public function logChange(Asset $asset, Maintenance $maintenance, ChangeType $changeType, Array $change): void {
    //         $maintenance->changes()->create([
    //                 'assetId'       => $asset->assetId,
    //                 'maintenanceId' => $maintenance->maintenanceId,
    //                 'changeTypeId'  => $changeType->changeTypeId,
    //                 'description'   => ChangeDescriptionBuilder::build($changeType, $change),
    //                 'changeDate'    => now()
    //         ]);
    // }

    public function update(Maintenance $maintenance, array $data) {
        
        DB::transaction(function () use ($maintenance, $data) {
            $maintenance->update([
                'typeId'            => $data['typeId'] ?? $maintenance->typeId,
                'maintenanceDate'   => $data['maintenanceDate'] ?? $maintenance->maintenanceDate,
                'nextMaintenance'   => $data['nextMaintenance'] ?? $maintenance->nextMaintenance,
                'tecId'             => $data['tecId'] ?? $maintenance->tecId,
                'observations'      => $data['observations'] ?? $maintenance->observations
            ]);
        });
    }
}

