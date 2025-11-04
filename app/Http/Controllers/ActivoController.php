<?php

namespace App\Http\Controllers;

use App\Models\Activo;
use App\Models\ActivoEliminado;
use App\Http\Requests\StoreActivoRequest;
use App\Http\Requests\storeActivoEliminadoRequest;
use App\Http\Requests\UpdateActivoRequest;
use Illuminate\Support\Facades\DB;

class ActivoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum'); //Aplicar las reglas de ActivoPolicy
    }
    
    // Obtener todos los activos
    public function index()
    {   
        $this->authorize('viewAny', Activo::class);
        return Activo::all();
    }

    // Crear un nuevo activo
    public function store(StoreActivoRequest $request)
    {
        $this->authorize('create', Activo::class);
        $activo = Activo::create($request->all());
        return response()->json($activo, 201);
    }

    // Obtener activo por ID compuesto
    public function show($id_empresa, $id_activo)
    {
        $activo = Activo::with(['empresa', 'tipoActivo', 'modelo', 'usuarioAsignado', 'usuarioRegistro'])
                        ->where('id_activo', $id_activo)
                        ->where('id_empresa', $id_empresa)
                        ->firstOrFail();

        $this->authorize('view', $activo);
        return response()->json($activo);
    }

    public function showByEmpresa($id_empresa)
    {
        $activos = Activo::getActivosEmpresa($id_empresa);

        if($activos->isEmpty()){
            return response()->json(['message' => 'La empresa no tiene activos'], 404);
        }

        return response()->json($activos);
    }

    // Actualizar activo
    public function update(UpdateActivoRequest $request, $id_empresa, $id_activo)
{
    $activo = Activo::where('id_activo', $id_activo)
                    ->where('id_empresa', $id_empresa)
                    ->firstOrFail();

    // Verificar autorización según policy
    $this->authorize('update', $activo);

    // Solo los campos validados se actualizan
    $activo->fill($request->validated());
    $activo->save();

    return response()->json([
        'message' => 'Activo actualizado correctamente',
        'data' => $activo
    ], 200);
}
    // Eliminar activo
    public function destroy(StoreActivoEliminadoRequest $request, $id_empresa, $id_activo)
    {
        $activo = Activo::where('id_activo', $id_activo)
                        ->where('id_empresa', $id_empresa)
                        ->first();
        
        if (!$activo) { return response()->json(['message' => 'Activo no encontrado'], 404); }

        $this->authorize('delete', $activo);

        try {
            DB::beginTransaction();

            // 1️⃣ Registrar el activo en la tabla de eliminados
            ActivoEliminado::create([
                'id_activo' => $activo->id_activo,
                'id_empresa' => $activo->id_empresa,
                'ultimo_usr' => $request->input('ultimo_usuario'),
                'ultima_act' => $activo->ultima_act,
                'usr_registro' => auth()->user()->cedula ?? 'system',
                'fecha_baja' => now(),
                'razon_baja' => $request->input('motivo', 'Eliminado manualmente'),
            ]);

            $activo->delete();

            DB::commit();

             return response()->json(['message' => 'activo movido a eliminacion correctamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al eliminar el activo',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}