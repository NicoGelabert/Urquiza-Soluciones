<?php

namespace App\Models;

use App\Support\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class PaginaLegal extends Model
{
    use HasTranslations;

    protected $table = 'pagina_legals';

    protected $fillable = [
        'slug',
        'titulo',
        'contenido',
    ];

    protected function casts(): array
    {
        return [
            'titulo' => 'array',
            'contenido' => 'array',
        ];
    }
}
