<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Computer;
use App\Models\ComputerModel;
use App\Http\Requests\IndexCatalogRequest;
use App\Http\Requests\StoreCatalogRequest;
use App\Services\Asset\Computer\CatalogService;

class CatalogController extends Controller
{
    public function __construct(
        protected CatalogService $catalogService
    )
    {
        $this->middleware('auth:sanctum');
    }

    public function index(IndexCatalogRequest $request) {

       $this->authorize('viewAny', ComputerModel::class);

        return response()->json(
            $this->catalogService->catalog($request->validated(), $request->integer('perPage', 15)) 
        );
    }

    public function store(StoreCatalogModelRequest $request) {

        $this->authorize('create', ComputerModel::class);



    }

    public function update() {

        $this->authorize('update', ComputerModel::class);
    }

    public function memories() {

        $this->authorize('view', ComputerModel::class);

        return response()->json(
            $this->catalogService->memory()
        );
    }

    public function brands() {

        $this->authorize('view', ComputerModel::class);

        return response()->json(
            $this->catalogService->brand()
        );
        
    }

    public function processors() {

        $this->authorize('view', ComputerModel::class);

        return response()->json(
            $this->catalogService->processor()
        );
        
    }

    public function disks() {

        $this->authorize('view', ComputerModel::class);

        return response()->json(
            $this->catalogService->disk()
        );
        
    }

    public function licenses() {

        $this->authorize('view', ComputerModel::class);

        return response()->json(
            $this->catalogService->license()
        );
        
    }
}
