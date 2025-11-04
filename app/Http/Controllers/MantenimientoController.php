<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMantenimientoRequest;
use App\Http\Requests\UpdateMantenimientoRequest;
use App\Models\MantenimientoActivo;

class MantenimientoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum'); //Aplicar las reglas de MantenimientoPolicy
    }

    // Obtener todos los mantenimientos
    public function index()
    {   
        $this->authorize('viewAny', MantenimientoActivo::class);
        return MantenimientoActivo::all();
    }

    // Registrar un mantenimiento
    public function store(StoreMantenimientoRequest $request)
    {
        $validated = $request->validated();

        $usuario = MantenimientoActivo::create([
            'id_activo' => $validated['id_activo'],
            'id_empresa' => $validated['id_empresa'],
            'id_tipomnt' => $validated['id_tipomnt'],
            'fecha_manten' => $validated['fecha_manten'],
            'proximo_manten' => $validated['proximo_manten'] ?? null,
            'usr_manten' => $validated['usr_manten'],
            'observaciones' => $validated['observaciones'],
        ]);

        return response()->json([
            'message' => 'Mantenimiento registrado correctamente',
            'data' => $usuario
        ], 201);
    }

    // Obtener mantenimientos por Activo
    public function showByActivo($id_activo, $id_empresa) 
    { 
        $mantenimientos = MantenimientoActivo::with(['activo', 'empresa', 'TipoMantenimiento', 'UsuarioMantenimiento'])
                            ->where('id_activo', $id_activo)
                            ->where('id_empresa', $id_empresa)
                            ->get();
        if ($mantenimientos->isEmpty()) {
            return response()->json(['message' => 'no se encontraron mantenimientos para este activo'], 404);
        }
        
        $this->authorize('view', $mantenimientos);
        return response()->json($mantenimientos);
    }

    // Obtener mantenimiento por id
    public function show($id_manten) 
    { 
        $mantenimiento = MantenimientoActivo::with(['activo', 'empresa', 'TipoMantenimiento', 'UsuarioMantenimiento'])
                            ->where('id_mant', $id_manten)
                            ->findOrFail($id_manten);
    
        $this->authorize('view', $mantenimiento);
        return response()->json($mantenimiento);
    }

    // Actualizar registro mantenimiento
    public function update(UpdateMantenimientoRequest $request, $id_manten)
    { 
        $mantenimiento = MantenimientoActivo::where('id_mant', $id_manten)->firstOrFail(); 

        $this->authorize('update', $mantenimiento);

        $mantenimiento->fill($request->validated()); 
        $mantenimiento->save();

        return response()->json([
            'message' => 'Mantenimiento actualizado correctamente',
            'data'=> $mantenimiento
        ], 200); 
    }

    // Eliminar registro
    public function destroy($id_manten) 
    { 
        $mantenimiento = MantenimientoActivo::where('id_mant', $id_manten)->first(); 
        if (!$mantenimiento) { return response()->json(['message' => 'Registro de mantenimiento no encontrado'], 404); }
        $this->authorize('delete', $mantenimiento);
        $mantenimiento->delete();
        return response()->json(['message' => 'Registro eliminado correctamente'], 200); 
    }
}
