<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServicioImagen extends Model
{
    protected $table = 'servicio_imagenes';

    protected $fillable = [
        'servicio_id',
        'ruta',
        'orden',
    ];

    public function servicio(): BelongsTo
    {
        return $this->belongsTo(Servicio::class);
    }
}
