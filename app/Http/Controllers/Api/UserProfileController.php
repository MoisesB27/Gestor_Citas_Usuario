<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserProfileController extends Controller
{
    /**
     * Mostrar el perfil de un usuario.
     */
    public function show($user_id)
    {
        $profile = UserProfile::with('user')->findOrFail($user_id);
        return response()->json($profile);
    }

    /**
     * Crear o actualizar perfil de usuario.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'     => 'required|uuid|exists:users,id',
            'first_name'  => 'required|string|max:255',
            'last_name'   => 'required|string|max:255',
            'avatar_url'  => 'nullable|string',
            'phone'       => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'cedula'      => 'nullable|string|max:20',
            'sexo'        => 'nullable|string|max:10',
            'direccion'   => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $profile = UserProfile::updateOrCreate(
            ['user_id' => $request->user_id],
            $validator->validated()
        );

        return response()->json($profile, 201);
    }

    /**
     * Actualizar parcialmente el perfil.
     */
    public function update(Request $request, $user_id)
    {
        $profile = UserProfile::findOrFail($user_id);

        $validator = Validator::make($request->all(), [
            'first_name'  => 'sometimes|required|string|max:255',
            'last_name'   => 'sometimes|required|string|max:255',
            'avatar_url'  => 'nullable|string',
            'phone'       => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'cedula'      => 'nullable|string|max:20',
            'sexo'        => 'nullable|string|max:10',
            'direccion'   => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $profile->update($validator->validated());

        return response()->json($profile);
    }

    /**
     * Eliminar el perfil del usuario.
     */
    public function destroy($user_id)
    {
        $profile = UserProfile::findOrFail($user_id);
        $profile->delete();
        return response()->json(null, 204);
    }
}
