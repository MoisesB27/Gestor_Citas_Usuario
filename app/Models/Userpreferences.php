<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserPreference extends Model
{
    use HasFactory;

    protected $table = 'user_preferences';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id',
        'theme',
        'notification_preferences',
        'privacy_settings',
    ];

    protected $casts = [
        'notification_preferences' => 'array',
        'privacy_settings' => 'array',
    ];

    /**
     * Relación con User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
