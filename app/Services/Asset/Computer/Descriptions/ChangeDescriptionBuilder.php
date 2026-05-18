<?php

namespace App\Services\Asset\Computer\Descriptions;

use App\Models\ChangeType;
use App\Enums\ComponentType;

class ChangeDescriptionBuilder
{
    public static function build(ChangeType $changeType, int $changeId): string
    {
        return match ($changeType->component) {
            ComponentType::MEMORY->value    => MemoryDescription::build($changeType, $changeId),
            ComponentType::STOR->value      => DiskDescription::build($changeType, $changeId),
            ComponentType::PROC->value      => LicenseDescription::build($changeType, $changeId)
        };
    }
}