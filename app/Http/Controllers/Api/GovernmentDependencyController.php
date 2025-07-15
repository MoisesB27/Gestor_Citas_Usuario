<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GovernmentDependency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GovernmentDependencyController extends Controller
{
    /**
     * Listar todas las dependencias gubernamentales.
     */
    public function index()
    {
        return response()->json(GovernmentDependency::all());
    }

    /**
     * Crear una nueva dependencia gubernamental.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'                      => 'required|string|max:255',
            'business_hours'           => 'nullable|array',
            'appointment_limit'        => 'nullable|integer|min:0',
            'appointment_limit_per_user' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $dependency = GovernmentDependency::create($validator->validated());

        return response()->json($dependency, 201);
    }

    /**
     * Mostrar una dependencia específica.
     */
    public function show(GovernmentDependency $governmentDependency)
    {
        return response()->json($governmentDependency);
    }

    /**
     * Actualizar una dependencia existente.
     */
    public function update(Request $request, GovernmentDependency $governmentDependency)
    {
        $validator = Validator::make($request->all(), [
            'name'                      => 'sometimes|required|string|max:255',
            'business_hours'           => 'nullable|array',
            'appointment_limit'        => 'nullable|integer|min:0',
            'appointment_limit_per_user' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $governmentDependency->update($validator->validated());

        return response()->json($governmentDependency);
    }

    /**
     * Eliminar una dependencia gubernamental.
     */
    public function destroy(GovernmentDependency $governmentDependency)
    {
        $governmentDependency->delete();
        return response()->json(null, 204);
    }
}
