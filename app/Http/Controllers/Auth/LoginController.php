<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Método para mostrar el formulario de inicio de sesión
    public function showLoginForm()
    {
        return view('vendor.voyager.login'); // Asegúrate de tener la vista auth.login
    }

    public function authenticated(Request $request, $user)
    {
        // Verificar si el correo electrónico no ha sido confirmado
        if (!$user->hasVerifiedEmail()) {
            // Redirigir a la página de verificación de email
            return redirect()->route('verification.notice');
        }

        // Redirigir al home si el correo ya está verificado
        // return redirect()->intended('/');
        return redirect()->route('voyager.users.edit', $user->id);
    }

    // Método para el login
    public function login(Request $request)
    {
        // Validar los campos de inicio de sesión
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Intentar autenticación con los datos proporcionados
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password], $request->filled('remember'))) {
            // Autenticación exitosa
            $user = Auth::user();
            return $this->authenticated($request, $user);
        }

        // Si la autenticación falla
        return back()->withErrors([
            'username' => 'Las credenciales no coinciden.',
        ]);
    }
}
