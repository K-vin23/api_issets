<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
// use App\Models\Computer;
use App\Models\Models;
// Requests
use App\Http\Requests\IndexCatalogRequest;
use App\Http\Requests\StoreCatalogRequest;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\StoreModelRequest;
use App\Http\Requests\StoreComponentRequest;
use App\Http\Requests\AssignComponentRequest;
// Services
use App\Services\Asset\CatalogService;
// Resources
use App\Http\Resources\ComponentResource;
use App\Http\Resources\ModelsListResource;
use App\Http\Resources\ModelsResource;

class CatalogController extends Controller
{
    public function __construct(protected CatalogService $catalogService) {
        $this->middleware('auth:sanctum');
    }

    public function modelIndex(IndexCatalogRequest $request) {
       $this->authorize('viewAny', Models::class);
       
       $mds = $this->catalogService->catalog($request->validated(), $request->integer('perPage', 15));

       return ModelsListResource::collection($mds);
    }

    public function showModel(Models $models) {
        $this->authorize('view', $models);

        return new ModelsListResource($models);
    }

    public function assignComponent(Models $models, AssignComponentRequest $request) {
        $this->authorize('create', $models);

        $this->catalogService->assignComponent($models, $request->validated());

        return response(200);
    }

    public function types() {
        $this->authorize('viewAny', Models::class);

        return response()->json($this->catalogService->types(), 200);
    }

    public function brands() {

        $this->authorize('viewAny', Models::class);

        return response()->json(
            $this->catalogService->brand()
        );
    }

    public function storeComponent(StoreComponentRequest $request) {
        $this->authorize('create', Models::class);

        $this->catalogService->createComponent($request->validated());

        return response(201);
    }

    public function storeBrand(StoreBrandRequest $request) {
        $this->authorize('create', Models::class);

        $this->catalogService->createBrand($request->validated());

        return response(201);
    }

    public function storeModel(StoreModelRequest $request) {
        $this->authorize('create', Models::class);

        $this->catalogService->createModel($request->validated());

        return response(201);
    }

    public function categories() {
        $this->authorize('viewAny', Models::class);

        return response()->json($this->catalogService->componentCategories(), 200);
    }

    public function compTypes() {
        $this->authorize('viewAny', Models::class);

        return response()->json($this->catalogService->componentTypes(), 200);
    }

    public function update() {
        $this->authorize('update', Models::class);
    }

    public function components() {
        $this->authorize('viewAny', Models::class);

        return response()->json($this->catalogService->components(), 200);
    }

    public function memories() {

        $this->authorize('viewAny', Models::class);

        $mems = $this->catalogService->memory();

        return ComponentResource::collection($mems);
    }

    public function processors() {

        $this->authorize('viewAny', Models::class);

        $prs = $this->catalogService->processor();

        return ComponentResource::collection($prs);        
    }

    public function disks() {

        $this->authorize('viewAny', Models::class);

        $dks =  $this->catalogService->disk();

        return ComponentResource::collection($dks);
    }

    public function licenses() {

        $this->authorize('viewAny', Models::class);

        return response()->json(
            $this->catalogService->license()
        );
        
    }
}
