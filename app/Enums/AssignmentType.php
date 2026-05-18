<?php

namespace App\Enums;

enum AssignmentType: string
{
    case ASIGN = 'ASSIGNED';
    case TRANSF = 'TRANSFERRED';
    case REM = 'REMOVED';
}
