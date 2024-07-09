<?php

namespace App\Mail;

use App\Models\Inscripcion;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class inscripcion_recibida extends Mailable
{
    use Queueable, SerializesModels;


    protected $inscripcion;
    protected $usuario;

    /**
     * Create a new notification instance.
     */
    public function __construct(Inscripcion $inscripcion, User $usuario)
    {
        $this->inscripcion = $inscripcion;
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

        return $this->subject('Inscripción de Trámite')
            ->view('emails.inscripcion-recibida', [
                'usuario' => $usuario,
                'inscripcion' => $this->inscripcion
            ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Inscripción de Trámite Recibida',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.inscripcion-recibida',
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
