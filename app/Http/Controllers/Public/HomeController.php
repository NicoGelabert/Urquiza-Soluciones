<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Configuracion;
use App\Models\Faq;
use App\Models\PaginaContenido;
use App\Models\Servicio;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function __invoke()
    {
        $locale = app()->getLocale();

        return Inertia::render('Public/Home', [
            'servicios' => Servicio::query()
                ->where('activo', true)
                ->orderBy('orden')
                ->with('items')
                ->get()
                ->map(fn (Servicio $s) => $this->mapServicio($s, $locale)),
            'sobreNosotros' => $this->mapContenido('sobre_nosotros', $locale),
            'zonaTrabajo' => $this->mapContenido('zona_trabajo', $locale),
            'serviciosIntro' => $this->mapContenido('servicios_intro', $locale),
            'urgencias' => $this->mapContenido('urgencias', $locale),
            'faqTitulo' => PaginaContenido::getByClave('faq_titulo')?->translate('titulo', $locale),
            'faqs' => Faq::query()
                ->where('activo', true)
                ->with('servicio')
                ->orderBy('servicio_id')
                ->orderBy('orden')
                ->get()
                ->map(fn (Faq $f) => [
                    'id' => $f->id,
                    'servicio' => $f->servicio?->translate('titulo', $locale),
                    'pregunta' => $f->translate('pregunta', $locale),
                    'respuesta' => $f->translate('respuesta', $locale),
                ]),
            'contacto' => [
                'telefono' => Configuracion::get('telefono'),
                'whatsapp' => Configuracion::get('whatsapp'),
                'email' => Configuracion::get('email'),
                'telefono_urgencias' => Configuracion::get('telefono_urgencias'),
            ],
        ]);
    }

    private function mapServicio(Servicio $servicio, string $locale): array
    {
        return [
            'id' => $servicio->id,
            'slug' => $servicio->slugForLocale($locale),
            'titulo' => $servicio->translate('titulo', $locale),
            'hero_subtitulo' => $servicio->translate('hero_subtitulo', $locale),
            'descripcion_corta' => $servicio->translate('descripcion_corta', $locale),
            'icono' => $servicio->icono,
            'imagen_cabecera' => $servicio->imagen_cabecera
                ? asset('storage/'.$servicio->imagen_cabecera)
                : null,
            'items' => $servicio->items->map(fn ($item) => $item->titulo[$locale] ?? $item->titulo['es'] ?? '')->values(),
        ];
    }

    private function mapContenido(string $clave, string $locale): ?array
    {
        $bloque = PaginaContenido::getByClave($clave);

        if (! $bloque) {
            return null;
        }

        return [
            'titulo' => $bloque->translate('titulo', $locale),
            'contenido' => $bloque->translate('contenido', $locale),
            'datos_extra' => $bloque->datos_extra,
        ];
    }
}
