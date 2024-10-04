<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Notifications\CustomVerifyEmailNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'tipo_documento' => ['required', 'integer', 'exists:tipo_documentos,id'],
            'username' => ['required', 'regex:/^[0-9]+$/', 'string', 'max:255', 'min:4', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ], [
            'username.unique' => 'El número de identificación ya está en uso.',
            'username.regex' => 'El número de identificación solo puede contener números.',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ])->validate();

        // Genera un PIN de 6 dígitos
        $verificationPin = rand(100000, 999999);

        return User::create([
            'tipo_documento' => $input['tipo_documento'],
            'username' => $input['username'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'verification_pin' => $verificationPin,
            'pin_expires_at' => now()->addMinutes(10), // Establecer la expiración del PIN
        ]);

        // Enviar la notificación con el PIN
        // $user->notify(new CustomVerifyEmailNotification($verificationPin));

        // event(new Registered($user));

        // return $user;
    }
}
