<?php
namespace App\Services\Asset;

use App\Models\Asset;
use App\Models\RemovedAssetHistory;
use Illuminate\Support\Facades\DB;

class AssetDeletionService
{

    public function delete(Asset $asset, int $userId): int {
        $removed = RemovedAssetHistory::create([
            'assetType'    => $asset->assetType->assetType,
            'serialNumber' => $asset->serialNumber,
            'companyId'    => $asset->companyId,
            'companyName'  => $asset->company->company,
            'removalDate'  => now(),
            'removedBy'    => $userId,
        ]);

        return $removed->removedId;
    }

}