<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use Inertia\Inertia;

class SolicitudController extends Controller
{
    public function index()
    {
        return Inertia::render('Solicitudes/Index');
    }

    public function show(Solicitud $solicitud)
    {
        return Inertia::render('Solicitudes/Show', ['id' => $solicitud->id]);
    }
}
