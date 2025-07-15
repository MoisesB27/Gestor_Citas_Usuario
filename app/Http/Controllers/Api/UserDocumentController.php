<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class UserDocumentController extends Controller
{
    /**
     * Listar todos los documentos o filtrados por usuario.
     */
    public function index(Request $request)
    {
        $query = UserDocument::with('user');

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        return response()->json($query->get());
    }

    /**
     * Subir un nuevo documento.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'       => 'required|uuid|exists:users,id',
            'document_type' => 'required|string|max:255',
            'file'          => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // 2MB max
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Guardar archivo
        $path = $request->file('file')->store('documents', 'public');

        $document = UserDocument::create([
            'user_id'       => $request->user_id,
            'document_type' => $request->document_type,
            'file_url'      => $path,
            'status'        => 'pending',
        ]);

        return response()->json($document, 201);
    }

    /**
     * Mostrar un documento específico.
     */
    public function show(UserDocument $userDocument)
    {
        return response()->json($userDocument->load('user'));
    }

    /**
     * Actualizar el estado o archivo del documento.
     */
    public function update(Request $request, UserDocument $userDocument)
    {
        $validator = Validator::make($request->all(), [
            'status'      => 'in:pending,verified,rejected',
            'verified_at' => 'nullable|date',
            'file'        => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $validator->validated();

        if ($request->hasFile('file')) {
            // Borrar archivo anterior si existe
            if ($userDocument->file_url) {
                Storage::disk('public')->delete($userDocument->file_url);
            }
            $data['file_url'] = $request->file('file')->store('documents', 'public');
        }

        $userDocument->update($data);

        return response()->json($userDocument);
    }

    /**
     * Eliminar un documento.
     */
    public function destroy(UserDocument $userDocument)
    {
        if ($userDocument->file_url) {
            Storage::disk('public')->delete($userDocument->file_url);
        }

        $userDocument->delete();
        return response()->json(null, 204);
    }
}
