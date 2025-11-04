<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Activo;
use App\Models\ActivoEliminado;
use App\Models\Empresa;
use App\Models\MantenimientoActivo;
use App\Models\Usuario;
use App\Policies\ActivoPolicy;
use App\Policies\UsuarioPolicy;
use App\Policies\EmpresaPolicy;
use App\Policies\MantenimientoPolicy;
use App\Policies\ActivoEliminadoPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //activo
        Activo::class => ActivoPolicy::class,
        \App\Models\Activo::class => \App\Policies\ActivoPolicy::class,
        //Mantenimiento
        MantenimientoActivo::class => MantenimientoPolicy::class,
        \App\Models\MantenimientoActivo::class => \App\Policies\MantenimientoPolicy::class,
        //Usuario
        Usuario::class => UsuarioPolicy::class,
        \App\Models\Usuario::class => \App\Policies\UsuarioPolicy::class,
        //Empresa
        Empresa::class => EmpresaPolicy::class,
        \App\Models\Empresa::class => \App\Policies\EmpresaPolicy::class,
        //ActivoEliminado
        ActivoEliminado::class => ActivoEliminadoPolicy::class,
        \App\Models\ActivoEliminado::class => \App\Policies\ActivoEliminadoPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
