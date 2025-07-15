<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Tramite extends Model
{
    use HasFactory;

    protected $table = 'tramites';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'description',
        'dependency_id',
        'mandatory_fields',
    ];

    protected $casts = [
        'mandatory_fields' => 'array',
    ];

    /**
     * Generar UUID automáticamente.
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

    /**
     * Relación con GovernmentDependency.
     */
    public function dependency()
    {
        return $this->belongsTo(GovernmentDependency::class, 'dependency_id');
    }
}
