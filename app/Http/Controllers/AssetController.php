<?php

namespace App\Http\Controllers;

// Models
use App\Models\Asset;
// Requests
use App\Http\Requests\StoreAssetRequest;
use App\Http\Requests\UpdateAssetRequest;
use App\Http\Requests\IndexAssetRequest;
use App\Http\Requests\RemovedAssetRequest;
// Services
use App\Services\Asset\AssetService;
// Resources
use App\Http\Resources\AssetListResource;
use App\Http\Resources\AssetDetailResource;
use App\Http\Resources\RemovedAssetResource;


class AssetController extends Controller
{
    public function __construct(protected AssetService $assetService) {
        $this->middleware('auth:sanctum');
    }

    public function index(IndexAssetRequest $request) {
        $this->authorize('viewAny', Asset::class);

        $assets = $this->assetService->index($request->validated(), $request->integer('perPage', 15));

        return AssetListResource::collection($assets);
    }

    public function removed(RemovedAssetRequest $request) {
        $this->authorize('viewAny', Asset::class);

        $removed = $this->assetService->removed($request->validated(), $request->integer('perPage', 15));

        return RemovedAssetResource::collection($removed);
    }

    public function show(Asset $asset) {
        $this->authorize('view', $asset);

        $asset = $this->assetService->show($asset);

        return new AssetDetailResource($asset);
    }

    public function me() {

        $this->authorize('viewAny', Asset::class);

        $assets = $this->assetService->myAssets(auth()->id());
        
        return response()->json([
            'data' => $assets
        ]);
    }

    public function store(StoreAssetRequest $request) {

        $validated = $request->validated(); 

        $this->authorize('create', Asset::class);

        $this->assetService->create($validated, auth()->id());

        return response()->json([
            'message' => 'Activo creado correctamente'
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