<?php

namespace App\Policies;

use App\Models\Activo;
use App\Models\Usuario;

class ActivoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Usuario $user)
    {
        return in_array($user->rol, ['TEC', 'ADMG', 'ADMS']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Usuario $user, Activo $activo)
    {
        return in_array($user->rol, ['TEC', 'ADMG', 'ADMS', 'PER']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Usuario $user)
    {
        return $user->rol === 'TEC';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Usuario $user, Activo $activo)
    {
        return $user->rol === 'ADMS';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Usuario $user, Activo $activo)
    {
        return in_array($user->rol, ['TEC', 'ADMS', 'ADMG']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Usuario $user, Activo $activo)
    {
        return $user->rol === 'ADMS';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Usuario $user, Activo $activo)
    {
        return $user->rol === 'ADMS';
    }
}
