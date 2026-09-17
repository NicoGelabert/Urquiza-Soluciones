<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FaqResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'servicio_id' => $this->servicio_id,
            'servicio' => $this->whenLoaded('servicio', fn () => [
                'id' => $this->servicio->id,
                'titulo' => $this->servicio->titulo,
            ]),
            'pregunta' => $this->pregunta,
            'respuesta' => $this->respuesta,
            'orden' => $this->orden,
            'activo' => $this->activo,
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
