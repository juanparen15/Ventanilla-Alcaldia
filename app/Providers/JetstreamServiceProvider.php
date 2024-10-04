<?php

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use App\Notifications\CustomResetPasswordNotification;
use App\Notifications\CustomVerifyEmailNotification;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configurePermissions();

        Jetstream::deleteUsersUsing(DeleteUser::class);

        // VerifyEmail::toMailUsing(function ($notifiable, $url) {
        //     return (new CustomVerifyEmailNotification($url))->toMail($notifiable, $url);
        // });
        VerifyEmail::toMailUsing(function ($notifiable) {
            // Asegúrate de que el PIN se esté generando y almacenando en el modelo del usuario
            $verificationPin = rand(100000, 999999); // Genera el PIN

            // Asigna el PIN al usuario, si no está ya almacenado
            $notifiable->verification_pin = $verificationPin; // Asignar el PIN al notifiable (usuario)
            $notifiable->pin_expires_at = now()->addMinutes(10); // Establecer la expiración

            // Guarda el PIN en el usuario
            $notifiable->save();

            return (new CustomVerifyEmailNotification($verificationPin))->toMail($notifiable);
        });

        ResetPassword::toMailUsing(function ($notifiable, $url) {
            return (new CustomResetPasswordNotification($url))->toMail($notifiable, $url);
        });
    }

    /**
     * Configure the permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }
}
