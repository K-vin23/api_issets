<?php

namespace App\Services\Asset\Computer\Changes;

use App\Models\Asset;
use App\Models\ChangeType;
use App\Models\ComputerMemory;
use App\Enums\ChangeAction;
use App\Services\Asset\Computer\Changes\Contracts\ChangeHandlerInterface;

class MemoryChangeHandler implements ChangeHandlerInterface
{
    public function handle(Asset $asset, ChangeType $changeType, array $change): void
    {
        $computerId = $asset->computer->computerId;

        match ($changeType->action) {
            ChangeAction::ADDED =>
                ComputerMemory::create([
                    'computerId' => $computerId,
                    'memoryId'   => $change['memoryId']
                ]),

            ChangeAction::REPLACED =>
                ComputerMemory::where('computerId', $computerId)
                    ->where('memoryId', $change['oldMemoryId'])
                    ->update(['memoryId' => $change['memoryId']]),

            ChangeAction::REMOVED =>
                ComputerMemory::where('computerId', $computerId)
                    ->where('memoryId', $change['memoryId'])
                    ->delete(),

            default => null
        };
    }
}