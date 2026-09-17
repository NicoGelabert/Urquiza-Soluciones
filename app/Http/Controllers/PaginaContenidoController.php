<?php

namespace App\Http\Controllers;

use App\Models\PaginaContenido;
use Inertia\Inertia;

class PaginaContenidoController extends Controller
{
    public function index()
    {
        return Inertia::render('Contenido/Index');
    }

    public function edit(PaginaContenido $contenido)
    {
        return Inertia::render('Contenido/Edit', ['id' => $contenido->id]);
    }
}
