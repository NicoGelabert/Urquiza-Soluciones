<?php

namespace App\Models;

use App\Support\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Faq extends Model
{
    use HasTranslations;

    protected $fillable = [
        'servicio_id',
        'pregunta',
        'respuesta',
        'orden',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'pregunta' => 'array',
            'respuesta' => 'array',
            'activo' => 'boolean',
        ];
    }

    public function servicio(): BelongsTo
    {
        return $this->belongsTo(Servicio::class);
    }
}
