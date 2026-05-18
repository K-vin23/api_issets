<?php

namespace App\Enums;

enum MaintenanceType: string 
{
   case CORR = 'CORRECTIVO';
   case PREV = 'PREVENTIVO';
}   