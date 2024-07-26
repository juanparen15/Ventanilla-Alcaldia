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
use Illuminate\Support\Facades\Log;

class InscripcionAdminRecibidaMail extends Mailable
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
        $mailMessage = $this->subject('INSCRIPCIÓN // (' . $this->inscripcion->codigo_inscripcion . ') // (' . $this->inscripcion->documento_tercero . ')')
            ->markdown('emails.inscripcion_admin');

        return $mailMessage;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'INSCRIPCIÓN // (' . $this->inscripcion->codigo_inscripcion . ') // (' . $this->inscripcion->documento_tercero . ')',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.inscripcion_admin',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return \Illuminate\Mail\Mailables\Attachment[]
     */
    public function attachments(): array
    {
        $attachments = [];

        // Consentimiento de padres
        if (!empty($this->inscripcion->consentimiento_padres)) {
            $pdfConsentimientoPadres = json_decode($this->inscripcion->consentimiento_padres, true);
            if (is_array($pdfConsentimientoPadres)) {
                foreach ($pdfConsentimientoPadres as $archivo) {
                    $attachments[] = Attachment::fromStorageDisk('public', $archivo['download_link'])
                        ->as($archivo['original_name']);
                }
            } else {
                $attachments[] = Attachment::fromStorageDisk('public', $this->inscripcion->consentimiento_padres)
                    ->as('consentimiento_padres.pdf');
            }
        }

        // Comprobante de pago
        if (!empty($this->inscripcion->pdf_comprobante_pago)) {
            $pdfComprobantePago = json_decode($this->inscripcion->pdf_comprobante_pago, true);
            if (is_array($pdfComprobantePago)) {
                foreach ($pdfComprobantePago as $archivo) {
                    $attachments[] = Attachment::fromStorageDisk('public', $archivo['download_link'])
                        ->as($archivo['original_name']);
                }
            } else {
                $attachments[] = Attachment::fromStorageDisk('public', $this->inscripcion->pdf_comprobante_pago)
                    ->as('comprobante_pago.pdf');
            }
        }
        // Permiso de porte
        if (!empty($this->inscripcion->pdf_permiso_porte)) {
            $pdfPermisoPorte = json_decode($this->inscripcion->pdf_permiso_porte, true);
            if (is_array($pdfPermisoPorte)) {
                foreach ($pdfPermisoPorte as $archivo) {
                    $attachments[] = Attachment::fromStorageDisk('public', $archivo['download_link'])
                        ->as($archivo['original_name']);
                }
            } else {
                $attachments[] = Attachment::fromStorageDisk('public', $this->inscripcion->pdf_permiso_porte)
                    ->as('permiso_porte.pdf');
            }
        }

        return $attachments;
    }
}
