<?php

namespace App\Services;

// Models
use App\Models\Asset;
use App\Models\User;
use App\Models\Area;
use App\Models\Maintenance;
// Utilities
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService 
{
    public function login(array $data) {
        $user = User::firstWhere('cedula', $data['cedula']);

        if (!$user || !Hash::check($data['password'], $user->pw_encrypt)) {
            throw ValidationException::withMessages([
                'credentials' => 'Credenciales inválidas.'
            ]);
        }else{
            $token = $user->createToken('auth-token')->plainTextToken;

            return [
                'user'  => $user,
                'token' => $token,
            ];
        }    
    }

    public function logout(User $user) {
        $user->currentAccessToken()->delete();
    }
}
