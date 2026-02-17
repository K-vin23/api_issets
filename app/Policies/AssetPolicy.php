<?php

namespace App\Policies;

use App\Models\Asset;
use App\Models\User;

class AssetPolicy
{
    public function viewAny(?User $user)
    {
        return in_array($user->rolId, ['TEC', 'ADM']);
    }

    public function view(User $user, Asset $asset)
    {
        return in_array($user->rolId, ['TEC', 'ADM']);
    }

    public function create(User $user)
    {
        return in_array($user->rolId, ['TEC', 'ADM']);
    }

    public function update(User $user, Asset $asset)
    {
        return in_array($user->rolId, ['TEC', 'ADM']);
    }

    public function assignUser(User $user, Asset $asset)
    {
        return $asset->isComputer() && in_array($user->rolId, ['TEC', 'ADM']);
    }

    public function delete(User $user, Asset $asset)
    {
        return in_array($user->rolId, ['TEC', 'ADM']);
    }

    public function restore(User $user, Asset $asset)
    {
        return $user->rolId === 'ADM';
    }

    public function forceDelete(User $user, Asset $asset)
    {
        return $user->rolId === 'ADM';
    }
}
