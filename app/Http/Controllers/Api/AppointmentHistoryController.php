<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentHistoryController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $estadoFiltro = $request->query('estado');

        $query = Appointment::with(['service', 'dependency'])
            ->where('user_id', $user->id);

        if ($estadoFiltro) {
            $query->where('status', $estadoFiltro);
        }

        $appointments = $query->orderBy('date', 'desc')->get();

        $estados = [
            'pending'   => 'Pendiente',
            'confirmed' => 'Activo',
            'cancelled' => 'Cancelado',
            'failed'    => 'Fallido',
            'completed' => 'Procesado',
        ];

        return response()->json($appointments->map(function ($item) use ($estados) {
            return [
                'id'         => $item->id,
                'servicio'   => $item->service->name ?? 'Sin nombre',
                'institucion'=> $item->dependency->name ?? 'Sin institución',
                'fecha'      => \Carbon\Carbon::parse($item->date)->format('Y-m-d'),
                'hora'       => \Carbon\Carbon::parse($item->time)->format('h:i A'),
                'estado'     => $estados[$item->status] ?? ucfirst($item->status),
                'ticket_url' => route('tickets.show', $item->id), 
            ];
        }));
    }
}
