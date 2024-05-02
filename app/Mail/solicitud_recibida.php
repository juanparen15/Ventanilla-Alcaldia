<?php

namespace App\Mail;

use App\Models\ArmorumappSolicitud;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class solicitud_recibida extends Mailable
{
    use Queueable, SerializesModels;


    protected $solicitud;
    protected $usuario;

    /**
     * Create a new notification instance.
     */
    public function __construct(ArmorumappSolicitud $solicitud, User $usuario)
    {
        $this->solicitud = $solicitud;
        $this->usuario = $usuario;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $usuario = $this->usuario;

        return $this->subject('Solicitud de Trámite')
            ->view('emails.solicitud-recibida', [
                'usuario' => $usuario,
                'solicitud' => $this->solicitud
            ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Solicitud de Trámite Recibida',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.solicitud-recibida',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
