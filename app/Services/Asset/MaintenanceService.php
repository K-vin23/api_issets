<?php
namespace App\Services\Asset;

// Models
use App\Models\Asset;
use App\Models\Maintenance;
// Services
use App\Services\Asset\Computer\Descriptions\ChangeDescriptionBuilder;
use App\Services\Asset\Computer\Contracts\ChangeHandlerFactory;
// Utilities
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class MaintenanceService
{
    public function index(array $filters = [], int $perPage = 15): LengthAwarePaginator {
        return Maintenance::query()
        ->when($filter['typeId'] ?? null, fn($q, $v) => $q->type($v))
        ->when($filters['date'] ?? null, fn ($q, $v) => $q->date($v))
        ->when(
            isset($filters['from'], $filters['to']),
            fn ($q) => $q->dateBetween($filters['from'], $filters['to'])
        );
    }

    public function getByAsset(Asset $asset) {
        return $asset->maintenance()
                ->with(['maintenanceType', 'technician'])
                ->latest('date')
                ->get();
    }

    public function register(Asset $asset, array $data, int $userId): Maintenance
    {
        return DB::transaction(function () use ($asset, $data, $userId) {

            $maintenance = Maintenance::create([
                'assetId'           => $asset->id,
                'typeId'            => $data['type_id'],
                'maintenanceDate'    => Carbon::parse($data['maintenanceDate']) ?? now(),
                'nextMaintenance'    => $data['nextMaintenance'] ?? Carbon::parse($data['maintenanceDate'])->addMonthsNoOverflow(6),
                'tecId'              => $userId,
                'observations'       => $data['observations']
            ]);

            if (!empty($data['changes']) && $asset->isComputer()) {
                foreach ($data['changes'] as $change) {

                    $changeType = ChangeType::findOrFail($change['ChangeTypeId']); // Fetch change type details

                    $handler = ChangeHandlerFactory::make($changeType->component);
                    $handler->handle($asset, $changeType, $change);

                    $this->logChange($asset, $maintenance, $changeType, $change);
                }
            }

            return $maintenance;
        });
    }

    public function logChange(Asset $asset, Maintenance $maintenance, ChangeType $changeType, Array $change): void {
            $maintenance->changes()->create([
                    'assetId'       => $asset->assetId,
                    'maintenanceId' => $maintenance->maintenanceId,
                    'changeTypeId'  => $changeType->changeTypeId,
                    'description'   => ChangeDescriptionBuilder::build($changeType, $change),
                    'changeDate'    => now()
            ]);
    }

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

