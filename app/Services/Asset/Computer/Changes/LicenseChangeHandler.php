<?php

namespace App\Services\Asset\Computer\Changes;

use App\Models\Asset;
use App\Models\ChangeType;
use App\Models\ComputerDisk;
use App\Enums\ChangeAction;
use App\Services\Asset\Computer\Changes\Contracts\ChangeHandlerInterface;

class LicenseChangeHandler implements ChangeHandlerInterface
{
    public function handle(Asset $asset, ChangeType $changeType, array $change): void
    {
        $computerId = $asset->computer->computerId;

        match ($changeType->action) {
            ChangeAction::ADDED =>
                ComputerLicense::create([
                    'computerId' => $computerId,
                    'licenseId'   => $change['licenseId']
                ]),

            ChangeAction::REPLACED =>
                ComputerDisk::where('computerId', $computerId)
                    ->where('licenseId', $change['oldLicenseId'])
                    ->update(['licenseId' => $change['licenseId']]),

            ChangeAction::UPDATED =>
                ComputerDisk::where('computerId', $computerId)
                    ->where('licenseId', $change['licenseId'])
                    ->update(['licenseKey' => $change['licenseKey']]),

            ChangeAction::REMOVED =>
                ComputerDisk::where('computerId', $computerId)
                    ->where('licenseId', $change['licenseId'])
                    ->delete(),

            default => null
        };
    }
}