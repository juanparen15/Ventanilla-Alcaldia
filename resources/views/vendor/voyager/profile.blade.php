@extends('voyager::master')

@section('css')
    <style>
        .user-email {
            font-size: .85rem;
            margin-bottom: 1.5em;
        }
    </style>
@stop

@section('content')
    <div
        style="background-size:cover; background-image: url({{ Voyager::image(Voyager::setting('admin.bg_image'), voyager_asset('/images/bg.jpg')) }}); background-position: center center;position:absolute; top:0; left:0; width:100%; height:300px;">
    </div>
    <div style="height:160px; display:block; width:100%"></div>
    <div style="position:relative; z-index:9; text-align:center;">
        <img src="@if (!filter_var(Auth::user()->avatar, FILTER_VALIDATE_URL)) {{ Voyager::image(Auth::user()->avatar) }}@else{{ Auth::user()->avatar }} @endif"
            class="avatar" style="border-radius:50%; width:150px; height:150px; border:5px solid #fff;"
            alt="{{ Auth::user()->primer_nombre }} avatar">
        <h4>{{ ucwords(Auth::user()->primer_nombre) . ' ' . ucwords(Auth::user()->segundo_nombre) }}</h4>
        <div class="user-email text-muted">{{ ucwords(Auth::user()->email) }}</div>
        <p>{{ Auth::user()->bio }}</p>
        @if ($route != '')
            <a href="{{ $route }}" class="btn btn-primary">{{ __('voyager::profile.edit') }}</a>
        @endif
    </div>

    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Perfil') }}
            </h2>
        </x-slot>

        <div class="max-w-7xl mx-auto py-8 sm:px-6 lg:px-8">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-8 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                {{-- <x-section-border /> --}}
            @endif

            <div class="mt-8 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                {{-- <x-section-border /> --}}

                <div class="mt-8 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif
        </div>
    </x-app-layout>
@stop
