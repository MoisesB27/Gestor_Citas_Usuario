<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserActivityController extends Controller
{
    /**
     * Listar todas las actividades, opcionalmente filtradas por usuario.
     */
    public function index(Request $request)
    {
        $query = UserActivity::query();

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        return response()->json($query->with('user')->get());
    }

    /**
     * Registrar una nueva actividad del usuario.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'       => 'required|uuid|exists:users,id',
            'activity_type' => 'required|string|max:255',
            'description'   => 'nullable|string',
            'ip_address'    => 'nullable|ip',
            'device_info'   => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $activity = UserActivity::create($validator->validated());

        return response()->json($activity, 201);
    }

    /**
     * Mostrar una actividad específica.
     */
    public function show(UserActivity $userActivity)
    {
        return response()->json($userActivity->load('user'));
    }

    /**
     * (Opcional) Actualizar una actividad.
     */
    public function update(Request $request, UserActivity $userActivity)
    {
        $validator = Validator::make($request->all(), [
            'activity_type' => 'sometimes|required|string|max:255',
            'description'   => 'nullable|string',
            'ip_address'    => 'nullable|ip',
            'device_info'   => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $userActivity->update($validator->validated());

        return response()->json($userActivity);
    }

    /**
     * Eliminar un registro de actividad.
     */
    public function destroy(UserActivity $userActivity)
    {
        $userActivity->delete();
        return response()->json(null, 204);
    }
}
