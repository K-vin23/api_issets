<?php

namespace App\Http\Controllers;

// Models
use App\Models\Asset;
// Requests
use App\Http\Requests\StoreAssetRequest;
use App\Http\Requests\UpdateAssetRequest;
use App\Http\Requests\IndexAssetRequest;
// Services
use App\Services\Asset\AssetService;
// Resources
use App\Http\Resources\AssetResource;


class AssetController extends Controller
{
    public function __construct(
        protected AssetService $assetService
    )
    {
        $this->middleware('auth:sanctum');
    }

    public function index(IndexAssetRequest $request) {
        $this->authorize('viewAny', Asset::class);

        $assets = $this->assetService->index($request->validated(), $request->integer('perPage', 15));

        return AssetResource::collection($assets);
    }

    public function store(StoreAssetRequest $request){

        $validated = $request->validated(); 

        $this->authorize('create', Asset::class);

        $asset = $this->assetService->create(
            $validated, 
            auth()->id()
        );

        return response()->json([
            'message' => 'Activo creado correctamente',
            'data' => $asset
        ], 201);
    }

    public function update(UpdateAssetRequest $request, Asset $asset){

        $validated = $request->validated();

        $this->authorize('update', $asset);

        $this->assetService->update(
            $asset,
            $validated,
            auth()->id()
        );

        return response()->json([
            'message' => 'Activo actualizado exitosamente'
        ], 200);
    }
}