<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckProfileComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Obtener el nombre de la ruta actual
        $currentRoute = $request->route()->getName();

        // Permitir solicitudes AJAX y la página de edición de perfil
        if (
            $user && $user->hasVerifiedEmail() && !$this->profileCompleted($user) &&
            !$request->ajax() &&
            $currentRoute !== 'voyager.users.edit' &&
            $currentRoute !== 'voyager.users.update' // Permitir también la actualización del perfil
        ) {
            // Obtiene el ID del usuario autenticado
            $userId = Auth::id();

            // Redireccionar a la página de edición del usuario autenticado
            return redirect()->route('voyager.users.edit', $userId)->with('message', 'Por favor, completa tu perfil antes de continuar.');
        }

        return $next($request);
    }

    private function profileCompleted($user)
    {
        // Lógica para verificar si el perfil del usuario está completo
        // Verificar cada campo requerido
        return !is_null($user->primer_nombre) &&
            !is_null($user->primer_apellido);
            !is_null($user->movil) &&
            !is_null($user->direccion) &&
            !is_null($user->fecha_nacimiento) &&
            !is_null($user->peso) &&
            !is_null($user->altura) &&
            !is_null($user->estado_civil) &&
            !is_null($user->genero);
    }
}
