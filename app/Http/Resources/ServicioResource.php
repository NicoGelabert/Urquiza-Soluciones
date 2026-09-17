<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServicioResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'slug_en' => $this->slug_en,
            'icono' => $this->icono,
            'orden' => $this->orden,
            'activo' => $this->activo,
            'imagen_cabecera' => $this->imagen_cabecera ? asset('storage/'.$this->imagen_cabecera) : null,
            'imagen_cabecera_path' => $this->imagen_cabecera,
            'titulo' => $this->titulo,
            'hero_subtitulo' => $this->hero_subtitulo,
            'descripcion_corta' => $this->descripcion_corta,
            'descripcion_larga' => $this->descripcion_larga,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'items' => $this->whenLoaded('items', fn () => $this->items->map(fn ($item) => [
                'id' => $item->id,
                'titulo' => $item->titulo,
                'descripcion' => $item->descripcion,
                'orden' => $item->orden,
            ])),
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
