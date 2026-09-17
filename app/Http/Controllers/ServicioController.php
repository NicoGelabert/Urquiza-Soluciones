<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Inertia\Inertia;

class ServicioController extends Controller
{
    public function index()
    {
        return Inertia::render('Servicios/Index');
    }

    public function create()
    {
        return Inertia::render('Servicios/Create');
    }

    public function edit(Servicio $servicio)
    {
        return Inertia::render('Servicios/Edit', ['id' => $servicio->id]);
    }
}
