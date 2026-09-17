<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PaginaLegal;
use Inertia\Inertia;

class LegalController extends Controller
{
    public function show(string $slug)
    {
        $locale = app()->getLocale();

        $pagina = PaginaLegal::query()->where('slug', $slug)->firstOrFail();

        return Inertia::render('Public/Legal/Show', [
            'pagina' => [
                'slug' => $pagina->slug,
                'titulo' => $pagina->translate('titulo', $locale),
                'contenido' => $pagina->translate('contenido', $locale),
            ],
        ]);
    }
}
