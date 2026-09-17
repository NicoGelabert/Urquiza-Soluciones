<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class ConfiguracionController extends Controller
{
    public function edit()
    {
        return Inertia::render('Configuracion/Edit');
    }
}
