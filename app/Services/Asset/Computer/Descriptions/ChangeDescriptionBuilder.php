<?php

namespace App\Services\Asset\Computer\Descriptions;

use App\Models\ChangeType;
use App\Enums\ChangeComponent;

class ChangeDescriptionBuilder
{
    public static function build(ChangeType $changeType, array $change): string
    {
        return match ($changeType->component) {
            ChangeComponent::MEMORY  => MemoryDescription::build($changeType, $change),
            ChangeComponent::DISK    => DiskDescription::build($changeType, $change),
            ChangeComponent::LICENSE => LicenseDescription::build($changeType, $change)
        };
    }
}