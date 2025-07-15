<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Listar todos los usuarios.
     */
    public function index()
    {
        return response()->json(User::all());
    }

    /**
     * Registrar un nuevo usuario.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:users,username',
            'name'    => 'required|string|max:255', 
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'status'   => 'in:active,inactive,suspended', // si usas estados limitados
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Se usa el mutator para password_hash
        $data = $validator->validated();
        $data['password_hash'] = bcrypt($data['password']);
        unset($data['password']);

        $user = User::create($data);

        return response()->json($user, 201);
    }

    /**
     * Mostrar un usuario específico.
     */
    public function show(User $user)
    {
        return response()->json($user);
    }

    /**
     * Actualizar los datos del usuario.
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'sometimes|required|string|unique:users,username,' . $user->id,
            'name'    => 'sometimes|required|string|max:255',
            'email'    => 'sometimes|required|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|required|string|min:6',
            'status'   => 'sometimes|in:active,inactive,suspended',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $validator->validated();

        if (isset($data['password'])) {
            $data['password_hash'] = bcrypt($data['password']);
            unset($data['password']);
        }

        $user->update($data);

        return response()->json($user);
    }

    /**
     * Eliminar un usuario.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }
}
