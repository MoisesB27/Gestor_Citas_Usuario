<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    /**
     * Listar todas las citas.
     */
    public function index()
    {
        $appointments = Appointment::with(['user', 'assignedTo', 'dependency', 'service'])->get();
        return response()->json($appointments);
    }

    /**
     * Crear una nueva cita.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'       => 'required|uuid|exists:users,id',
            'assigned_to'   => 'nullable|uuid|exists:users,id',
            'dependency_id' => 'required|uuid|exists:government_dependencies,id',
            'service_id'    => 'required|uuid|exists:services,id',
            'date'          => 'required|date',
            'time'          => 'required|date_format:H:i',
            'start_time'    => 'nullable|date_format:H:i',
            'end_time'      => 'nullable|date_format:H:i',
            'status'        => 'nullable|string|in:pending,confirmed,cancelled,completed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $appointment = Appointment::create($validator->validated());

        return response()->json($appointment, 201);
    }

    /**
     * Mostrar una cita específica.
     */
    public function show(Appointment $appointment)
    {
        $appointment->load(['user', 'assignedTo', 'dependency', 'service', 'access_logs']);
        return response()->json($appointment);
    }

    /**
     * Actualizar una cita.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $validator = Validator::make($request->all(), [
            'assigned_to'   => 'nullable|uuid|exists:users,id',
            'dependency_id' => 'nullable|uuid|exists:government_dependencies,id',
            'service_id'    => 'nullable|uuid|exists:services,id',
            'date'          => 'nullable|date',
            'time'          => 'nullable|date_format:H:i',
            'start_time'    => 'nullable|date_format:H:i',
            'end_time'      => 'nullable|date_format:H:i',
            'status'        => 'nullable|string|in:pending,confirmed,cancelled,completed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $appointment->update($validator->validated());

        return response()->json($appointment);
    }

    /**
     * Eliminar una cita.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return response()->json(null, 204);
    }
}
