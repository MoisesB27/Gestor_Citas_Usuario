<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AppointmentAccessLog extends Model
{
    use HasFactory;

    protected $table = 'appointment_access_logs';

    protected $fillable = [
        'appointment_id',
        'accessed_at',
        'ip_address',
    ];

    protected $casts = [
        'accessed_at' => 'datetime',
    ];

    /**
     * Relación con Appointment.
     */
    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }
}
