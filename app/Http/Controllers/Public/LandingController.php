<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PaginaContenido;
use App\Models\Servicio;
use App\Services\GooglePlaceReviewsService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LandingController extends Controller
{
    public function show(Request $request, string $slug)
    {
        $locale = app()->getLocale();
        $map = config('landings.'.$locale, []);

        if (! isset($map[$slug])) {
            abort(404);
        }

        $contentKey = $map[$slug];

        $servicio = Servicio::query()
            ->where('slug', $contentKey)
            ->where('activo', true)
            ->with(['items', 'imagenes'])
            ->firstOrFail();

        $servicioPayload = [
            'id' => $servicio->id,
            'titulo' => $servicio->translate('titulo', $locale),
            'hero_subtitulo' => $servicio->translate('hero_subtitulo', $locale),
            'descripcion_corta' => $servicio->translate('descripcion_corta', $locale),
            'descripcion_larga' => $servicio->translate('descripcion_larga', $locale),
            'icono' => $servicio->icono,
            'meta_title' => $servicio->translate('meta_title', $locale)
                ?? $servicio->translate('titulo', $locale),
            'meta_description' => $servicio->translate('meta_description', $locale)
                ?? $servicio->translate('descripcion_corta', $locale),
            'items' => $servicio->items->map(fn ($item) => [
                'titulo' => $item->titulo[$locale] ?? $item->titulo['es'] ?? '',
            ])->values(),
            'imagen_cabecera' => $servicio->imagen_cabecera
                ? asset('storage/'.$servicio->imagen_cabecera)
                : null,
            'imagenes' => $servicio->imagenes->map(fn ($img) => asset('storage/'.$img->ruta))->values(),
        ];

        $ciudades = PaginaContenido::getByClave('zona_trabajo')?->datos_extra['ciudades'] ?? [];

        $view = config('landing_content.views.'.$contentKey, 'Public/Landing/Show');
        $raw = config('landing_content.'.$contentKey);

        $servicios = Servicio::query()
            ->where('activo', true)
            ->orderBy('orden')
            ->get(['id', 'titulo'])
            ->map(fn (Servicio $s) => [
                'id' => $s->id,
                'titulo' => $s->translate('titulo', $locale),
            ])
            ->values();

        $payload = [
            'landingSlug' => $slug,
            'servicio' => $servicioPayload,
            'servicios' => $servicios,
            'ciudades' => $ciudades,
        ];

        if (is_array($raw) && config()->has('landing_content.views.'.$contentKey)) {
            $ciudad = $this->resolveCiudad($request, $raw['default_ciudad'] ?? 'Málaga y la Costa del Sol');
            $h1 = str_replace('{ciudad}', $ciudad, $raw['h1'] ?? '');

            $reviewsService = app(GooglePlaceReviewsService::class);
            $googleReviews = $reviewsService->getReviews();

            if ($googleReviews !== []) {
                $reviews = $googleReviews;
                $reviewsSource = $googleReviews[0]['source'] ?? 'manual';
            } else {
                $reviews = $raw['reviews'] ?? [];
                $reviewsSource = 'sample';
            }

            $workPhotos = $raw['work_photos'] ?? config('landing_content.shared_work_photos', []);

            $payload['ciudad'] = $ciudad;
            $payload['googleReviewsUrl'] = $reviewsService->profileUrl();
            $payload['reviewsSource'] = $reviewsSource;
            $payload['content'] = [
                'h1' => $h1,
                'subheadline' => $raw['subheadline'] ?? [],
                'trust' => $raw['trust'] ?? [],
                'service_blocks' => $raw['service_blocks'] ?? [],
                'steps' => $raw['steps'] ?? [],
                'reviews' => $reviews,
                'default_mensaje' => $raw['default_mensaje'] ?? 'Solicitud desde landing',
                'work_photos' => $workPhotos,
                'hero_background' => $raw['hero_background'] ?? null,
                'closing_title' => $raw['closing_title'] ?? '',
                'closing_sub' => $raw['closing_sub'] ?? '',
            ];
        }

        return Inertia::render($view, $payload);
    }

    private function resolveCiudad(Request $request, string $default): string
    {
        $ciudad = trim((string) $request->query('ciudad', ''));
        if ($ciudad === '') {
            return $default;
        }

        $ciudad = preg_replace('/\s+/', ' ', $ciudad) ?? $ciudad;

        return mb_substr($ciudad, 0, 80);
    }
}
