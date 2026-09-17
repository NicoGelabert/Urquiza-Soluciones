<?php

namespace App\Http\Controllers\Public;

use App\Enums\SolicitudTipo;
use App\Http\Controllers\Controller;
use App\Http\Requests\PresupuestoRequest;
use App\Models\PaginaContenido;
use App\Models\Servicio;
use App\Services\SolicitudFormService;
use Inertia\Inertia;

class PresupuestoController extends Controller
{
    public function __construct(private SolicitudFormService $solicitudService) {}

    public function index()
    {
        $locale = app()->getLocale();

        return Inertia::render('Public/Presupuesto/Index', [
            'servicios' => Servicio::query()
                ->where('activo', true)
                ->orderBy('orden')
                ->get(['id', 'titulo'])
                ->map(fn (Servicio $s) => [
                    'id' => $s->id,
                    'titulo' => $s->translate('titulo', $locale),
                ]),
            'ciudades' => PaginaContenido::getByClave('zona_trabajo')?->datos_extra['ciudades'] ?? [],
        ]);
    }

    public function store(PresupuestoRequest $request)
    {
        $this->solicitudService->store(
            $request->validated(),
            SolicitudTipo::Presupuesto,
            $request,
        );

        return back()->with('success', __('messages.quote_success'));
    }
}
