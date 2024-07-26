<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use App\Http\Responses\LoginResponse;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Validation\ValidationException;

class FortifyServiceProvider extends ServiceProvider
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
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        $this->app->singleton(LoginResponseContract::class, LoginResponse::class);

        Fortify::authenticateUsing(function (Request $request) {
            // Validar el input antes de intentar autenticarse
            $request->validate([
                'username' => ['required', 'regex:/^[0-9]+$/'],
                'password' => ['required'],
            ]);

            $user = \App\Models\User::where('username', $request->username)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                if ($user->hasVerifiedEmail()) {
                    return $user;
                }

                // Lanzar excepción si el correo no está verificado
                throw ValidationException::withMessages([
                    'email' => [trans('auth.email_not_verified')],
                ]);
            }

            throw ValidationException::withMessages([
                'username' => [trans('auth.failed')],
            ]);
        });

        Fortify::loginView(function () {
            return view('voyager::login');
        });

        Fortify::registerView(function () {
            return view('voyager::register');
        });

        Fortify::verifyEmailView(function () {
            return view('auth.verify-email');
        });

        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.forgot-password');
        });

        Fortify::resetPasswordView(function ($request) {
            return view('auth.reset-password', ['request' => $request]);
        });

        Fortify::confirmPasswordView(function () {
            return view('auth.confirm-password');
        });
    }
}
