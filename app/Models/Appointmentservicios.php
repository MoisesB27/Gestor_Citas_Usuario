<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AppointmentServicio extends Pivot
{
    use HasFactory;

    protected $table = 'appointment_servicios';

    public $incrementing = false; // porque la PK es compuesta
    protected $keyType = 'string';

    protected $fillable = [
        'appointment_id',
        'service_id',
        'quantity',
        'special_requests',
    ];

    /**
     * Campos de fecha para timestamps.
     */
    public $timestamps = true;
}
