<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Config;
use TCG\Voyager\Facades\Voyager;

class AppServiceProvider extends ServiceProvider
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
    public function boot()
    {
        // Configurar el correo con valores de Voyager
        $mailUsername = Voyager::setting('admin.correo_admin');
        $mailPassword = Voyager::setting('admin.clave_admin');

        Config::set('mail.mailers.smtp.username', $mailUsername);
        Config::set('mail.mailers.smtp.password', $mailPassword);

        Voyager::addAction(\App\Actions\BotonDetalles::class);
    }
}
