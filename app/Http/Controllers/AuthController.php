<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
{
    $validated = $request->validated();

    $user = User::where('userId', $validated['userId'])->first();

    if (!$user || !Hash::check($validated['pw_encrypt'], $user->pw_encrypt)) {
        return response()->json(['message' => 'Credenciales incorrectas'], 401);
    }

    $token = $user->createToken('auth-token')->plainTextToken;

    return response()->json([
        'user' => [
            'userId'    => $user->userId,
            'name'      => $user->getFullName(),
            'email'     => $user->email,
            'rol'       => $user->rolId,
        ],
        'token' => $token,
    ])->cookie(
        'itam_auth',
        $token,
        60*24,
        '/',
        null,
        false,
        true
    );
}
    //  Cerrar sesión
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Sesión cerrada exitosamente']);
    }
}
