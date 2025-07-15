<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserNotificationController extends Controller
{
    /**
     * Listar todas las notificaciones, opcionalmente por usuario.
     */
    public function index(Request $request)
    {
        $query = UserNotification::with('user');

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        return response()->json($query->latest()->get());
    }

    /**
     * Crear una nueva notificación.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|uuid|exists:users,id',
            'type'    => 'required|string|max:255',
            'message' => 'required|string',
            'metadata'=> 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $notification = UserNotification::create(array_merge(
            $validator->validated(),
            ['is_read' => false]
        ));

        return response()->json($notification, 201);
    }

    /**
     * Mostrar una notificación específica.
     */
    public function show(UserNotification $userNotification)
    {
        return response()->json($userNotification->load('user'));
    }

    /**
     * Marcar como leída o actualizar tipo/mensaje/metadatos.
     */
    public function update(Request $request, UserNotification $userNotification)
    {
        $validator = Validator::make($request->all(), [
            'is_read'  => 'sometimes|required|boolean',
            'type'     => 'sometimes|required|string|max:255',
            'message'  => 'sometimes|required|string',
            'metadata' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $userNotification->update($validator->validated());

        return response()->json($userNotification);
    }

    /**
     * Eliminar una notificación.
     */
    public function destroy(UserNotification $userNotification)
    {
        $userNotification->delete();
        return response()->json(null, 204);
    }
}
