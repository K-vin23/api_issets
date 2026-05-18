<?php

namespace App\Policies;

use App\Models\City;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CityPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->rolId, ['TEC', 'ADM']);
    }
}
