<?php

namespace App\Http\Controllers;

use App\Models\Soporte_Tecnico;
use Illuminate\Http\Request;

class Soporte_TecnicoController extends Controller

{
    public function create()
    {
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'correo_electronico' => 'required|email|max:255',
            'asunto' => 'required|string|max:255',
            'descripcion' => 'required|string',
        ]);

        Soporte_Tecnico::create($request->all());

        return redirect()->back()->with('success', '¡Ticket enviado exitosamente!');
    }
}
