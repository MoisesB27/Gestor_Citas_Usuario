<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordConfirmRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordConfirmController extends Controller
{
    public function confirm(PasswordConfirmRequest $request): JsonResponse
    {
        if (! Hash::check($request->password, Auth::user()->password)) {
            return response()->json(['message' => 'Contraseña incorrecta.'], 403);
        }

        return response()->json(['message' => 'Confirmación exitosa.'], 200);
    }
}
