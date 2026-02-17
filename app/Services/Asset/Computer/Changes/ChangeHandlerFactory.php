<?php

namespace App\Services\Asset\Computer\Changes;

use App\Enums\ChangeComponent;

class ChangeHandlerFactory
{
    public static function make(ChangeComponent $component)
    {
        return match ($component) {
            ChangeComponent::MEMORY  => app(MemoryChangeHandler::class),
            ChangeComponent::DISK    => app(DiskChangeHandler::class),
            ChangeComponent::LICENSE => app(LicenseChangeHandler::class),
        };
    }
}
