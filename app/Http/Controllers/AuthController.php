<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    
    /**
     *  Registrar un nuevo usuario
     */
    // public function register(StoreUsuarioRequest $request)
    // {
    //     $validated = $request->validated();

    //     // Crear el usuario
    //     $usuario = Usuario::create([
    //         'cedula' => $validated['cedula'],
    //         'id_tipousr' => $validated['id_tipousr'],
    //         'id_empresa' => $validated['id_empresa'],
    //         'nombre_completo' => $validated['nombre_completo'],
    //         'correo' => $validated['correo'],
    //         'id_ciudad' => $validated['id_ciudad'] ?? null,
    //         'pwd_encrypt' => Hash::make($validated['pwd_encrypt']), // Encriptar
    //     ]);

    //     // Crear token de autenticación
    //     $token = $usuario->createToken('api-token')->plainTextToken;

    //     return response()->json([
    //         'message' => 'Usuario registrado correctamente',
    //         'usuario' => [
    //             'cedula' => $usuario->cedula,
    //             'nombre' => $usuario->nombre_completo,
    //             'rol' => $usuario->rol,
    //         ],
    //         'token' => $token
    //     ], 201);
    // }

    //  Inicio de sesión
    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        $usuario = Usuario::where('cedula', $validated['cedula'])->first();

        if (!$usuario || !Hash::check($validated['pwd_encrypt'], $usuario->pwd_encrypt)) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        // Elimina tokens antiguos (opcional)
        $usuario->tokens()->delete();

        // Crea un nuevo token
        $token = $usuario->createToken('api-token')->plainTextToken;

        return response()->json([
            'usuario' => [
                'cedula' => $usuario->cedula,
                'nombre' => $usuario->nombre_completo,
                'rol' => $usuario->rol
            ],
            'token' => $token
        ]);
    }

    //  Cerrar sesión
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Sesión cerrada exitosamente']);
    }
}
