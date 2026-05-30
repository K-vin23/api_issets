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

    public function delete(Asset $asset, string $removal, int $userId) {
        DB::transaction(function () use ($removal, $asset, $userId) {
            $user = User::findOrFail($userId);

            $asset->update([
                'isActive'  => false,
            ]);

            $details = [
                'details'       => $asset->details,
                'networkName'   => $asset->networkName,
                'components'    => $asset->components->map(function ($co) {
                                        $component = $co->component;

                                        return [
                                            'componentId'   => $component->componentId,
                                            'component'     => "{$component->compType?->category?->categoryId} {$component->component_name}"
                                        ];
                                    })
                                    ->values()
                                    ->toArray(),
            ];

            $removed = RemovedAssetHistory::create([
                'assetId'      => $asset->assetId,
                'assetType'    => $asset->type->assetType,
                'serialNumber' => $asset->serialNumber,
                'internalId'   => $asset->internalId,
                'brand'        => $asset->assetModels->brands->brand,
                'model'        => $asset->assetModels->model_name,
                'companyId'    => $asset->companyId,
                'companyName'  => $asset->company->company,
                'lastUser'     => $asset->assignedUser,
                'userName'     => $asset?->assignedTo?->getFullName(),
                'removalReason'=> $removal,
                'removalDate'  => now(),
                'removedBy'    => $userId,
                'remUserName'  => $user->getFullName(),
                'details'      => $details
            ]);
        });
    }
}