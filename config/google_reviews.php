<?php

/**
 * Reseñas de Google (manual, sin API).
 *
 * - Hasta 6 entradas en `manual` (texto tal como en Google).
 * - Fotos: public/images/reviews/ → `/images/reviews/archivo.jpg`
 */
return [
    'profile_url' => env('GOOGLE_REVIEWS_PROFILE_URL', 'https://www.google.com/search?q=urquiza+soluciones+rese%C3%B1as'),

    'max_display' => 6,

    'manual' => [
        [
            'name' => 'Facundo Di Matteo',
            'text' => 'Excelente servicio, muy puntual y profesional. Dejaron todo en perfectas condiciones, limpiaron todo al terminar!!! Lo recomiendo al 100%.',
            'rating' => 5,
            'photo_url' => '/images/reviews/facundo-di-matteo.png',
        ],
        [
            'name' => 'APN',
            'text' => 'Excelente servicio, son muy profesionales y trabajan muy rápido. Fueron puntuales, resolvieron todas mis dudas y dejaron todo funcionando perfectamente. 100% recomendables',
            'rating' => 5,
        ],
        [
            'name' => 'Valeria Chietino',
            'text' => 'Trabajo impecable, rápido y muy profesional. Dejó todo perfecto y funcionando de maravilla. Sin duda lo volvería a llamar y lo recomiendo al 100%.',
            'rating' => 5,
            'photo_url' => '/images/reviews/valeria-chietino.png',
        ],
        [
            'name' => 'Michela Scotto',
            'text' => 'Muy recomendables. Han realizado varios trabajos eléctricos en mi local, Miscotto Café, y siempre han sido profesionales, rápidos y resolutivos. Me han ayudado mucho a poner todo en orden y a solucionar incidencias de forma eficaz. Además, son puntuales, trabajan con cuidado y explican todo claramente. Sin duda volveré a contar con ellos para futuros trabajos. ¡Muchas gracias por vuestra ayuda!',
            'rating' => 5,
            'photo_url' => '/images/reviews/michela-scotto.png',
        ],
        [
            'name' => 'Jazmin Ravarini',
            'text' => 'Muy satisfecha con el trabajo realizado. Personal profesional, atención excelente y la instalación impecable y además precios razonables. Totalmente recomendable 😊',
            'rating' => 5,
        ],
        [
            'name' => 'Emiliano Ramirez',
            'text' => 'Excelente servicio, profesional y puntuales. Seguimiento de la solución. Recomendable.',
            'rating' => 5,
            'photo_url' => '/images/reviews/emiliano-ramirez.png',
        ],
    ],
];
