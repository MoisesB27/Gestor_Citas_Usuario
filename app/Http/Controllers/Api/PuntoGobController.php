<?php

namespace App\Http\Controllers;

use App\Models\PuntoGob;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PuntoGobController extends Controller
{
    public function index()
    {
        return PuntoGob::with('governmentDependency')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'address' => 'nullable|string',
            'government_dependency_id' => 'required|uuid|exists:government_dependencies,id',
        ]);

        $data['id'] = Str::uuid();

        $punto = PuntoGob::create($data);

        return response()->json($punto, 201);
    }
}
