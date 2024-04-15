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

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="block">
                        <x-label for="email" value="{{ __('Correo') }}" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)"
                            required autofocus autocomplete="username" />
                    </div>

                    <div class="mt-4">
                        <x-label for="password" value="{{ __('Contraseña') }}" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                            autocomplete="new-password" />
                    </div>

                    <div class="mt-4">
                        <x-label for="password_confirmation" value="{{ __('Confirmar Contraseña') }}" />
                        <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                            name="password_confirmation" required autocomplete="new-password" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-button>
                            {{ __('Restablecer la contraseña') }}
                        </x-button>
                    </div>
                </form>
            </x-authentication-card>
        </x-guest-layout>
    </div> <!-- .login-container -->
@endsection
