<?php

namespace App\Http\Controllers;
use App\Models\ActivoEliminado;

class ActivoEliminadoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum'); //Aplicar las reglas de MantenimientoPolicy
    }

    // Obtener todos los activos eliminados
    public function index()
    {   
        $this->authorize('viewAny', ActivoEliminado::class);
        return ActivoEliminado::all();
    }

    // // Registrar una baja de activo
    // public function store(StoreActivoEliminadoRequest $request)
    // {
    //     $validated = $request->validated();

    //     $eliminado = ActivoEliminado::create([
    //         'id_activo' => $validated['id_activo'],
    //         'id_empresa' => $validated['id_empresa'],
    //         'ultimo_usr' => $validated['ultimo_usr'],
    //         'ultima_act' => $validated['ultima_act'],
    //         'usr_registro' => $validated['ultimo_usr'],
    //         'fecha_baja' => now(),
    //         'razon_baja' => $validated['razon_baja']
    //     ]);

    //     return response()->json([
    //         'message' => 'Activo movido a eliminados correctamente',
    //         'data' => $eliminado
    //     ], 201);
    // }


    // Obtener eliminados por id
    public function show($id_eliminado) 
    { 
        $eliminado = ActivoEliminado::with(['activo', 'empresa', 'ultimoUsuario', 'usuarioEliminacion'])
                            ->where('id_eliminado', $id_eliminado)
                            ->findOrFail($id_eliminado);
    
        $this->authorize('view', $eliminado);
        return response()->json($eliminado);
    }

    // Eliminar activo eliminado definitivamente
    public function destroy($id_eliminado) 
    { 
        $eliminado = ActivoEliminado::where('id_eliminado', $id_eliminado)->first(); 
        if (!$eliminado) { return response()->json(['message' => 'Activo no encontrado en el registro de eliminados'], 404); }
        $this->authorize('delete', $eliminado);
        $eliminado->delete();
        return response()->json(['message' => 'Activo eliminado definitivamente'], 200); 
    }
}
