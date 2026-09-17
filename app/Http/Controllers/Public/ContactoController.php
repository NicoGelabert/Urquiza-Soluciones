<?php

namespace App\Http\Controllers\Public;

use App\Enums\SolicitudTipo;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactoRequest;
use App\Models\PaginaContenido;
use App\Services\SolicitudFormService;
use Inertia\Inertia;

class ContactoController extends Controller
{
    public function __construct(private SolicitudFormService $solicitudService) {}

    public function index()
    {
        $locale = app()->getLocale();
        $intro = PaginaContenido::getByClave('contacto_intro');
        $zona = PaginaContenido::getByClave('zona_trabajo');

        return Inertia::render('Public/Contacto/Index', [
            'intro' => [
                'titulo' => $intro?->translate('titulo', $locale),
                'contenido' => $intro?->translate('contenido', $locale),
            ],
            'ciudades' => $zona?->datos_extra['ciudades'] ?? [],
        ]);
    }

    public function store(ContactoRequest $request)
    {
        $this->solicitudService->store(
            $request->validated(),
            SolicitudTipo::Contacto,
            $request,
        );

        return back()->with('success', __('messages.contact_success'));
    }
}
