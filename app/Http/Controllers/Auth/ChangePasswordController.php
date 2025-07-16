<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function update(ChangePasswordRequest $request): JsonResponse
    {
        $user = Auth::user();
        if (!method_exists($user, 'save')) {
            $user = \App\Models\User::find($user->id);
        }

        if (! Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'La contraseña actual no es válida.'], 403);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Contraseña actualizada correctamente.']);
    }
}
