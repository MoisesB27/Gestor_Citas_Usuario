<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserPreference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserPreferenceController extends Controller
{
    /**
     * Mostrar preferencias de un usuario por ID.
     */
    public function show($user_id)
    {
        $preference = UserPreference::with('user')->findOrFail($user_id);
        return response()->json($preference);
    }

    /**
     * Crear o actualizar preferencias del usuario.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'                  => 'required|uuid|exists:users,id',
            'theme'                    => 'nullable|in:light,dark',
            'notification_preferences' => 'nullable|array',
            'privacy_settings'         => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $validator->validated();

        $preference = UserPreference::updateOrCreate(
            ['user_id' => $data['user_id']],
            $data
        );

        return response()->json($preference, 201);
    }

    /**
     * Actualizar preferencias parcialmente.
     */
    public function update(Request $request, $user_id)
    {
        $preference = UserPreference::findOrFail($user_id);

        $validator = Validator::make($request->all(), [
            'theme'                    => 'nullable|in:light,dark',
            'notification_preferences' => 'nullable|array',
            'privacy_settings'         => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $preference->update($validator->validated());

        return response()->json($preference);
    }

    /**
     * Eliminar preferencias de usuario (opcional).
     */
    public function destroy($user_id)
    {
        $preference = UserPreference::findOrFail($user_id);
        $preference->delete();
        return response()->json(null, 204);
    }
}
