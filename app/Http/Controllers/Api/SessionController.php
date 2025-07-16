<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SessionController extends Controller
{
    /**
     * Listar todas las sesiones (o filtradas por usuario).
     */
    public function index(Request $request)
    {
        $query = Session::query();

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        return response()->json($query->with('user')->get());
    }

    /**
     * Crear una sesión manualmente (rara vez se usa, normalmente gestionado automáticamente).
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'           => 'required|string|unique:sessions,id',
            'user_id'      => 'required|uuid|exists:users,id',
            'ip_address'   => 'nullable|ip',
            'user_agent'   => 'nullable|string',
            'payload'      => 'nullable|string',
            'last_activity'=> 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $session = Session::create($validator->validated());

        return response()->json($session, 201);
    }

    /**
     * Mostrar una sesión específica.
     */
    public function show(Session $session)
    {
        return response()->json($session->load('user'));
    }

    /**
     * Actualizar información de una sesión (opcional).
     */
    public function update(Request $request, Session $session)
    {
        $validator = Validator::make($request->all(), [
            'ip_address'    => 'nullable|ip',
            'user_agent'    => 'nullable|string',
            'payload'       => 'nullable|string',
            'last_activity' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $session->update($validator->validated());

        return response()->json($session);
    }

    /**
     * Eliminar (cerrar) una sesión.
     */
    public function destroy(Session $session)
    {
        $session->delete();
        return response()->json(null, 204);
    }
}
