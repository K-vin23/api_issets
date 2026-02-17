<?php

namespace App\Services\Asset\Computer\Changes;

use App\Models\Asset;
use App\Models\ChangeType;
use App\Models\ComputerDisk;
use App\Enums\ChangeAction;
use App\Services\Asset\Computer\Changes\Contracts\ChangeHandlerInterface;

class DiskChangeHandler implements ChangeHandlerInterface
{
    public function handle(Asset $asset, ChangeType $changeType, array $change): void
    {
        $computerId = $asset->computer->computerId;

        match ($changeType->action) {
            ChangeAction::ADDED =>
                ComputerDisk::create([
                    'computerId' => $computerId,
                    'diskId'   => $change['diskId']
                ]),

            ChangeAction::REPLACED =>
                ComputerDisk::where('computerId', $computerId)
                    ->where('diskId', $change['oldDiskId'])
                    ->update(['diskId' => $change['DiskId']]),

            ChangeAction::REMOVED =>
                ComputerDisk::where('computerId', $computerId)
                    ->where('diskId', $change['diskId'])
                    ->delete(),

            default => null
        };
    }
}