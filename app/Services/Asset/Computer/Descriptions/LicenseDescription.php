<?php

namespace App\Services\Asset\Computer\Descriptions;

use App\Models\ChangeType;
use App\Models\License;
use App\Models\SoftwareType;
use App\Enums\ChangeAction;

class LicenseDescription
{
    public static function build(ChangeType $changeType, array $change): string
    {
        $license = License::findOrFail($change['licenseId']);
        $type = SoftwareType::findOrFail($license->softwareType);

        if(isset($change['oldLicenseId'])){
            $oldLicense = License::findOrFail($change['oldLicenseId']);
        }

        return match ($changeType->action) {
            ChangeAction::ADDED    => "Licencia de {$type}, {$license->software} {$license->sofVersion} agregada",
            ChangeAction::REMOVED  => "Licencia de {$type}, {$license->software} {$license->sofVersion} eliminada",
            ChangeAction::REPLACED => "Licencia de {$type}, {$oldLicense->software} {$oldLicense->sofVersion} reemplazada por " 
                                        . "licencia {$license->software} {$license->sofVersion}",
            ChangeAction::UPDATED  => "Licencia de {$type}, {$license->software} {$license->sofVersion} renovada",
            default => "componente desconocido"
        };
    }
}