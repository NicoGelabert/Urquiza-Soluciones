<?php

namespace App\Services;

use App\Enums\SolicitudEstado;
use App\Enums\SolicitudTipo;
use App\Mail\SolicitudConfirmacionUsuario;
use App\Mail\SolicitudNotificacionAdmin;
use App\Models\Configuracion;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SolicitudFormService
{
    public function store(array $data, SolicitudTipo $tipo, Request $request): Solicitud
    {
        $solicitud = Solicitud::query()->create([
            'tipo' => $tipo,
            'estado' => SolicitudEstado::Pendiente,
            'nombre' => $data['nombre'],
            'email' => $data['email'],
            'telefono' => $data['telefono'] ?? null,
            'mensaje' => $data['mensaje'],
            'servicio_id' => $data['servicio_id'] ?? null,
            'zona' => $data['zona'] ?? null,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $adminEmail = Configuracion::get('email') ?? config('legal.contact_email');

        Mail::to($adminEmail)->send(new SolicitudNotificacionAdmin($solicitud));
        Mail::to($solicitud->email)->send(new SolicitudConfirmacionUsuario($solicitud));

        return $solicitud;
    }
}
