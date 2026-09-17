<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginaContenidoRequest;
use App\Http\Resources\PaginaContenidoResource;
use App\Models\PaginaContenido;

class PaginaContenidoController extends Controller
{
    public function index()
    {
        $perPage = request('per_page', 20);
        $search = request('search', '');

        $query = PaginaContenido::query()
            ->when($search, fn ($q) => $q->where('clave', 'like', "%{$search}%"))
            ->orderBy('clave')
            ->paginate($perPage);

        return PaginaContenidoResource::collection($query);
    }

    public function show(PaginaContenido $contenido)
    {
        return new PaginaContenidoResource($contenido);
    }

    public function update(PaginaContenidoRequest $request, PaginaContenido $contenido)
    {
        $contenido->update($request->validated());

        return new PaginaContenidoResource($contenido);
    }
}
