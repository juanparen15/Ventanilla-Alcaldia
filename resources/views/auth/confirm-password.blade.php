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

                <div class="mb-4 text-sm text-gray-600">
                    {{ __('Esta es un área segura de la aplicación. Confirme su contraseña antes de continuar.') }}
                </div>

                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <div>
                        <x-label for="password" value="{{ __('Contraseña') }}" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                            autocomplete="current-password" autofocus />
                    </div>

                    <div class="flex justify-end mt-4">
                        <x-button class="ml-4">
                            {{ __('Confirmar') }}
                        </x-button>
                    </div>
                </form>
            </x-authentication-card>
        </x-guest-layout>
    </div> <!-- .login-container -->
@endsection
