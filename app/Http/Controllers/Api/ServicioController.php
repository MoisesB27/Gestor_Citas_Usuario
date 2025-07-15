<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AppointmentServicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServicioController extends Controller
{
    /**
     * Listar servicios asignados a una cita específica.
     */
    public function index(Request $request)
    {
        $appointmentId = $request->query('appointment_id');

        if (!$appointmentId) {
            return response()->json(['error' => 'appointment_id es requerido.'], 400);
        }

        $servicios = AppointmentServicio::where('appointment_id', $appointmentId)->get();

        return response()->json($servicios);
    }

    /**
     * Asociar un nuevo servicio a una cita.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'appointment_id'    => 'required|uuid|exists:appointments,id',
            'service_id'        => 'required|uuid|exists:services,id',
            'quantity'          => 'nullable|integer|min:1',
            'special_requests'  => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $validator->validated();

        $servicio = AppointmentServicio::create($data);

        return response()->json($servicio, 201);
    }

    /**
     * Mostrar un servicio específico asignado a una cita.
     */
    public function show($appointment_id, $service_id)
    {
        $servicio = AppointmentServicio::where('appointment_id', $appointment_id)
            ->where('service_id', $service_id)
            ->first();

        if (!$servicio) {
            return response()->json(['error' => 'Servicio no encontrado para esa cita.'], 404);
        }

        return response()->json($servicio);
    }

    /**
     * Actualizar un servicio asignado a una cita.
     */
    public function update(Request $request, $appointment_id, $service_id)
    {
        $servicio = AppointmentServicio::where('appointment_id', $appointment_id)
            ->where('service_id', $service_id)
            ->first();

        if (!$servicio) {
            return response()->json(['error' => 'Servicio no encontrado para esa cita.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'quantity'          => 'nullable|integer|min:1',
            'special_requests'  => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $servicio->update($validator->validated());

        return response()->json($servicio);
    }

    /**
     * Eliminar un servicio asignado a una cita.
     */
    public function destroy($appointment_id, $service_id)
    {
        $servicio = AppointmentServicio::where('appointment_id', $appointment_id)
            ->where('service_id', $service_id)
            ->first();

        if (!$servicio) {
            return response()->json(['error' => 'Servicio no encontrado para esa cita.'], 404);
        }

        $servicio->delete();

        return response()->json(null, 204);
    }
}
