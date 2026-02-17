<?php

namespace App\Http\Controllers;

// Models
use App\Models\Computer;
use App\Models\Asset;
// Requests
use App\Http\Requests\IndexComputerRequest;
use App\Http\Requests\UpdateComputerRequest;
use App\Http\Requests\AssignUserRequest;
// Services
use App\Services\Asset\Computer\ComputerService;
// Resources
use App\Http\Resources\ComputerResource;

class ComputerController extends Controller
{
    public function __construct(
        protected ComputerService $computerService
    )
    {
        $this->middleware('auth:sanctum');
    }

    public function index(IndexComputerRequest $request) {

        $this->authorize('viewAny', Computer::class);

        $computers = $this->computerService->index($request->validated(), $request->integer('perPage', 15));


        return ComputerResource::collection($computers);
    }

    public function me() {

        $this->authorize('view', Asset::class);

        $computers = $this->computerService->userComputers(auth()->id());
        
        return response()->json([
            'data' => $computers
        ]);
    }


    public function update(UpdateComputerRequest $request, Computer $computer) {

        $this->autorize('update', $computer);

        $this->computerService->update($computer, $request->validated());

        return response()->json([
            'message' => 'Activo (computador) actualizado exitosamente'
        ], 200);
    }

    public function assignUser(AssignUserRequest $request, Computer $computer) { //Only to update or assign user after the asset was created, if you want to create asset>computer with assignedUser already, use createWithAssignment() in ComputerService
    
        $validated = $request->validated();

        $this->authorize('assignUser', $computer);

        $this->computertService->assignUser(
            $computer,
            $validated['assignedUser'], // Pass the validated data (userId to assign)
            auth()->id() // Current authenticated user, who is performing the assignment
        );

        return response()->json([
            'message' => 'Usuario asignado correctamente al activo (computador)'
        ], 200);
    }

    public function applyChanges() {

    }

    public function delete() {
        
    }
}
