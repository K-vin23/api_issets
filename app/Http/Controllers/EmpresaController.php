<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Http\Requests\StoreEmpresaRequest;
use App\Http\Requests\updateEmpresaRequest;

class EmpresaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum'); //Aplicar las reglas de EmpresaPolicy
    }

    // Obtener todos las empresa
    public function index()
    {   
        $this->authorize('viewAny', Empresa::class);
        return Empresa::all();
    }

    // Registrar una empresa
    public function store(StoreEmpresaRequest $request)
    {
        $validated = $request->validated();

        $empresa = Empresa::create([
            'id_empresa' => $validated['id_empresa'],
            'nombre' => $validated['nombre'],
            'id_ciudad' => $validated['id_ciudad'],
        ]);

        return response()->json([
            'message' => 'Mantenimiento registrado correctamente',
            'data' => $empresa
        ], 201);
    }

    // Obtener empresa por id
    public function show($id_empresa) 
    { 
        $empresa = Empresa::with(['ciudad'])
                            ->where('id_empresa', $id_empresa)
                            ->findOrFail($id_empresa);
    
        $this->authorize('view', $empresa);
        return response()->json($empresa);
    }

    // Actualizar una empresa
    public function update(updateEmpresaRequest $request, $id_empresa)
    { 
        $empresa = Empresa::findOrFail($id_empresa); 

        $this->authorize('update', $empresa);

        $empresa->fill($request->validated()); 
        $empresa->save();

        return response()->json([
            'message' => 'Empresa actualizada correctamente',
            'data'=> $empresa
        ], 200); 
    }

    // Eliminar registro
    public function destroy($id_empresa) 
    { 
        $empresa = Empresa::where('id_empresa', $id_empresa)->first(); 
        if (!$empresa) { return response()->json(['message' => 'Registro de mantenimiento no encontrado'], 404); }
        $this->authorize('delete', $empresa);
        $empresa->delete();
        return response()->json(['message' => 'Registro eliminado correctamente'], 200); 
    }
}
