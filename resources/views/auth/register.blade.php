@extends('voyager::auth.master')
@section('content')
    <a class="navbar-brand" href="{{ route('voyager.dashboard') }}">
        <div class="logo-icon-container">
            <?php $admin_logo_img = Voyager::setting('admin.icon_image', ''); ?>
            @if ($admin_logo_img == '')
                <img src="{{ voyager_asset('images/logo-icon-light.png') }}" alt="Logo Icon">
            @else
                <img src="{{ Voyager::image($admin_logo_img) }}" alt="Logo Icon">
            @endif
        </div>
    </a>
    <div class="login-container">
        <x-guest-layout>
            <x-authentication-card>
                {{-- <x-slot name="logo">
                    <x-authentication-card-logo />
                </x-slot> --}}

                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div>
                        <x-label for="name" value="{{ __('Nombre') }}" />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                            required autofocus autocomplete="name" />
                    </div>
                    <div>
                        <x-label for="username" value="{{ __('Numero de Identificación') }}" />
                        <x-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')"
                            required autofocus autocomplete="username" />
                    </div>

                    <div>
                        <x-label for="email" value="{{ __('Correo') }}" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                            required autocomplete="username" />
                    </div>

                    <div>
                        <x-label for="password" value="{{ __('Contraseña') }}" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                            autocomplete="new-password" />
                    </div>

                    <div>
                        <x-label for="password_confirmation" value="{{ __('Confirmar Contraseña') }}" />
                        <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                            name="password_confirmation" required autocomplete="new-password" />
                    </div>

                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div class="mt-4">
                            <x-label for="terms">
                                <div class="flex items-center">
                                    <x-checkbox name="terms" id="terms" required />

                                    <div class="ml-2">
                                        {!! __('Acepto los :terms_of_service y :privacy_policy', [
                                            'terms_of_service' =>
                                                '<a target="_blank" href="
                                                https://www.fedetirocol.com/politica-tratamiento-de-datos/
                                                " class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                                __('Términos de servicio') .
                                                '</a>',
                                            // 'terms_of_service' =>
                                            //     '<a target="_blank" href="
                                            //     ' .route('terms.show') .'
                                            //     " class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                            //     __('Términos de servicio') .
                                            //     '</a>',
                                            'privacy_policy' =>
                                                '<a target="_blank" href="
                                                https://www.fedetirocol.com/politica-tratamiento-de-datos/
                                                " class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                                __('Política de privacidad') .
                                                '</a>',
                                                // '<a target="_blank" href="
                                                // ' . route('policy.show') .'
                                                // " class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                                // __('Política de privacidad') .
                                                // '</a>',
                                        ]) !!}
                                    </div>
                                </div>
                            </x-label>
                        </div>
                    @endif

                    <div class="flex items-center justify-end mt-4">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            href="{{ route('login') }}">
                            {{ __('¿Ya está registrado?') }}
                        </a>

                        <x-button class="ml-4">
                            {{ __('Registrarme') }}
                        </x-button>
                    </div>
                </form>
            </x-authentication-card>
        </x-guest-layout>
    </div> <!-- .login-container -->
@endsection
