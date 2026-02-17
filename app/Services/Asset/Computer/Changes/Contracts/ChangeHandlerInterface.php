<?php

namespace App\Services\Asset\Computer\Changes\Contracts;

use App\Models\Asset;
use App\Models\ChangeType;

interface ChangeHandlerInterface
{
    public function handle(Asset $asset, ChangeType $changeType, array $change): void;
} 