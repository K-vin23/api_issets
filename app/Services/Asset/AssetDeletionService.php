<?php
namespace App\Services\Asset;

// Models
use App\Models\Asset;
use App\Models\User;
use App\Models\RemovedAssetHistory;
// Utilities
use Illuminate\Support\Facades\DB;

class AssetDeletionService
{

    public function delete(Asset $asset, int $userId): int {
        $user = User::where('userId', $userId)->first();

        $asset->update([
            'isActive'  => false,
        ]);

        $removed = RemovedAssetHistory::create([
            'assetType'    => $asset->type->assetType,
            'assetId'      => $asset->assetId,
            'serialNumber' => $asset->serialNumber,
            'companyId'    => $asset->companyId,
            'companyName'  => $asset->company->company,
            'removalDate'  => now(),
            'removedBy'    => $userId,
            'remUserName'  => $user->getFullName()
        ]);

        return $removed->removedId;
    }

}