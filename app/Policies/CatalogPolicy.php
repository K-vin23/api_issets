<?php

namespace App\Policies;

use App\Models\Models;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CatalogPolicy
{

    public function viewAny(User $user): bool
    {
        return in_array($user->rolId, ['TEC', 'ADM']);
    }

    public function view(User $user, Models $model): bool
    {
        return in_array($user->rolId, ['TEC', 'ADM']);
    }

    public function create(User $user): bool
    {
        return in_array($user->rolId, ['TEC', 'ADM']);
    }

    public function update(User $user, Models $model): bool
    {
        return in_array($user->rolId, ['TEC', 'ADM']);
    }

    public function delete(User $user, Models $model): bool
    {
        return in_array($user->rolId, ['TEC', 'ADM']);
    }

    public function restore(User $user, Models $model): bool
    {
        return in_array($user->rolId, ['TEC', 'ADM']);
    }

    public function forceDelete(User $user, Models $model): bool
    {
        return in_array($user->rolId, ['TEC', 'ADM']);
    }
}
