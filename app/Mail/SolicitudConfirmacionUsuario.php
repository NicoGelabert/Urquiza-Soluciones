<?php

namespace App\Mail;

use App\Models\Solicitud;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SolicitudConfirmacionUsuario extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Solicitud $solicitud) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Hemos recibido su solicitud — Urquiza Soluciones',
        );
    }

    public function content(): Content
    {
        return new Content(text: 'mail.solicitud-confirmacion');
    }
}
