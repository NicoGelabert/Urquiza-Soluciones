<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServicioItem extends Model
{
    protected $fillable = [
        'servicio_id',
        'titulo',
        'descripcion',
        'orden',
    ];

    protected function casts(): array
    {
        return [
            'titulo' => 'array',
            'descripcion' => 'array',
        ];
    }

    public function servicio(): BelongsTo
    {
        return $this->belongsTo(Servicio::class);
    }
}
