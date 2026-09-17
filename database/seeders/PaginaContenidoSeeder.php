<?php

namespace Database\Seeders;

use App\Models\PaginaContenido;
use Illuminate\Database\Seeder;

class PaginaContenidoSeeder extends Seeder
{
    public function run(): void
    {
        $bloques = [
            [
                'clave' => 'sobre_nosotros',
                'titulo' => ['es' => 'Estamos en Málaga!', 'en' => 'We are in Málaga!'],
                'contenido' => [
                    'es' => 'Bienvenido a Urquiza Soluciones, somos una empresa que entiende la importancia de contar con sistemas de climatización eficientes, instalaciones eléctricas seguras y sistemas de fontanería confiables en su hogar o negocio. Por eso, nos enorgullece ofrecer servicios de primera calidad que garantizan su comodidad y tranquilidad en todo momento. Nuestra zona de acción comprende la Costa del Sol desde Málaga hasta Marbella.',
                    'en' => 'Welcome to Urquiza Soluciones, we are a company that understands the importance of efficient air conditioning systems, safe electrical installations and reliable plumbing systems in your home or business. We are proud to offer first-class services that guarantee your comfort and peace of mind at all times. Our service area covers the Costa del Sol from Málaga to Marbella.',
                ],
            ],
            [
                'clave' => 'zona_trabajo',
                'titulo' => ['es' => 'Zona de trabajo', 'en' => 'Service area'],
                'contenido' => null,
                'datos_extra' => [
                    'ciudades' => [
                        ['es' => 'Málaga', 'en' => 'Málaga'],
                        ['es' => 'Torremolinos', 'en' => 'Torremolinos'],
                        ['es' => 'Benalmádena', 'en' => 'Benalmádena'],
                        ['es' => 'Los Boliches', 'en' => 'Los Boliches'],
                        ['es' => 'Mijas', 'en' => 'Mijas'],
                        ['es' => 'Fuengirola', 'en' => 'Fuengirola'],
                        ['es' => 'Calahonda', 'en' => 'Calahonda'],
                        ['es' => 'Marbella', 'en' => 'Marbella'],
                    ],
                ],
            ],
            [
                'clave' => 'servicios_intro',
                'titulo' => ['es' => 'Nuestros servicios incluyen', 'en' => 'Our services include'],
                'contenido' => null,
                'datos_extra' => [
                    'items' => [
                        [
                            'titulo' => ['es' => 'Instalación y mantenimiento de aires acondicionados', 'en' => 'Air conditioning installation and maintenance'],
                            'contenido' => ['es' => 'Desde la selección del equipo adecuado hasta la instalación impecable y el mantenimiento periódico, nos encargamos de mantener su ambiente fresco y confortable durante todo el año.', 'en' => 'From selecting the right equipment to flawless installation and periodic maintenance, we keep your environment cool and comfortable all year round.'],
                        ],
                        [
                            'titulo' => ['es' => 'Servicios de electricidad', 'en' => 'Electrical services'],
                            'contenido' => ['es' => 'Ya sea que necesite una instalación eléctrica completa, reparaciones o actualizaciones, nuestro equipo de electricistas garantiza la seguridad y funcionalidad de sus sistemas eléctricos.', 'en' => 'Whether you need a complete electrical installation, repairs or upgrades, our team of electricians guarantees the safety and functionality of your electrical systems.'],
                        ],
                        [
                            'titulo' => ['es' => 'Soluciones de fontanería', 'en' => 'Plumbing solutions'],
                            'contenido' => ['es' => 'Desde la reparación de fugas hasta la instalación de sistemas de agua caliente, nuestros fontaneros experimentados están preparados para abordar cualquier desafío.', 'en' => 'From leak repair to hot water system installation, our experienced plumbers are ready to tackle any challenge.'],
                        ],
                    ],
                ],
            ],
            [
                'clave' => 'urgencias',
                'titulo' => ['es' => '¿Tiene una urgencia? Contáctenos.', 'en' => 'Have an emergency? Contact us.'],
                'contenido' => ['es' => 'Urgencias', 'en' => 'Emergencies'],
            ],
            [
                'clave' => 'contacto_intro',
                'titulo' => ['es' => 'Contacto', 'en' => 'Contact'],
                'contenido' => [
                    'es' => 'Si tiene más consultas, no dude en ponerse en contacto con nosotros.',
                    'en' => 'If you have any questions, please do not hesitate to contact us.',
                ],
            ],
            [
                'clave' => 'faq_titulo',
                'titulo' => ['es' => 'Preguntas frecuentes', 'en' => 'Frequently asked questions'],
                'contenido' => null,
            ],
        ];

        foreach ($bloques as $bloque) {
            PaginaContenido::query()->create($bloque);
        }
    }
}
