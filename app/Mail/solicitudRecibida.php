<?php

namespace App\Mail;

use App\Models\User;
use App\Models\ArmorumappSolicitud;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class solicitudRecibida extends Mailable
{
    use Queueable, SerializesModels;

    public $solicitud;
    public $usuario;

    /**
     * Create a new message instance.
     */
    public function __construct(ArmorumappSolicitud $solicitud, User $usuario)
    {
        $this->solicitud = $solicitud;
        $this->usuario = $usuario;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Recepción de Solicitud por Ventanilla Única')
        ->markdown('emails.solicitud-recibida')
        ->withAttachments($this->attachments());
}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Recepción de Solicitud por Ventanilla Única',
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
     * @return \Illuminate\Mail\Mailables\Attachment[]
     */
    public function attachments(): array
    {
        $attachments = [];

        // Verificar y agregar el archivo de foto si existe
        if (!empty($this->solicitud->foto)) {
            $filePath = $this->solicitud->foto;

            // Asegúrate de que la ruta del archivo sea correcta y accesible
            if (Storage::disk('public')->exists($filePath)) {
                // Aquí estamos asumiendo que el nombre del archivo es el último segmento del path
                $fileName = basename($filePath);
                $attachments[] = Attachment::fromStorageDisk('public', $filePath)
                    ->as($fileName);
            } else {
                Log::error("Archivo no encontrado: $filePath");
            }
        }

        // Repetir para otros archivos si es necesario
        if (!empty($this->solicitud->cedula)) {
            $filePath = $this->solicitud->cedula;
            if (Storage::disk('public')->exists($filePath)) {
                $fileName = basename($filePath);
                $attachments[] = Attachment::fromStorageDisk('public', $filePath)
                    ->as($fileName);
            } else {
                Log::error("Archivo no encontrado: $filePath");
            }
        }

        if (!empty($this->solicitud->pago)) {
            $filePath = $this->solicitud->pago;
            if (Storage::disk('public')->exists($filePath)) {
                $fileName = basename($filePath);
                $attachments[] = Attachment::fromStorageDisk('public', $filePath)
                    ->as($fileName);
            } else {
                Log::error("Archivo no encontrado: $filePath");
            }
        }

        if (!empty($this->solicitud->otro_archivo)) {
            $filePath = $this->solicitud->otro_archivo;
            if (Storage::disk('public')->exists($filePath)) {
                $fileName = basename($filePath);
                $attachments[] = Attachment::fromStorageDisk('public', $filePath)
                    ->as($fileName);
            } else {
                Log::error("Archivo no encontrado: $filePath");
            }
        }
        // dd($this->solicitud->toArray()); // Verifica los datos cargados

        return $attachments;
    }
}
