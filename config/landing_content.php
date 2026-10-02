<?php

/**
 * Copy and structure for campaign landings (ES-first).
 * {ciudad} is replaced with ?ciudad= query or default_ciudad.
 */
return [
    'views' => [
        'aires-acondicionados' => 'Public/Landing/Campaign',
        'electricidad' => 'Public/Landing/Campaign',
    ],

    'shared_work_photos' => [
        '/images/landing/aires/trabajo-1.jpg',
        '/images/landing/aires/trabajo-2.jpg',
        '/images/landing/aires/trabajo-3.jpg',
        '/images/landing/aires/trabajo-real-1.jpg',
        '/images/landing/aires/trabajo-real-2.jpg',
        '/images/landing/aires/trabajo-real-3.jpg',
    ],

    'aires-acondicionados' => [
        'default_ciudad' => 'Málaga y la Costa del Sol',
        'h1' => 'Instalación de aire acondicionado en {ciudad}',
        'subheadline' => [
            ['text' => 'Instalador certificado RITE', 'emphasis' => true],
            ['text' => 'Presupuesto sin cargo'],
            ['text' => 'Respuesta en el día'],
        ],
        'closing_title' => '¿Hablamos de tu aire acondicionado?',
        'closing_sub' => 'Presupuesto sin cargo · respuesta en el día',
        'trust' => [
            ['title' => 'Matrícula RITE', 'desc' => 'Instalaciones conforme a normativa', 'icon' => 'shield'],
            ['title' => 'Reseñas en Google', 'desc' => 'Clientes satisfechos en la zona', 'icon' => 'star'],
            ['title' => 'Zona de servicio', 'desc' => 'Costa del Sol', 'icon' => 'map-pin'],
            ['title' => 'Respuesta en el día', 'desc' => 'Te llamamos lo antes posible', 'icon' => 'clock'],
        ],
        'service_blocks' => [
            [
                'title' => 'Instalación',
                'desc' => 'Split, conductos y equipos de las principales marcas, con puesta en marcha y prueba de rendimiento.',
                'icon' => 'air-conditioner',
            ],
            [
                'title' => 'Reparación y urgencias',
                'desc' => 'Averías, falta de frío, fugas y fallos eléctricos. Servicio ágil cuando más lo necesitas.',
                'icon' => 'bolt',
            ],
            [
                'title' => 'Mantenimiento y limpieza',
                'desc' => 'Revisión periódica, limpieza de filtros y carga de gas para alargar la vida del equipo.',
                'icon' => 'wrench',
            ],
            [
                'title' => 'Asesoría de compra',
                'desc' => 'Te ayudamos a elegir potencia y modelo según metros, orientación y uso de tu vivienda.',
                'icon' => 'home',
            ],
        ],
        'steps' => [
            ['title' => 'Contactas', 'desc' => 'Llama, escribe por WhatsApp o rellena el formulario.'],
            ['title' => 'Presupuesto sin cargo', 'desc' => 'Valoramos tu caso y te damos precio claro, sin compromiso.'],
            ['title' => 'Instalación o reparación', 'desc' => 'Agendamos visita y dejamos tu clima funcionando.'],
        ],
        'default_mensaje' => 'Solicitud de presupuesto — landing aire acondicionado',
        'hero_background' => '/images/landing/aires/hero-bg.png',
    ],

    'electricidad' => [
        'default_ciudad' => 'Málaga y la Costa del Sol',
        // H1 alineado al anuncio + ciudad (?ciudad=Fuengirola, etc.)
        'h1' => 'Electricista en {ciudad}',
        'subheadline' => [
            ['text' => 'Electricista certificado', 'emphasis' => true],
            ['text' => 'Urgencias el mismo día'],
            ['text' => 'Presupuesto sin cargo'],
        ],
        'closing_title' => '¿Necesitas un electricista de confianza?',
        'closing_sub' => 'Urgencias el mismo día · presupuesto sin cargo',
        'trust' => [
            ['title' => 'Electricista certificado', 'desc' => 'Trabajos seguros y conforme a normativa', 'icon' => 'shield'],
            ['title' => 'Reseñas en Google', 'desc' => 'Clientes satisfechos en la zona', 'icon' => 'star'],
            ['title' => 'Zona de servicio', 'desc' => 'Costa del Sol', 'icon' => 'map-pin'],
            ['title' => 'Urgencias el mismo día', 'desc' => 'Respuesta rápida cuando más lo necesitas', 'icon' => 'bolt'],
        ],
        'service_blocks' => [
            [
                'title' => 'Instalación',
                'desc' => 'Cuadros, puntos de luz, enchufes, boletines y reformas eléctricas en vivienda y local.',
                'icon' => 'bolt',
            ],
            [
                'title' => 'Urgencias',
                'desc' => 'Cortes de luz, cortocircuitos, averías y fallos. Actuamos con la mayor brevedad posible.',
                'icon' => 'wrench',
            ],
            [
                'title' => 'Comunidades',
                'desc' => 'Mantenimiento eléctrico en comunidades de vecinos, garajes e zonas comunes.',
                'icon' => 'home',
            ],
        ],
        'steps' => [
            ['title' => 'Contactas', 'desc' => 'Llama, escribe por WhatsApp o rellena el formulario.'],
            ['title' => 'Presupuesto sin cargo', 'desc' => 'Valoramos tu caso y te damos precio claro, sin compromiso.'],
            ['title' => 'Instalación o reparación', 'desc' => 'Agendamos visita y dejamos tu instalación funcionando.'],
        ],
        'default_mensaje' => 'Solicitud de presupuesto — landing electricidad',
        'hero_background' => '/images/landing/electricidad/hero-bg.jpg',
        'work_photos' => [
            '/images/landing/electricidad/trabajo-1.jpg',
            '/images/landing/electricidad/trabajo-2.webp',
            '/images/landing/electricidad/trabajo-3.webp',
            '/images/landing/electricidad/trabajo-4.jpg',
            '/images/landing/electricidad/trabajo-5.jpg',
            '/images/landing/electricidad/trabajo-6.jpg',
        ],
    ],
];
