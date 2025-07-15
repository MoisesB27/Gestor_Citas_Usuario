<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    /**
     * Registrar una nueva solicitud de reseteo de contraseña.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $token = Str::random(60);

        PasswordReset::updateOrCreate(
            ['email' => $request->email],
            [
                'token' => $token,
                'created_at' => now()
            ]
        );

        // Aquí podrías despachar un evento para enviar el correo

        return response()->json(['token' => $token], 201);
    }

    /**
     * Verificar si el token es válido.
     */
    public function show($token)
    {
        $record = PasswordReset::where('token', $token)->first();

        if (!$record) {
            return response()->json(['error' => 'Token inválido o expirado'], 404);
        }

        // Opcional: verificar si el token expiró (por ejemplo, 60 minutos)
        if (Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            return response()->json(['error' => 'Token expirado'], 410);
        }

        return response()->json($record);
    }

    /**
     * Eliminar una solicitud (por seguridad o limpieza).
     */
    public function destroy($email)
    {
        PasswordReset::where('email', $email)->delete();

        return response()->json(null, 204);
    }
}
