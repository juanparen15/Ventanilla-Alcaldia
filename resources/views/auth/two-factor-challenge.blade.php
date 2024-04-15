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

                <div x-data="{ recovery: false }">
                    <div class="mb-4 text-sm text-gray-600" x-show="! recovery">
                        {{ __('Confirme el acceso a su cuenta ingresando el código de autenticación proporcionado por su aplicación de autenticación.') }}
                    </div>

                    <div class="mb-4 text-sm text-gray-600" x-cloak x-show="recovery">
                        {{ __('Confirme el acceso a su cuenta ingresando uno de sus códigos de recuperación de emergencia.') }}
                    </div>

                    <x-validation-errors class="mb-4" />

                    <form method="POST" action="{{ route('two-factor.login') }}">
                        @csrf

                        <div class="mt-4" x-show="! recovery">
                            <x-label for="code" value="{{ __('Codigo') }}" />
                            <x-input id="code" class="block mt-1 w-full" type="text" inputmode="numeric"
                                name="code" autofocus x-ref="code" autocomplete="one-time-code" />
                        </div>

                        <div class="mt-4" x-cloak x-show="recovery">
                            <x-label for="recovery_code" value="{{ __('Código de recuperación') }}" />
                            <x-input id="recovery_code" class="block mt-1 w-full" type="text" name="recovery_code"
                                x-ref="recovery_code" autocomplete="one-time-code" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="button"
                                class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer"
                                x-show="! recovery"
                                x-on:click="
                                        recovery = true;
                                        $nextTick(() => { $refs.recovery_code.focus() })
                                    ">
                                {{ __('Utilice un código de recuperación') }}
                            </button>

                            <button type="button"
                                class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer" x-cloak
                                x-show="recovery"
                                x-on:click="
                                        recovery = false;
                                        $nextTick(() => { $refs.code.focus() })
                                    ">
                                {{ __('Utilice un código de autenticación') }}
                            </button>

                            <x-button class="ml-4">
                                {{ __('Iniciar Sesión') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </x-authentication-card>
        </x-guest-layout>
    </div> <!-- .login-container -->
@endsection
