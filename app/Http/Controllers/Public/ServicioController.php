<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Configuracion;
use App\Models\Faq;
use App\Models\Servicio;
use Inertia\Inertia;

class ServicioController extends Controller
{
    public function index()
    {
        $locale = app()->getLocale();

        return Inertia::render('Public/Servicios/Index', [
            'servicios' => Servicio::query()
                ->where('activo', true)
                ->orderBy('orden')
                ->get()
                ->map(fn (Servicio $s) => [
                    'slug' => $s->slugForLocale($locale),
                    'titulo' => $s->translate('titulo', $locale),
                    'descripcion_corta' => $s->translate('descripcion_corta', $locale),
                    'icono' => $s->icono,
                    'imagen_cabecera' => $s->imagen_cabecera
                        ? asset('storage/'.$s->imagen_cabecera)
                        : null,
                ]),
        ]);
    }

    public function show(string $slug)
    {
        $locale = app()->getLocale();
        $column = $locale === 'en' ? 'slug_en' : 'slug';

        $servicio = Servicio::query()
            ->where($column, $slug)
            ->where('activo', true)
            ->with(['items', 'imagenes', 'faqs'])
            ->firstOrFail();

        return Inertia::render('Public/Servicios/Show', [
            'servicio' => [
                'slug' => $servicio->slugForLocale($locale),
                'titulo' => $servicio->translate('titulo', $locale),
                'hero_subtitulo' => $servicio->translate('hero_subtitulo', $locale),
                'descripcion_corta' => $servicio->translate('descripcion_corta', $locale),
                'descripcion_larga' => $servicio->translate('descripcion_larga', $locale),
                'icono' => $servicio->icono,
                'imagen_cabecera' => $servicio->imagen_cabecera
                    ? asset('storage/'.$servicio->imagen_cabecera)
                    : null,
                'meta_title' => $servicio->translate('meta_title', $locale) ?? $servicio->translate('titulo', $locale),
                'meta_description' => $servicio->translate('meta_description', $locale) ?? $servicio->translate('descripcion_corta', $locale),
                'items' => $servicio->items->map(fn ($item) => [
                    'titulo' => $item->titulo[$locale] ?? $item->titulo['es'] ?? '',
                    'descripcion' => ($item->descripcion ?? [])[$locale] ?? ($item->descripcion ?? [])['es'] ?? null,
                ])->values(),
                'imagenes' => $servicio->imagenes->map(fn ($img) => asset('storage/'.$img->ruta))->values(),
                'faqs' => $servicio->faqs->map(fn (Faq $f) => [
                    'pregunta' => $f->translate('pregunta', $locale),
                    'respuesta' => $f->translate('respuesta', $locale),
                ])->values(),
            ],
            'contacto' => [
                'telefono' => Configuracion::get('telefono'),
                'whatsapp' => Configuracion::get('whatsapp'),
                'telefono_urgencias' => Configuracion::get('telefono_urgencias'),
            ],
        ]);
    }
}
