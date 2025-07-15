<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Ajustar si usas políticas
    }

    public function rules()
    {
        return [
            'email'    => 'required|email',
            'password' => 'required|string',
        ];
    }

    public function authenticate()
    {
        // Intentar autenticación con email y password_hash
        $credentials = $this->only('email', 'password');

        if (!Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            throw ValidationException::withMessages([
                'email' => ['Las credenciales no coinciden con nuestros registros.'],
            ]);
        }
    }
}
