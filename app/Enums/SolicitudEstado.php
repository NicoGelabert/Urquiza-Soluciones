<?php

namespace App\Enums;

enum SolicitudEstado: string
{
    case Pendiente = 'pendiente';
    case Contestado = 'contestado';
    case Cancelado = 'cancelado';
}
