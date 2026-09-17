<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginaContenidoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'clave' => $this->clave,
            'titulo' => $this->titulo,
            'contenido' => $this->contenido,
            'datos_extra' => $this->datos_extra,
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
