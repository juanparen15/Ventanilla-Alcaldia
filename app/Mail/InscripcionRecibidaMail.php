<?php

namespace App\Mail;

use App\Models\Inscripcion;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class InscripcionRecibidaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $inscripcion;
    public $usuario;

    /**
     * Create a new message instance.
     */
    public function __construct(Inscripcion $inscripcion, User $usuario)
    {
        $this->inscripcion = $inscripcion;
        $this->usuario = $usuario;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $mailMessage = $this->subject('Inscripción a Evento')
            ->markdown('emails.inscripcion_recibida');

        return $mailMessage;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Inscripción a Evento',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.inscripcion_recibida',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

        if (!empty($this->inscripcion->pdf_comprobante_pago)) {
            $comprobantePago = json_decode($this->inscripcion->pdf_comprobante_pago, true);
            if (isset($comprobantePago[0]['download_link'])) {
                $downloadLink = $comprobantePago[0]['download_link'];
                $attachments[] = Attachment::fromPath(storage_path('public/storage/' . $downloadLink));
            }
        }

        if (!empty($this->inscripcion->pdf_permiso_porte)) {
            $permisoPorte = json_decode($this->inscripcion->pdf_permiso_porte, true);
            if (isset($permisoPorte[0]['download_link'])) {
                $downloadLink = $permisoPorte[0]['download_link'];
                $attachments[] = Attachment::fromPath(storage_path('public/storage/' . $downloadLink));
            }
        }

        if (!empty($this->inscripcion->consentimiento_padres)) {
            $consentimientoPadres = json_decode($this->inscripcion->consentimiento_padres, true);
            if (isset($consentimientoPadres[0]['download_link'])) {
                $downloadLink = $consentimientoPadres[0]['download_link'];
                $attachments[] = Attachment::fromPath(storage_path('public/storage/' . $downloadLink));
            }
        }

        return $attachments;
    }
}
