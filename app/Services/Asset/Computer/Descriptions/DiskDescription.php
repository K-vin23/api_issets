<?php

namespace App\Services\Asset\Computer\Descriptions;

use App\Models\ChangeType;
use App\Models\HardDisk;
use App\Enums\ChangeAction;

class DiskDescription
{
    public static function build(ChangeType $changeType, array $change): string
    {
        $disk = HardDisk::findOrFail($change['diskId']);

        if(isset($change['oldDiskId'])){
            $oldDisk = HardDisk::findOrFail($change['oldDiskId']);
        }

        if($disk->capacity>1000 || $oldDisk->capacity>1000) {
            $capacity = $disk->gbCapacity / 1000;
            $oldCapacity = isset($oldDisk) ? $oldDisk->gbCapacity / 1000 : null;
            $denomination = 'TB';
        }else{
            $capacity = $disk->gbCapacity;
            $oldCapacity = isset($oldDisk) ? $oldDisk->gbCapacity : null;
            $denomination = 'GB';
        }

        return match ($changeType->action) {
            ChangeAction::ADDED    => "Disco duro de {$capacity} {$denomination} {$disk->diskType} agregado",
            ChangeAction::REMOVED  => "Disco duro de {$capacity} {$denomination} {$disk->diskType} eliminado",
            ChangeAction::REPLACED => "Disco duro de {$oldCapacity} {$denomination} {$oldDisk->diskType} reemplazado por " 
                                                            . "disco duro de {$capacity} {$denomination} {$disk->diskType}",
            default => 'Componente desconocido'
        };
    }
}