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
                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- <div>
                        <x-label for="primer_nombre" value="{{ __('Primer Nombre') }}" />
                        <x-input id="primer_nombre" class="block mt-1 w-full" type="text" name="primer_nombre"
                            :value="old('primer_nombre')" required autofocus autocomplete="primer_nombre" />
                    </div> --}}
                    @php
                        $selected_tipo_documento = old('tipo_documento') ?? null;
                    @endphp
                    <div>
                        <x-label for="tipo_documento" value="{{ __('Tipo Documento') }}" />
                        <select class="form-control block mt-1 w-full" id="tipo_documento" name="tipo_documento" required>
                            @foreach (Voyager::tipoDocumento() as $tipo_documento)
                                <option value="{{ $tipo_documento->id }}"
                                    {{ $tipo_documento->id == $selected_tipo_documento ? 'selected' : '' }}>
                                    {{ $tipo_documento->tipo_documento }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-label for="username" value="{{ __('Numero de Identificación') }}" />
                        <x-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')"
                            required autofocus autocomplete="username" pattern="[0-9]*"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
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
                                        {!! __('Acepto los :terms_of_service', [
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
