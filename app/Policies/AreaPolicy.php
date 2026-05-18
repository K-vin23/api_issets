<?php

namespace App\Policies;

use App\Models\Area;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AreaPolicy
{

    public function viewAny(User $user): bool
    {
        return in_array($user->rolId, ['TEC', 'ADM']);        
    }

    public function view(User $user, Area $area): bool
    {
        //
    }

    public function create(User $user): bool
    {
        //
    }

    public function update(User $user, Area $area): bool
    {
        //
    }

    public function delete(User $user, Area $area): bool
    {
        //
    }

    public function restore(User $user, Area $area): bool
    {
        //
    }

    public function forceDelete(User $user, Area $area): bool
    {
        //
    }
}
