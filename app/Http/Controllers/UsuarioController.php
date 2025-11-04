<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum'); //Aplicar las reglas de UsuarioPolicy
    }

    // Obtener todos los usuarios
    public function index()
    {
        $this->authorize('viewAny', Usuario::class);
        return Usuario::all();
    }

    // Crear un nuevo usuario
    public function store(StoreUsuarioRequest $request)
    {
        $validated = $request->validated();

        $usuario = Usuario::create([
            'cedula' => $validated['cedula'],
            'id_tipousr' => $validated['id_tipousr'],
            'id_empresa' => $validated['id_empresa'],
            'nombre_completo' => $validated['nombre_completo'],
            'correo' => $validated['correo'],
            'id_ciudad' => $validated['id_ciudad'] ?? null,
            'pwd_encrypt' => Hash::make($validated['pwd_encrypt']),
        ]);

        return response()->json([
            'message' => 'Usuario creado correctamente',
            'data' => $usuario
        ], 201);
    }

    // Obtener usuario por ID
    public function show($cedula) 
    { 
        $usuario = Usuario::with(['tipoUsuario', 'empresa', 'ciudad'])
                            ->where('cedula', $cedula)
                            ->firstOrFail($cedula);
    
        $this->authorize('view', $usuario);
        return response()->json($usuario);
    }

    // Actualizar usuario
    public function update(UpdateUsuarioRequest $request, $cedula) 
    { 
        $usuario = Usuario::findOrFail($cedula);

        $this->authorize('update', $usuario);

        $usuario->fill($request->validated()); 
        $usuario->save();

        return response()->json([
            'message' => 'Usuario actualizado correctamente',
            'data'=> $usuario
        ], 200); 
    }

    // Eliminar usuario
    public function destroy($cedula) 
    { 
        Usuario::destroy($cedula); 
        if (!$cedula) { return response()->json(['message' => 'Usuario no encontrado'], 404); }
        return response()->json(['message' => 'Usuario eliminado correctamente'], 200); 
    }
}