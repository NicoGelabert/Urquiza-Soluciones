<?php

namespace App\Mail;

use App\Models\Solicitud;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SolicitudNotificacionAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Solicitud $solicitud)
    {
        $this->solicitud->loadMissing('servicio');
    }

    public function envelope(): Envelope
    {
        $tipo = $this->solicitud->tipo === \App\Enums\SolicitudTipo::Presupuesto
            ? 'Nueva solicitud de presupuesto'
            : 'Nuevo mensaje de contacto';

        return new Envelope(
            replyTo: [$this->solicitud->email],
            subject: "{$tipo} — {$this->solicitud->nombre}",
        );
    }

    public function content(): Content
    {
        return new Content(text: 'mail.solicitud-admin');
    }
}
