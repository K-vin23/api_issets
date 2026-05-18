<?php
namespace App\Services\Asset\Computer;

// Models
use App\Models\Computer;
use App\Models\RemovedComputerHistory;
use App\Models\User;
use App\Models\ComputerMemory;
use App\Models\ComputerDisk;
use App\Models\ComputerLicense;
// Utilities
use Illuminate\Support\Facades\DB;

class ComputerDeletionService
{
    public function delete(Computer $computer, int $removed, array $data, int $userId): void
    {
        $model = $computer->computerModel;
        $user = User::findOrFail($userId);

        DB::transaction(function () use ($user, $model, $computer, $removed, $data) {
            // Inactive computer

            $computer->update([
                'isActive'  => false,
            ]);

            // Create register
            RemovedComputerHistory::create([
                'remAssetId'        => $removed,
                'internalId'        => $computer->internalId,
                'brand'             => $model->computerBrand->brand,
                'model'             => $model->modelFamily . ' ' . $model->modelSerie,
                'companyId'         => $computer->company->companyId,
                'companyName'       => $computer->company->company,
                'lastAssignedUser'  => $computer->assignedUser,
                'userName'          => $computer->userAssigned->getFullName() ?? 'No asignado',
                'lastUpdate'        => $computer->lastUpdate,
                'removalReason'     => $data['removalReason'],
                'removedBy'         => $user->userId,
                'remUserName'       => $user->getFullName(),
            ]);            
        });
    }
}
