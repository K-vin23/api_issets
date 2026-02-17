<?php

namespace App\Http\Controllers;

// Models
use App\Models\User;
// Enums
use App\Enums\Rol;
// Requests
use Illuminate\Http\Request;
use App\Http\Requests\IndexUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
// Services
use App\Services\UserService;
// Resources
use App\Http\Resources\UserResource;
// Utilities
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    )
    {
        $this->middleware('auth:sanctum');
    }

    public function index(IndexUserRequest $request) {
        $this->authorize('viewAny', User::class);

        $users = $this->userService->index($request->validated(), $request->integer('perPage', 15));
        return UserResource::collection($users);
    }

    public function show(User $user) {
        $this->authorize('view', $user);

        $user = $this->userService->show($user);

        return new UserResource($user);
    }

    public function me(Request $request) {
        $this->authorize('me', User::class);
        
        $user = $request->user();

        $user = $this->userService->me($user);

        return new UserResource($user);
    }

    public function store(StoreUserRequest $request) {
            $this->authorize('create', User::class);

            $user = $this->userService->create($request->validated(), auth()->id());
            return response()->json([
                'message' => 'Usuario creado correctamente',
                'data' => $user
            ], 201);
    }

    public function update(UpdateUserRequest $request, User $user) {


        $this->authorize('update', $user);

        $user = $this->userService->update($user, $request->validated());

        return new UserResource($user);
    }

    // Update myself
    public function updateMe(UpdateMeRequest $request) {

        $user = $request->user();

        $this->userService->update($user, $request->validated());

        return response()->json([
            'message' => 'Usuario actualizado correctamente'
        ], 200); 
    }

    public function updatePassword(UpdatePasswordRequest $request, User $user) {
        
        $this->authorize('updatePassword', $user);

        if($user->userRol->rol === 'ADM'){
            $this->userService->resetPassword($user, $request->new_password);
        }else{
            $this->userService->updatePassword($user, $request->current_password, $request->new_password);
        }

        return response()->json([
            'message' => 'Contrasena actualizada correctamente'
        ], 200);
    }

    public function destroy(User $user) {

        $this->authorize('delete', $user);

        $this->userService->delete($user, auth()->id());

        return response()->json([], 204); 
    }
}