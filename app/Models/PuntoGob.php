<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PuntoGob extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'latitude',
        'longitude',
        'address',
        'government_dependency_id',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    public function governmentDependency()
    {
        return $this->belongsTo(GovernmentDependency::class);
    }
}
