<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Session extends Model
{
    use HasFactory;

    protected $table = 'sessions';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'user_id',
        'ip_address',
        'user_agent',
        'last_activity',
    ];

    protected $casts = [
        'last_activity' => 'integer',
    ];

    /**
     * Relación con el usuario propietario de la sesión.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
