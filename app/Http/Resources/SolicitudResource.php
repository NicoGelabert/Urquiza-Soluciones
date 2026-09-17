<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SolicitudResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tipo' => $this->tipo->value,
            'estado' => $this->estado->value,
            'nombre' => $this->nombre,
            'email' => $this->email,
            'telefono' => $this->telefono,
            'mensaje' => $this->mensaje,
            'servicio_id' => $this->servicio_id,
            'servicio_titulo' => $this->servicio?->titulo['es'] ?? null,
            'zona' => $this->zona,
            'notas_admin' => $this->notas_admin,
            'ip' => $this->ip,
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
