<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Requests
use App\Http\Requests\LoginRequest;
// Services
use App\Services\AuthService;
// Resources
use App\Http\Resources\AuthResource;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService){
    }
    public function login(LoginRequest $request) {
        $validated = $request->validated();

        $auth = $this->authService->login($validated);

        return new AuthResource($auth);

        // return response()->json([
        //     'user' => [
        //         'userId'    => $user->userId,
        //         'name'      => $user->getFullName(),
        //         'email'     => $user->email,
        //         'rol'       => $user->rolId,
        //     ],
        //     'token' => $token,
        // ])->cookie(
        //     'itam_auth',
        //     $token,
        //     60*24,
        //     '/',
        //     null,
        //     false,
        //     true
        // );
    }

    //  Cerrar sesión
    public function logout(Request $request)
    {
        $this->authService->logout($request->user());

        return response()->json(['message' => 'Sesión cerrada exitosamente'], 200);
    }
}
