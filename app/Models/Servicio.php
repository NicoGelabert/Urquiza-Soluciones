<?php

namespace App\Models;

use App\Support\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Servicio extends Model
{
    use HasTranslations;

    protected $fillable = [
        'slug',
        'slug_en',
        'icono',
        'orden',
        'activo',
        'imagen_cabecera',
        'titulo',
        'hero_subtitulo',
        'descripcion_corta',
        'descripcion_larga',
        'meta_title',
        'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
            'titulo' => 'array',
            'hero_subtitulo' => 'array',
            'descripcion_corta' => 'array',
            'descripcion_larga' => 'array',
            'meta_title' => 'array',
            'meta_description' => 'array',
        ];
    }

    public function items(): HasMany
    {
        return $this->hasMany(ServicioItem::class)->orderBy('orden');
    }

    public function imagenes(): HasMany
    {
        return $this->hasMany(ServicioImagen::class)->orderBy('orden');
    }

    public function faqs(): HasMany
    {
        return $this->hasMany(Faq::class)->where('activo', true)->orderBy('orden');
    }

    public function slugForLocale(?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();

        return $locale === 'en' ? $this->slug_en : $this->slug;
    }
}
