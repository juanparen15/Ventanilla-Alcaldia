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



    // public function attachments(): array
    // {
    //     $attachments = [];

    //     if (!empty($this->inscripcion->pdf_comprobante_pago)) {
    //         $comprobantePago = json_decode($this->inscripcion->pdf_comprobante_pago);
    //         if (isset($comprobantePago[0]->download_link)) {
    //             $downloadLink = $comprobantePago[0]->download_link;
    //             $attachments[] = Attachment::fromPath(storage_path('public/storage/' . $downloadLink));
    //             $attachments[] = Attachment::fromStorageDisk('public', $downloadLink);
    //             $attachments[] = Attachment::fromPath(storage_path('app/public/' . $downloadLink));
    //         }
    //     }

    //     if (!empty($this->inscripcion->pdf_permiso_porte)) {
    //         $permisoPorte = json_decode($this->inscripcion->pdf_permiso_porte);
    //         if (isset($permisoPorte[0]->download_link)) {
    //             $downloadLink = $permisoPorte[0]->download_link;
    //             $attachments[] = Attachment::fromPath(storage_path('public/storage/' . $downloadLink));
    //             $attachments[] = Attachment::fromStorageDisk('public', $downloadLink);
    //             $attachments[] = Attachment::fromPath(storage_path('app/public/' . $downloadLink));
    //         }
    //     }

    //     if (!empty($this->inscripcion->consentimiento_padres)) {
    //         $consentimientoPadres = json_decode($this->inscripcion->consentimiento_padres);
    //         if (isset($consentimientoPadres[0]->download_link)) {
    //             $downloadLink = $consentimientoPadres[0]->download_link;
    //             $attachments[] = Attachment::fromPath(storage_path('public/storage/' . $downloadLink));
    //             $attachments[] = Attachment::fromStorageDisk('public', $downloadLink);
    //             $attachments[] = Attachment::fromPath(storage_path('app/public/' . $downloadLink));
    //         }
    //     }

    //     return $attachments;
    // }

    // public function attachments(): array
    // {
    //     $attachments = [];

    //     // Helper function to add attachments
    //     $attachments = array_merge($attachments, $this->getAttachment($this->inscripcion->pdf_comprobante_pago));
    //     $attachments = array_merge($attachments, $this->getAttachment($this->inscripcion->pdf_permiso_porte));
    //     $attachments = array_merge($attachments, $this->getAttachment($this->inscripcion->consentimiento_padres));

    //     return $attachments;
    // }

    // private function getAttachment($jsonField): array
    // {
    //     $attachments = [];
    //     if (!empty($jsonField)) {
    //         $decoded = json_decode($jsonField);
    //         if (is_array($decoded)) {
    //             foreach ($decoded as $file) {
    //                 $downloadLink = $file->download_link;
    //                 $downloadLink = str_replace('\\', '/', $downloadLink); // Convert backslashes to slashes
    //                 $path = storage_path('app/public/' . $downloadLink);

    //                 // Check if the file exists
    //                 if (file_exists($path)) {
    //                     $attachments[] = Attachment::fromPath($path);
    //                 } else {
    //                     Log::error('Archivo no encontrado: ' . $path);
    //                 }
    //             }
    //         } else {
    //             // Handle single file case if needed
    //             $downloadLink = $decoded;
    //             $downloadLink = str_replace('\\', '/', $downloadLink);
    //             $path = storage_path('app/public/' . $downloadLink);

    //             if (file_exists($path)) {
    //                 $attachments[] = Attachment::fromPath($path);
    //             } else {
    //                 Log::error('Archivo no encontrado: ' . $path);
    //             }
    //         }
    //     }
    //     return $attachments;
    // }
}
