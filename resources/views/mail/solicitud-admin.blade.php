Nueva solicitud recibida
========================

Tipo: {{ $solicitud->tipo->value }}
Estado: {{ $solicitud->estado->value }}

Nombre: {{ $solicitud->nombre }}
Email: {{ $solicitud->email }}
Teléfono: {{ $solicitud->telefono ?? '—' }}
@if($solicitud->servicio)
Servicio: {{ $solicitud->servicio->translate('titulo', 'es') }}
@endif
Zona: {{ $solicitud->zona ?? '—' }}

Mensaje:
{{ $solicitud->mensaje }}

---
IP: {{ $solicitud->ip }}
