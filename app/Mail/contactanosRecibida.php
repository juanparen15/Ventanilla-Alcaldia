<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class contactanosRecibida extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $subject;
    public $messageContent;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $email, $subject, $messageContent)
    {
        $this->name = $name;
        $this->email = $email;
        $this->subject = $subject;
        $this->messageContent = $messageContent;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this
        // ->subject('Nuevo mensaje de contacto recibido')
                    ->markdown('emails.contactanos-recibido')
                    ->withAttachments($this->attachments());
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            // subject: 'Nuevo mensaje de contacto recibido',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contactanos-recibido',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return \Illuminate\Mail\Mailables\Attachment[]
     */
    public function attachments(): array
    {
        // Si en el formulario de contacto no esperas archivos, puedes dejar esto vacío o adaptarlo.
        // Aquí agregamos lógica si hay archivos de contacto (opcional).
        $attachments = [];

        // Ejemplo: agregar un archivo si existe
        // if (!empty($this->someFilePath)) {
        //     if (Storage::disk('public')->exists($this->someFilePath)) {
        //         $fileName = basename($this->someFilePath);
        //         $attachments[] = Attachment::fromStorageDisk('public', $this->someFilePath)
        //             ->as($fileName);
        //     } else {
        //         Log::error("Archivo no encontrado: $this->someFilePath");
        //     }
        // }

        return $attachments;
    }
}
