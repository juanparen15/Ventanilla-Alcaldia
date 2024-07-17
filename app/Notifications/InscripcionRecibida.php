<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Inscripcion;
use App\Models\User;

class InscripcionRecibida extends Notification
{
    use Queueable;

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
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }


    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $usuario = $this->usuario;

        return (new MailMessage)
            ->subject('Inscripción')
            ->greeting('POR FAVOR NO RESPONDER ESTE EMAIL, ESTA ES UNA NOTIFICACIÓN ELECTRÓNICA AÚTOMATICA')
            // ->line('Señor(a) ' . $notifiable->name . ':')
            ->line('Señor(a) ' . $usuario->primer_nombre . ' ' .  $usuario->segundo_nombre . ' ' . $usuario->primer_apellido . ' ' . $usuario->segundo_apellido . ':')
            ->line('Le informamos que hemos recibido su inscripción el ' . now()->format('d-m-Y \a \l\a\s H:i:s') . ' y se iniciará su gestión de acuerdo a lo establecido en el procedimiento de recepción, tramite, seguimiento y respuesta de su inscripción.')
            ->line('Datos Recibidos:')
            ->line('Valor: ' . $this->inscripcion->valor)
            ->line('Fecha Inscripción: ' . $this->inscripcion->fecha_inscripcion_deportista)
            ->line('Fecha Validación de Federación: ' . $this->inscripcion->fecha_validacion_federacion)
            ->line('Recuerde que puede consultar el estado por medio de nuestro portal');
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
