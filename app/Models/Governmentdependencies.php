<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class GovernmentDependency extends Model
{
    use HasFactory;

    protected $table = 'government_dependencies';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'business_hours',
        'appointment_limit',
        'appointment_limit_per_user',
    ];

    protected $casts = [
        'business_hours' => 'array', // Para usar como arreglo en PHP
    ];

    /**
     * Asigna UUID automáticamente al crear el modelo.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }
}
