<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index() {
        $this->authorize('viewAny', Area::class);

        return response()->json([
            'data' => Area::all()
        ], 200);
    }
}
