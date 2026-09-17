<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServicioListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'titulo' => $this->titulo['es'] ?? '',
            'orden' => $this->orden,
            'activo' => $this->activo,
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
