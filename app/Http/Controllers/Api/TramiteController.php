<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tramite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TramiteController extends Controller
{
    /**
     * Listar todos los trámites.
     */
    public function index()
    {
        $tramites = Tramite::with('dependency')->get();
        return response()->json($tramites);
    }

    /**
     * Crear un nuevo trámite.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string',
            'dependency_id'    => 'required|uuid|exists:government_dependencies,id',
            'mandatory_fields' => 'nullable|array', // Será convertido automáticamente a JSON
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $tramite = Tramite::create($validator->validated());

        return response()->json($tramite, 201);
    }

    /**
     * Mostrar un trámite específico.
     */
    public function show(Tramite $tramite)
    {
        return response()->json($tramite->load('dependency'));
    }

    /**
     * Actualizar un trámite existente.
     */
    public function update(Request $request, Tramite $tramite)
    {
        $validator = Validator::make($request->all(), [
            'name'             => 'sometimes|required|string|max:255',
            'description'      => 'nullable|string',
            'dependency_id'    => 'sometimes|required|uuid|exists:government_dependencies,id',
            'mandatory_fields' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $tramite->update($validator->validated());

        return response()->json($tramite);
    }

    /**
     * Eliminar un trámite.
     */
    public function destroy(Tramite $tramite)
    {
        $tramite->delete();
        return response()->json(null, 204);
    }
}
