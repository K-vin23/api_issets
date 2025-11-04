<?php

namespace App\Policies;

use App\Models\MantenimientoActivo;
use App\Models\Usuario;
use Illuminate\Auth\Access\Response;

class MantenimientoPolicy
{
    /**
     * Determine whether the Usuario can view any models.
     */
    public function viewAny(Usuario $user) 
    {
        return in_array($user->rol, ['TEC', 'ADMG', 'ADMS']);
    }

    /**
     * Determine whether the Usuario can view the model.
     */
    public function view(Usuario $user, MantenimientoActivo $mantenimientoActivo) 
    {
        return in_array($user->rol, ['TEC', 'ADMG', 'ADMS']);
    }

    /**
     * Determine whether the Usuario can create models.
     */
    public function create(Usuario $user) 
    {
        return in_array($user->rol, ['TEC', 'ADMS']);
    }

    /**
     * Determine whether the Usuario can update the model.
     */
    public function update(Usuario $user, MantenimientoActivo $mantenimientoActivo) 
    {
        return in_array($user->rol, ['TEC', 'ADMS']);
    }

    /**
     * Determine whether the Usuario can delete the model.
     */
    public function delete(Usuario $user, MantenimientoActivo $mantenimientoActivo) 
    {
        return in_array($user->rol, ['TEC', 'ADMS']);
    }

    /**
     * Determine whether the Usuario can restore the model.
     */
    public function restore(Usuario $user, MantenimientoActivo $mantenimientoActivo) 
    {
        return in_array($user->rol, ['TEC', 'ADMS']);
    }

    /**
     * Determine whether the Usuario can permanently delete the model.
     */
    public function forceDelete(Usuario $user, MantenimientoActivo $mantenimientoActivo) 
    {
        return in_array($user->rol, ['TEC', 'ADMS']);
    }
}
