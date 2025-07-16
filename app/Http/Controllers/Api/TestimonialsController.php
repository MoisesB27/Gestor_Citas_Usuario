<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    // Obtener todos los testimonios 
    public function index()
    {
        return response()->json(Testimonial::latest()->get());
    }

    // Crear un nuevo testimonio 
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255',
            'message' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'photo_url' => 'nullable|url',
        ]);

        $testimonial = Testimonial::create($request->all());

        return response()->json([
            'message' => 'Testimonio creado exitosamente.',
            'data' => $testimonial
        ], 201);
    }
}
