<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SolicitudUpdateRequest;
use App\Http\Resources\SolicitudResource;
use App\Models\Solicitud;

class SolicitudController extends Controller
{
    public function index()
    {
        $perPage = request('per_page', 15);
        $search = request('search', '');
        $tipo = request('tipo');
        $estado = request('estado');
        $sortField = request('sort_field', 'created_at');
        $sortDirection = request('sort_direction', 'desc');

        $query = Solicitud::query()
            ->with('servicio')
            ->when($tipo, fn ($q) => $q->where('tipo', $tipo))
            ->when($estado, fn ($q) => $q->where('estado', $estado))
            ->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);

        return SolicitudResource::collection($query);
    }

    public function show(Solicitud $solicitud)
    {
        return new SolicitudResource($solicitud->load('servicio'));
    }

    public function update(SolicitudUpdateRequest $request, Solicitud $solicitud)
    {
        $solicitud->update($request->validated());

        return new SolicitudResource($solicitud->load('servicio'));
    }
}
