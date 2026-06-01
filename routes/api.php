<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\CatalogController;


/*
|--------------------------------------------------------------------------
| Rutas API públicas
|--------------------------------------------------------------------------
| Aquí van las rutas abiertas (sin autenticación), como login o registro.
| Ejemplo: usuarios que aún no han iniciado sesión.
|--------------------------------------------------------------------------
*/

Route::post('/login', [AuthController::class, 'login']);

// Route::middleware('auth:sanctum')->get('/me', function (Request $request) {
//     return $request->user();
// });

/*
|--------------------------------------------------------------------------
| Rutas API protegidas
|--------------------------------------------------------------------------
| Todas las rutas dentro de este grupo requieren autenticación mediante
| token (Sanctum). Laravel pasará automáticamente el usuario autenticado.
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/ping', function () {
        return response()->json([
            'status' => 'ok',
            'message' => 'API responde correctamente'
        ]);
    });
    /*
        ┌──────────────────────────────────────────────────┐
        │                Dashboard route                   │
        └──────────────────────────────────────────────────┘
    */
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/dashboard/upcomings', [DashboardController::class, 'upcomings']);
    /*
        ┌──────────────────────────────────────────────────┐
        │                   Cities route                   │
        └──────────────────────────────────────────────────┘
    */
    Route::get('/cities', [CityController::class, 'index']);
    /*
        ┌──────────────────────────────────────────────────┐
        │                    Areas route                   │
        └──────────────────────────────────────────────────┘
    */
    Route::get('/areas', [AreaController::class, 'index']);
    /*
        ┌──────────────────────────────────────────────────┐
        │            Companies managment routes            │
        └──────────────────────────────────────────────────┘
    */
    Route::prefix('companies')->group(function () {

        Route::get('/', [CompanyController::class, 'index']);

        Route::post('/', [CompanyController::class, 'store']);

        Route::patch('/{company}', [CompanyController::class, 'update']);

        Route::delete('/{company}', [CompanyController::class, 'delete']);

        Route::post('/restore/{company}', [CompanyController::class, 'restore']);
        /*
            ┌──────────────────────────────────────────────────┐
            │            Locations managment routes            │
            └──────────────────────────────────────────────────┘
        */
        Route::prefix('locations')->group(function () {
            Route::get('/{company}', [LocationController::class, 'index']);

            Route::post('/{company}', [LocationController::class, 'store']);

            Route::patch('/{location}', [LocationController::class, 'update']);

            Route::delete('/{location}', [LocationController::class, 'delete']);
        });
    });
    /*
        ┌──────────────────────────────────────────────────┐
        │               User managment routes              │
        └──────────────────────────────────────────────────┘
    */
    Route::prefix('users')->group(function () {
        // Show all users (solo técnicos o administradores)
        Route::get('/', [UserController::class, 'index']);

        // Create new user (solo tecnicos o administradores)
        Route::post('/', [UserController::class, 'store']); 

        // Search by Id or fullname.
        Route::get('/search', [UserController::class, 'search']);

        // Show all technicians
        Route::get('/techs', [UserController::class, 'showTech']);

        // Show user information (tecnicos, administradores o el propio usuario)
        // Route::get('/me', [UserController::class, 'me']);

        // Route::patch('/me', [UserController::class, 'updateMe']);

        // Show user information (tecnicos, administradores o el propio usuario)
        Route::get('/{user}', [UserController::class, 'show']);

        // Update user (solo técnicos o administradores)
        Route::patch('/{user}', [UserController::class, 'update']);

        // Delete user (solo administradores)
        Route::delete('/{user}', [UserController::class, 'destroy']);

        // Restore user (solo administradores)
        Route::post('/restore/{user}', [UserController::class, 'restore']);
    });
    /*
        ┌──────────────────────────────────────────────────┐
        │               Asset managment routes             │
        └──────────────────────────────────────────────────┘
    */
    Route::prefix('assets')->group(function () { 
        // Ver todos los activos (técnicos o administradores)
        Route::get('/', [AssetController::class, 'index']);

        // Show user assets (Todos los usuarios)
        Route::get('/show/{user}', [AssetController::class, 'me']);

        // Crear un activo nuevo (técnicos o administradores)
        Route::post('/', [AssetController::class, 'store']);

        // Assign user to asset(solo tecnicos o administradores)
        Route::post('/assign/{asset}', [AssetController::class, 'assign']);

        // Removed assets routes
        Route::prefix('removed')->group(function () { 
            // Show all removed assets
            Route::get('/', [AssetController::class, 'removed']);

            // Restore removed asset
            Route::post('/restore/{asset}', [AssetController::class, 'restore']);
        });
        /*
            ┌──────────────────────────────────────────────────┐
            │           Assets - Maintenances routes.          │
            └──────────────────────────────────────────────────┘
        */
        Route::prefix('maintenances')->group(function () { 

            // Show all maintenances from asset
            Route::get('/{asset}', [MaintenanceController::class, 'showAsset']);

            // Register maintenance
            Route::post('/{asset}', [MaintenanceController::class, 'store']);

            // Show specific maintenance
            Route::get('/{maintenance}', [MaintenanceController::class, 'show']);
        });

        // Show specific asset (todos con permiso de lectura)
        Route::get('/{asset}', [AssetController::class, 'show']);

        // Update asset information and register changes in history (solo técnicos o administradores)
        Route::patch('/{asset}', [AssetController::class, 'update']);

        // Delete asset and register on deletion history (solo administradores o tecnicos)
        Route::delete('/{asset}', [AssetController::class, 'delete']);
        /*
            ┌──────────────────────────────────────────────────┐
            │            Assets - catalog routes.              │
            └──────────────────────────────────────────────────┘
        */
            Route::prefix('catalog')->group(function () { 

                // Get catalog
                Route::get('/models', [CatalogController::class, 'index']);

                // Insert model in the catalog
                Route::post('/models', [CatalogController::class, 'store']);

                // Update model in the catalog
                Route::patch('/models/{models}', [CatalogController::class, 'update']);

                // Get brands catalog
                Route::get('/brands', [CatalogController::class, 'brands']);
                
                // Get processors catalog
                Route::get('/processors', [CatalogController::class, 'processors']);

                // Get memories catalog
                Route::get('/memories', [CatalogController::class, 'memories']);

                // Get hard disks catalog
                Route::get('/disks', [CatalogController::class, 'disks']);

                // Get licenses catalog
                Route::get('/licenses', [CatalogController::class, 'licenses']);

            });
    });
    Route::prefix('audit')->group(function () { 

    });
    /*
    ┌───────────────────────────────┐
    │       end session             │
    └───────────────────────────────┘
    */
    Route::post('/logout', [AuthController::class, 'logout']);
});
