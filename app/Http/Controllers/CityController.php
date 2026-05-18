<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;

class CityController extends Controller
{
    public function index() {
        $this->authorize('viewAny', City::class);

        return response()->json([
            'data' => City::all()
        ], 200);
    }
}
