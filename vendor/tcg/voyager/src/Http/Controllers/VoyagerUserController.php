<?php

namespace TCG\Voyager\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use TCG\Voyager\Facades\Voyager;

class VoyagerUserController extends VoyagerBaseController
{
    public function profile(Request $request)
    {
        $route = '';
        $dataType = Voyager::model('DataType')->where('model_name', Auth::guard(app('VoyagerGuard'))->getProvider()->getModel())->first();
        if (!$dataType && app('VoyagerGuard') == 'web') {
            $route = route('voyager.users.edit', Auth::user()->getKey());
        } elseif ($dataType) {
            $route = route('voyager.' . $dataType->slug . '.edit', Auth::user()->getKey());
        }

        return Voyager::view('voyager::profile', compact('route'));
    }

    // public function store(Request $request)
    // {
    //     // Validar los datos del formulario aquí si es necesario

    //     // Guardar el usuario
    //     $user = new User();
    //     $user->save();

    //     // Sincronizar los tipos de arma seleccionados
    //     if ($request->has('tipo_arma')) {
    //         $user->tiposArma()->sync($request->input('tipo_arma'));
    //     }

    //     // Sincronizar las modalidades de arma seleccionadas
    //     if ($request->has('modalidad_arma')) {
    //         $user->modalidadesArma()->sync($request->input('modalidad_arma'));
    //     }

    //     // Redirigir a la página de perfil con un mensaje de éxito
    //     return redirect()->route('voyager.profile')->with('success', 'Perfil registrado correctamente.');
    // }

    // POST BR(E)AD
    public function update(Request $request, $id)
    {
        if (Auth::user()->getKey() == $id) {
            $request->merge([
                'role_id'                              => Auth::user()->role_id,
                'user_belongstomany_role_relationship' => Auth::user()->roles->pluck('id')->toArray(),
            ]);
        }

        // Obtener el usuario que se va a actualizar
        $user = User::findOrFail($id);

        // Actualizar los datos del usuario
        // $user->save();
        // $user->update($request->all());
        // Obtener los datos del formulario
        $formData = $request->all();

        // Verificar si se proporcionó una nueva contraseña en el formulario
        if (!empty($formData['password'])) {
            // Si se proporcionó una nueva contraseña, actualizar el usuario incluyendo la contraseña en los datos
            $user->update($formData);
        } else {
            // Si no se proporcionó una nueva contraseña, excluir el campo de contraseña de los datos
            unset($formData['password']);
            $user->update($formData);
        }

        // // Sincronizar los tipos de arma seleccionados
        // if ($request->has('tipo_arma')) {
        //     $user->tiposArma()->detach(); // Eliminar todas las asociaciones existentes
        //     foreach ($request->input('tipo_arma') as $tipoArmaID) {
        //         $user->tiposArma()->attach($tipoArmaID);
        //     }
        // } else {
        //     // Si no se seleccionaron tipos de arma, eliminar todas las asociaciones existentes
        //     $user->tiposArma()->detach();
        // }

        // Sincronizar las modalidades de arma seleccionadas
        if ($request->has('modalidad_arma') || $request->has('tipo_arma')) {
            $user->modalidadesArma()->detach(); // Eliminar todas las asociaciones existentes
            $user->tiposArma()->detach();
            foreach ($request->input('tipo_arma') as $tipoArmaID) {
                $user->tiposArma()->attach($tipoArmaID);
            }
            foreach ($request->input('modalidad_arma') as $modalidadArmaID) {
                $user->modalidadesArma()->attach($modalidadArmaID);
            }
        } else {
            // Si no se seleccionaron modalidades de arma, eliminar todas las asociaciones existentes
            $user->tiposArma()->detach();
            $user->modalidadesArma()->detach();
        }


        // Redirigir a la página de perfil con un mensaje de éxito
        return parent::update($request, $id);
    }
}
