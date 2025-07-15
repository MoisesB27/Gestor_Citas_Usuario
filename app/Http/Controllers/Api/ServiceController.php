<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    /**
     * Listar todos los servicios.
     */
    public function index()
    {
        return response()->json(Service::with('tramite')->get());
    }

    /**
     * Registrar un nuevo servicio.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration'    => 'required|integer|min:0',
            'tramite_id'  => 'required|uuid|exists:tramites,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $service = Service::create($validator->validated());

        return response()->json($service, 201);
    }

    /**
     * Mostrar un servicio específico.
     */
    public function show(Service $service)
    {
        return response()->json($service->load('tramite'));
    }

    /**
     * Actualizar un servicio.
     */
    public function update(Request $request, Service $service)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'duration'    => 'sometimes|required|integer|min:0',
            'tramite_id'  => 'sometimes|required|uuid|exists:tramites,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $service->update($validator->validated());

        return response()->json($service);
    }

    /**
     * Eliminar un servicio.
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return response()->json(null, 204);
    }
}
