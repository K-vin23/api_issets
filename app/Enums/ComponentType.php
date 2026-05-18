<?php

namespace App\Enums;

enum ComponentType: string
{
    case MEM = 'MEMORY';
    case STOR = 'STORAGE';
    case PROC = 'PROCESSOR';
}   