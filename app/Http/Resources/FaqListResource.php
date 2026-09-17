<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FaqListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'servicio_id' => $this->servicio_id,
            'servicio_titulo' => $this->servicio?->titulo['es'] ?? null,
            'pregunta' => $this->pregunta['es'] ?? '',
            'orden' => $this->orden,
            'activo' => $this->activo,
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
