<?php

namespace Database\Seeders;

use App\Models\Configuracion;
use Illuminate\Database\Seeder;

class ConfiguracionSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            'telefono' => '+34 692 37 28 30',
            'whatsapp' => '+34 692 37 28 30',
            'instagram' => 'https://instagram.com/urquizasoluciones',
            'email' => 'info@urquizasoluciones.es',
            'telefono_urgencias' => '+34 692 37 28 30',
        ];

        foreach ($items as $clave => $valor) {
            Configuracion::set($clave, $valor);
        }
    }
}
