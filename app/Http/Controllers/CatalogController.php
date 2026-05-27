<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\Models\Computer;
use App\Models\Models;
// Requests
use App\Http\Requests\IndexCatalogRequest;
use App\Http\Requests\StoreCatalogRequest;
// Services
use App\Services\Asset\Computer\CatalogService;
// Resources
use App\Http\Resources\ComponentResource;

class CatalogController extends Controller
{
    public function __construct(
        protected CatalogService $catalogService
    )
    {
        $this->middleware('auth:sanctum');
    }

    public function index(IndexCatalogRequest $request) {

       $this->authorize('viewAny', Models::class);

        return response()->json(
            $this->catalogService->catalog($request->validated(), $request->integer('perPage', 15)) 
        );
    }

    public function store(StoreCatalogRequest $request) {

        $this->authorize('create', Models::class);

    }

    public function update() {

        $this->authorize('update', Models::class);
    }

    public function memories() {

        $this->authorize('viewAny', Models::class);

        $mems = $this->catalogService->memory();

        return ComponentResource::collection($mems);
    }

    public function brands() {

        $this->authorize('viewAny', Models::class);

        return response()->json(
            $this->catalogService->brand()
        );
        
    }

    public function processors() {

        $this->authorize('viewAny', Models::class);

        $prs = $this->catalogService->processor();

        return ComponentResource($prs);        
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
