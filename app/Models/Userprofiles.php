<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserProfile extends Model
{
    use HasFactory;

    protected $table = 'user_profiles';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'avatar_url',
        'phone',
        'date_of_birth',
        'cedula',
        'sexo',
        'direccion',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    /**
     * Relación con el modelo User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
