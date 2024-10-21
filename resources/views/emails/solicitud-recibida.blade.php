<x-mail::message>
    # POR FAVOR NO RESPONDA ESTE EMAIL, ESTA ES UNA NOTIFICACIÓN ELECTRÓNICA AUTOMÁTICA

    Se ha recepcionado a través de la Ventanilla Única Virtual una solicitud con los siguientes datos:

    - Fecha de Solicitud: {{ now()->format('d-m-Y \a \l\a\s H:i:s') }}
    - Nombre solicitante: {{ $usuario->primer_nombre }} {{ $usuario->segundo_nombre }} {{ $usuario->primer_apellido }} {{ $usuario->segundo_apellido }}
    - Identificación: {{ $usuario->documento_tercero }}
    - Email: {{ $usuario->email }}
    - Móvil: {{ $usuario->movil }}
    - Dirección: {{ $usuario->direccion }}
    - Ciudad: {{ $usuario->Municipios->municipio }}
    - Tipo petición: {{ $solicitud->tipo_peticion }}
    - Mensaje: {{ $solicitud->mensaje }}

    Saludos,
    {{ config('app.name') }}
</x-mail::message>
