<?php

namespace App\Enums;

enum ChangeAction: string
{
    public const ADDED = 'AGREGADO';
    public const REMOVED = 'REMOVIDO';
    public const REPLACED = 'REMPLAZADO';
    public const UPDATED = 'ACTUALIZADO'; //Only for licenses
}