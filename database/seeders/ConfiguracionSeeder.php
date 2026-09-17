<?php

namespace Database\Seeders;

use App\Models\Configuracion;
use Illuminate\Database\Seeder;

class ConfiguracionSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            'telefono' => '+34900000000',
            'whatsapp' => '+34900000000',
            'instagram' => 'https://instagram.com/urquizasoluciones',
            'email' => 'info@urquizasoluciones.es',
            'telefono_urgencias' => '+34900000000',
        ];

        foreach ($items as $clave => $valor) {
            Configuracion::set($clave, $valor);
        }
    }
}
