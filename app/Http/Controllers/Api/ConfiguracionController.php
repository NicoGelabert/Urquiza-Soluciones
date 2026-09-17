<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConfiguracionRequest;
use App\Models\Configuracion;

class ConfiguracionController extends Controller
{
    public function show()
    {
        return response()->json([
            'telefono' => Configuracion::get('telefono'),
            'whatsapp' => Configuracion::get('whatsapp'),
            'instagram' => Configuracion::get('instagram'),
            'email' => Configuracion::get('email'),
            'telefono_urgencias' => Configuracion::get('telefono_urgencias'),
        ]);
    }

    public function update(ConfiguracionRequest $request)
    {
        foreach ($request->validated() as $clave => $valor) {
            Configuracion::set($clave, $valor);
        }

        return $this->show();
    }
}
