<?php

namespace App\Http\Controllers;

use App\Models\Configuracion;
use App\Models\Solicitud;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Dashboard', [
            'stats' => [
                'solicitudes_pendientes' => Solicitud::query()->where('estado', 'pendiente')->count(),
                'servicios_activos' => \App\Models\Servicio::query()->where('activo', true)->count(),
            ],
            'contacto' => [
                'telefono' => Configuracion::get('telefono'),
                'email' => Configuracion::get('email'),
            ],
        ]);
    }
}
