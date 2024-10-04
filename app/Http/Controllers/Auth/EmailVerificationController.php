<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailVerificationController extends Controller
{
    /**
     * Mostrar el formulario de verificación de correo electrónico.
     *
     * @return \Illuminate\View\View
     */
    public function showVerifyForm()
    {
        return view('auth.verify-email');
    }

    /**
     * Verificar el código de verificación del correo electrónico.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(Request $request)
    {
        $request->validate([
            'verification_pin' => 'required|string',
        ]);

        $user = Auth::user();

        // Verifica si el PIN ingresado coincide con el almacenado
        if ($request->verification_pin === $user->verification_pin) {
            // Verifica si el PIN no ha expirado
            if (now()->isBefore($user->pin_expires_at)) {
                // Si coincide y no ha expirado, marca el usuario como verificado
                $user->markEmailAsVerified();

                return redirect()->route('voyager.users.edit', $user->id)
                    ->with('verified', true);
            } else {
                // Si ha expirado
                return back()->withErrors(['verification_pin' => 'El código de verificación ha expirado.']);
            }
        }

        return back()->withErrors(['verification_pin' => 'El código de verificación es incorrecto.']);
    }
}
