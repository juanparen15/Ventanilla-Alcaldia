<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use TCG\Voyager\Facades\Voyager;
use App\Mail\contactanosRecibida; // Asegúrate de importar la clase Mailable

class ContactController extends Controller
{
    public function send(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'comments' => 'required|string',
        ]);

        // Preparar los datos para el correo
        $name = $request->name;
        $email = $request->email;
        $subject = $request->subject;
        $messageContent = $request->comments;

        // Obtener el correo del administrador desde la configuración de Voyager
        $adminEmail = Voyager::setting('admin.correo', 'deseosecreto92@gmail.com');

        // Enviar el correo utilizando la clase Mailable contactanosRecibida
        Mail::to($adminEmail)->send(new contactanosRecibida($name, $email, $subject, $messageContent));

        // Redirigir con un mensaje de éxito
        return redirect()->back()->with('success', 'Tu mensaje ha sido enviado con éxito.');
    }
}
