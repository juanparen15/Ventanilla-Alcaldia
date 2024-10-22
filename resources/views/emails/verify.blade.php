@component('mail::message')
    # Email Verification

    Gracias por registrarte.
    Tu código de seis dígitos es {{ $pin }}

    Gracias,
    {{ config('app.name') }}
@endcomponent
