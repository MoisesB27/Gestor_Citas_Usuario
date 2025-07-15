<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        Log::info('Intento de login para email: ' . $request->email);

        try {
            // Autenticar con LoginRequest (Auth::attempt)
            $request->authenticate();

            // Obtener usuario autenticado vía facade Auth para evitar query extra
            $user = User::where('email', $request->email)->first();

            // Validar que el usuario esté activo
            if ($user->status !== 'active') {
                Log::warning("Usuario {$user->email} bloqueado o inactivo.");
                return response()->json([
                    'status' => 'error',
                    'message' => 'Usuario bloqueado o inactivo.',
                ], 403);
            }

            // Crear token con scopes (puedes definir scopes si quieres)
            $token = $user->createToken('api-token', ['*'])->plainTextToken;

            Log::info("Usuario {$user->email} autenticado exitosamente.");

            return response()->json([
                'status'  => 'success',
                'message' => 'Autenticación exitosa',
                'token'   => $token,
                'user'    => new UserResource($user),
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Login fallido para email: ' . $request->email);
            return response()->json([
                'status'  => 'error',
                'message' => 'Credenciales inválidas o demasiados intentos. Intenta más tarde.',
                'errors'  => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            Log::error('Error interno en login: ' . $e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Error interno del servidor. Intenta nuevamente más tarde.',
            ], 500);
        }
    }
}
