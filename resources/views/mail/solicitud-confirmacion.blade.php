Hola {{ $solicitud->nombre }},

Hemos recibido su solicitud correctamente. Nos pondremos en contacto con usted a la brevedad.

Resumen:
@if($solicitud->tipo === \App\Enums\SolicitudTipo::Presupuesto)
- Tipo: Solicitud de presupuesto
@else
- Tipo: Consulta de contacto
@endif
- Mensaje: {{ $solicitud->mensaje }}

Gracias por confiar en Urquiza Soluciones.

Saludos,
Urquiza Soluciones
