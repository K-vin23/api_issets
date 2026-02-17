<?php

namespace App\Services\Asset\Computer\Descriptions;

use App\Models\ChangeType;
use App\Models\Memory;
use App\Enums\ChangeAction;

class MemoryDescription
{
    public static function build(ChangeType $changeType, array $change): string
    {
        $memory = Memory::findOrFail($change['memoryId']);

        if(isset($change['oldMemoryId'])){ 
            $oldMemory = Memory::findOrFail($change['oldMemoryId']);
        }
        
        return match ($changeType->action) {
                ChangeAction::ADDED    => "Memoria de {$memory->gbCapacity}GB {$memory->memoryType} agregada",
                ChangeAction::REMOVED  => "Memoria de {$memory->gbCapacity}GB {$memory->memoryType} eliminada",
                ChangeAction::REPLACED => "Memoria de {$oldMemory->gbCapacity}GB {$oldMemory->memoryType} reemplazada por " 
                                                        . "memoria de {$memory->gbCapacity}GB {$memory->memoryType}",
                default => 'Cambio de memoria no reconocido'
        };

    }
}