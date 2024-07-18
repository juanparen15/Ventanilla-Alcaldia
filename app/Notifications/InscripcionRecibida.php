<?php

// namespace App\Notifications;

// use Illuminate\Bus\Queueable;
// use Illuminate\Notifications\Notification;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Notifications\Messages\MailMessage;
// use App\Models\Inscripcion;
// use App\Models\User;
// use App\Mail\inscripcion_recibida;

// class InscripcionRecibida extends Notification
// {
//     use Queueable;

//     protected $inscripcion;
//     protected $usuario;

//     /**
//      * Create a new notification instance.
//      */
//     public function __construct(Inscripcion $inscripcion, User $usuario)
//     {
//         $this->inscripcion = $inscripcion;
//         $this->usuario = $usuario;
//     }

//     /**
//      * Get the notification's delivery channels.
//      *
//      * @return array<int, string>
//      */
//     public function via($notifiable)
//     {
//         return ['mail'];
//     }

//     /**
//      * Get the mail representation of the notification.
//      *
//      * @param  mixed  $notifiable
//      * @return inscripcion_recibida
//      */
//     public function toMail($notifiable)
//     {
//         return (new inscripcion_recibida($this->inscripcion, $this->usuario))->to($notifiable->email);
//     }

//     /**
//      * Get the array representation of the notification.
//      *
//      * @param  mixed  $notifiable
//      * @return array<string, mixed>
//      */
//     public function toArray($notifiable)
//     {
//         return [
//             'inscripcion_id' => $this->inscripcion->codigo_inscripcion,
//             'nombre_evento' => $this->inscripcion->evento->nombre_evento,
//             'tipo_categoria_nombre' => $this->inscripcion->tipoCategoria->nombre,
//             'tipo_categoria_uso' => $this->inscripcion->tipoCategoria->uso_categoria,
//             'deportista' => $this->usuario->primer_nombre . ' ' . $this->usuario->segundo_nombre . ' ' . $this->usuario->primer_apellido . ' ' . $this->usuario->segundo_apellido,
//         ];
//     }
// }
