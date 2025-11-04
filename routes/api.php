<?php

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ActivoEliminadoController;
// use App\Models\Usuario;

/*
|--------------------------------------------------------------------------
| Rutas API públicas
|--------------------------------------------------------------------------
| Aquí van las rutas abiertas (sin autenticación), como login o registro.
| Ejemplo: usuarios que aún no han iniciado sesión.
|--------------------------------------------------------------------------
*/

Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Rutas API protegidas
|--------------------------------------------------------------------------
| Todas las rutas dentro de este grupo requieren autenticación mediante
| token (Sanctum). Laravel pasará automáticamente el usuario autenticado.
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Rutas para gestión de usuarios
    |--------------------------------------------------------------------------
    | Solo usuarios autenticados pueden acceder.
    | Dentro del controlador se validará el permiso (policy) para:
    | - viewAny, view, create, update, delete
    |--------------------------------------------------------------------------
    */
     
    Route::prefix('usuarios')->group(function () {

        // Ver todos los usuarios (solo técnicos o administradores)
        Route::get('/', [UsuarioController::class, 'index']);

        // Crear un usuario nuevo (solo tecnicos o administradores)
        Route::post('/register', [UsuarioController::class, 'store']); //OK

        // Ver usuario por cedula (tecnicos, administradores o el propio usuario)
        Route::get('/{cedula}', [UsuarioController::class, 'show']);

        // Actualizar usuario (solo técnicos o administradores)
        Route::put('/{cedula}', [UsuarioController::class, 'update']);
        Route::patch('/{cedula}', [UsuarioController::class, 'update']);

        // Eliminar activo (solo administradores)
        Route::delete('/{cedula}', [UsuarioController::class, 'destroy']);
    });

    /*
    |--------------------------------------------------------------------------
    | Rutas para gestión de activos
    |--------------------------------------------------------------------------
    | Solo usuarios autenticados pueden acceder.
    | Dentro del controlador se validará el permiso (policy) para:
    | - viewAny, view, create, update, delete
    |--------------------------------------------------------------------------
    */

    Route::prefix('activos')->group(function () {

        // Ver todos los activos (solo técnicos o administradores)
        Route::get('/', [ActivoController::class, 'index']);

        // Crear un activo nuevo (solo técnicos)
        Route::post('/', [ActivoController::class, 'store']);

        // Ver activo por empresa (solo tecnicos o administradores)
        Route::get('/{id_empresa}', [ActivoController::class, 'showByEmpresa']);

        // Ver activo por id_activo + id_empresa (todos con permiso de lectura)
        Route::get('/{id_empresa}/{id_activo}', [ActivoController::class, 'show']);

        // Actualizar activo (solo técnicos o administradores)
        Route::put('/{id_empresa}/{id_activo}', [ActivoController::class, 'update']);
        Route::patch('/{id_empresa}/{id_activo}', [ActivoController::class, 'update']);

        // Eliminar activo y mover a activos eliminados (solo administradores y tecnicos)
        Route::delete('/{id_empresa}/{id_activo}', [ActivoController::class, 'destroy']);

        /* Mantenimientos del activo */
        // Ver todos los mantenimientos
        Route::get('/{id_empresa}/{id_activo}/mantenimientos', [MantenimientoController::class, 'showByActivo']);

    });

    /*
    |--------------------------------------------------------------------------
    | Rutas para gestión de mantenimientos
    |--------------------------------------------------------------------------
    | Dentro del controlador se validará el permiso (policy) para:
    | - viewAny, view, create, update, delete
    |--------------------------------------------------------------------------
    */
     
    Route::prefix('mantenimientos')->group(function () {

        // Ver todos los mantenimientos de un activo (solo técnicos o administradores)
        Route::get('/', [MantenimientoController::class, 'index']);

        // Ver mantenimiento por id (tecnicos, administradores o el propio usuario)
        Route::get('/{id_manten}', [MantenimientoController::class, 'show']);

        // Registrar un nuevo mantenimiento (tecnicos)
        Route::post('/', [MantenimientoController::class, 'register']);

        // Actualizar mantenimiento (solo técnicos o administradores)
        Route::put('/{id_manten}', [UsuarioController::class, 'update']);
        Route::patch('/{id_manten}', [UsuarioController::class, 'update']);

        // Eliminar activo (solo técnicos administradores)
        Route::delete('/{id_manten}', [UsuarioController::class, 'destroy']);
    });

    /*
    |--------------------------------------------------------------------------
    | Rutas para gestión de activos eliminados
    |--------------------------------------------------------------------------
    | Dentro del controlador se validará el permiso (policy) para:
    | - viewAny, view, create, update, delete
    |--------------------------------------------------------------------------
    */

    Route::prefix('eliminados')->group(function () {

        // Ver todos los activos eliminados (solo técnicos o administradores)
        Route::get('/', [ActivoEliminadoController::class, 'index']);

        // Ver activo eliminado especifico por id de eliminación (tecnicos, administradores)
        Route::get('/{id_eliminado}', [ActivoEliminadoController::class, 'show']);

        // Eliminar definitivamente un activo (solo técnicos administradores)
        Route::delete('/{id_eliminado}', [UsuarioController::class, 'destroy']);
    });

    /*
    |--------------------------------------------------------------------------
    | Rutas para cerrar sesión
    |--------------------------------------------------------------------------
    */
    Route::post('/logout', [AuthController::class, 'logout']);
});
