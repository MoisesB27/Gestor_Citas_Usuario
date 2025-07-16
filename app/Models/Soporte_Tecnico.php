<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Soporte_Tecnico extends Model

{
    protected $fillable = [
        'nombre_completo',
        'correo_electronico',
        'asunto',
        'descripcion',
    ];
}
