<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'assigned_to',
        'dependency_id',
        'service_id',
        'date',
        'time',
        'start_time',
        'end_time',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'time',
        'start_time' => 'time',
        'end_time' => 'time',
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
     * Usuario que creó la cita.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Usuario asignado (puede ser null).
     */
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Dependencia gubernamental.
     */
    public function dependency()
    {
        return $this->belongsTo(GovernmentDependency::class, 'dependency_id');
    }

    /**
     * Servicio asociado.
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    /**
     * Relación con AppointmentAccessLog.
     */
    public function access_logs()
    {
        return $this->hasMany(AppointmentAccessLog::class);
    }

}
