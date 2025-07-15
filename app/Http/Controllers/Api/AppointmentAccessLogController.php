<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AppointmentAccessLog;
use Illuminate\Http\Request;

class AppointmentAccessLogController extends Controller
{
    /**
     * Mostrar todos los registros de acceso a citas.
     */
    public function index()
    {
        return response()->json(AppointmentAccessLog::with('appointment')->get());
    }

    /**
     * Registrar un nuevo acceso a una cita.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'appointment_id' => 'required|uuid|exists:appointments,id',
            'ip_address'     => 'nullable|ip',
            'accessed_at'    => 'nullable|date',
        ]);

        $log = AppointmentAccessLog::create($validated);

        return response()->json($log, 201);
    }

    /**
     * Mostrar un registro específico.
     */
    public function show(AppointmentAccessLog $appointmentAccessLog)
    {
        return response()->json($appointmentAccessLog->load('appointment'));
    }

    /**
     * Actualizar un registro (rara vez se hace, pero disponible).
     */
    public function update(Request $request, AppointmentAccessLog $appointmentAccessLog)
    {
        $validated = $request->validate([
            'ip_address'  => 'nullable|ip',
            'accessed_at' => 'nullable|date',
        ]);

        $appointmentAccessLog->update($validated);

        return response()->json($appointmentAccessLog);
    }

    /**
     * Eliminar un registro de acceso (opcional).
     */
    public function destroy(AppointmentAccessLog $appointmentAccessLog)
    {
        $appointmentAccessLog->delete();

        return response()->json(null, 204);
    }
}
