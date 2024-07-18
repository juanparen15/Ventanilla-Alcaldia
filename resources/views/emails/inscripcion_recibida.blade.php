<x-mail::message>

    # Inscripción a Evento

    Hola {{ $usuario->primer_nombre }} {{ $usuario->primer_apellido }},

    Se ha inscrito a un Evento deportivo con la siguiente información:

    - Nombre evento: {{ $inscripcion->codigo_evento }} - {{ $inscripcion->evento->nombre_evento }}
    - Deportista: {{ $usuario->primer_nombre }} {{ $usuario->segundo_nombre }} {{ $usuario->primer_apellido }} {{ $usuario->segundo_apellido }}
    {{-- @if ($usuario->club)
        - Club: {{ $usuario->club->club }}
    @endif
    @if ($usuario->liga)
        - Liga: {{ $usuario->liga->liga }}
    @endif --}}
    - Categoría Deportista: {{ $inscripcion->tipoCategoria->nombre }} {{ $inscripcion->tipoCategoria->uso_categoria }}

    Gracias,
    {{ config('app.name') }}

</x-mail::message>
