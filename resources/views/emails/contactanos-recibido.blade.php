@component('mail::message')

    # Nuevo mensaje de contacto

    - Nombre: {{ $name }}

    - Email: {{ $email }}

    - Asunto: {{ $subject }}

    - Mensaje:
    {{ $messageContent }}
@endcomponent
