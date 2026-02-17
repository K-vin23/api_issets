<?php

namespace App\Services;

// Models
use App\Models\User;
// Services
use App\Services\UserComputerAssignService;
// Utilities
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService
{
    public function __construct(
        protected UserComputerAssignService $assignService
    )
    {}

    public function index(array $filters = [], int $perPage = 15): LengthAwarePaginator {
        
        //optional filters w/ scopes in the model
        return User::query()
        ->active()
        ->when($filters['companyId'] ?? null, fn($q, $v) => $q->company($v))
        ->when($filters['areaId'] ?? null, fn($q, $v) => $q->area($v))
        ->when($filters['locationId'] ?? null, fn($q, $v) => $q->location($v))
        ->when($filters['search'] ?? null, fn($q, $v) => $q->search($v))        
        ->with([
            'company', 
            'area', 
            'location',
            'location.city' ,
            'rol',
            'registeredBy'
        ])
        ->orderBy('firstname')
        ->paginate($perPage);

    }

    public function show(User $user): User {
        return $user->load([
            'company',
            'area',
            'location',
            'location.city',
            'rol',
            'registeredBy'
        ]);
    }

        public function me(User $user): User {
        return $user->load([
            'company',
            'area',
            'location',
            'location.city',
            'rol'
        ]);
    }

    public function create(array $data, int $userId): User {

        return DB::transaction(function () use ($data, $userId) {
            
            return User::create([
                'userId'     => $data['userId'],
                'rolId'      => $data['rolId'],
                'companyId'  => $data['companyId'],
                'firstname'  => $data['firstname'],
                'middlename' => $data['middlename'],
                'lastname'   => $data['lastname'],
                's_lastname' => $data['s_lastname'],
                'email'      => $data['email'],
                'pw_encrypt' => $data['pw_encrypt'],
                'areaId'     => $data['areaId'],
                'locationId' => $data['locationId'],
                'registBy'   => $userId,
            ]);
        });
    }

    public function update(User $user, array $data): User {

        DB::transaction(function () use ($user, $data) {

            $user->update([
                'rolId'        => $data['rolId'] ?? $user->rolId,
                'companyId'    => $data['companyId'] ?? $user->companyId,
                'firstname'    => $data['firstname'] ?? $user->firstname,
                'middlename'   => $data['middlename'] ?? $user->middlename,
                'lastname'     => $data['lastname'] ?? $user->lastname,
                's_lastname'   => $data['s_lastname'] ?? $user->s_lastname,
                'email'        => $data['email'] ?? $user->email,
                'areaId'       => $data['areaId'] ?? $user->areaId,
                'locationId'   => $data['locationId'] ?? $user->locationId
            ]);
        });

        return $user->refresh()->load(['company', 'area', 'location.city', 'rol']);
    }

    public function updatePassword(User $user, string $currentPw, string $newPw) {
        
        if(!Hash::check($currentPw, $user->pw_encrypt)){
            throw ValidationException::withMessages([
                'current_password' => 'La contraseña actual no es correcta'
            ]);
        }

        $user->update([
            'pw_encrypt' => $newPw
        ]);

        $user->tokens()->delete();
    }

    public function resetPassword(User $user, string $newPw) {

        $user->update(['pw_encrypt' => $newPw]);

        $user->tokens()->delete();

        return $user->refresh();
    }

    public function delete(User $user, int $performedBy) {

        DB::transaction(function () use ($user, $performedBy) {
            $this->assignService->unassignAllFromUser($user, $performedBy);

            $user->update([
                'isActive' => false
            ]);
        });
    }
}
