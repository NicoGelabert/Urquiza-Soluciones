<?php

namespace App\Models;

use App\Enums\SolicitudEstado;
use App\Enums\SolicitudTipo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Solicitud extends Model
{
    protected $table = 'solicitudes';

    protected $fillable = [
        'tipo',
        'estado',
        'nombre',
        'email',
        'telefono',
        'mensaje',
        'servicio_id',
        'zona',
        'notas_admin',
        'ip',
        'user_agent',
    ];

    protected function casts(): array
    {
        return [
            'tipo' => SolicitudTipo::class,
            'estado' => SolicitudEstado::class,
        ];
    }

    public function servicio(): BelongsTo
    {
        return $this->belongsTo(Servicio::class);
    }
}
