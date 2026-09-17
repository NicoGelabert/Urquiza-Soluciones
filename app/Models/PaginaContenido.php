<?php

namespace App\Models;

use App\Support\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class PaginaContenido extends Model
{
    use HasTranslations;

    protected $table = 'pagina_contenidos';

    protected $fillable = [
        'clave',
        'titulo',
        'contenido',
        'datos_extra',
    ];

    protected function casts(): array
    {
        return [
            'titulo' => 'array',
            'contenido' => 'array',
            'datos_extra' => 'array',
        ];
    }

    public static function getByClave(string $clave): ?self
    {
        return static::query()->where('clave', $clave)->first();
    }
}
