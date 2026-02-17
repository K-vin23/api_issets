<?php

namespace App\Enums;

enum AuditAction: string
{
    public const INS = "INSERTAR";
    public const DEL = "ELIMINAR";
    public const UPD = "ACTUALIZAR";
}   