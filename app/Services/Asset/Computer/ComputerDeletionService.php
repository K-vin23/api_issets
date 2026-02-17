<?php
namespace App\Services\Asset\Computer;

// Models
use App\Models\Computer;
use App\Models\RemovedComputerHistory;
use App\Models\User;
// Utilities
use Illuminate\Support\Facades\DB;

class ComputerDeletionService
{
    public function delete(Computer $computer, int $removed, string $reason, int $userId): void
    {
        $model = $computer->computerModel;
        $user = User::findOrFail($userId);

        DB::transaction(function () use ($user, $model, $computer, $removed, $reason) {
            RemovedComputerHistory::create([
                'remAssetId'        => $removed,
                'internalId'        => $computer->internalId,
                'brand'             => $model->computerBrand->brand,
                'model'             => $model->modelFamily . ' ' . $model->modelSerie,
                'companyId'         => $computer->company->companyId,
                'companyName'       => $computer->company->company,
                'lastAssignedUser'  => $computer->assignedUser,
                'userName'          => $computer->assignedUser->getFullName,
                'lastUpdate'        => $computer->lastUpdate,
                'removalReason'     => $reason,
                'removedBy'         => $user->userId,
                'remUserName'       => $user->getFullName()
            ]);

            $asset = $computer->asset;

            //delete asset and computer
            $computer->delete();
            $asset->delete();
        });
    }
}
