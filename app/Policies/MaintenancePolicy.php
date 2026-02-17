<?php

namespace App\Policies;

use App\Models\Maintenance;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MaintenancePolicy
{
    public function viewAny(?User $user) 
    {
        return in_array($user->rolId, ['TEC', 'ADM']);
    }

    public function view(User $user, Maintenance $maintenance) 
    {
        return in_array($user->rol, ['TEC', 'ADM']);
    }

    public function create(User $user) 
    {
        return in_array($user->rol, ['TEC', 'ADM']);
    }

    public function update(User $user, Maintenance $Maintenance) 
    {
        return in_array($user->rol, ['TEC', 'ADM']);
    }

    public function delete(User $user, Maintenance $Maintenance) 
    {
        return in_array($user->rol, ['TEC', 'ADM']);
    }

    public function restore(User $user, Maintenance $Maintenance) 
    {
        return in_array($user->rol, ['TEC', 'ADM']);
    }

    public function forceDelete(User $user, Maintenance $Maintenance) 
    {
        return in_array($user->rol, ['TEC', 'ADM']);
    }
}
