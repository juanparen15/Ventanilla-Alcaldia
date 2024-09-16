<x-mail::message>

    # Inscripción a Evento

    Hola {{ $usuario->primer_nombre }} {{ $usuario->primer_apellido }},

    Se ha inscrito a un Evento deportivo con la siguiente información:

    VENTANILLA revisará la información enviada junto con los documentos de soporte para dejar en firme su inscripción, la cual se recibió con la siguiente información:

    - Nombre evento: {{ $inscripcion->evento->codigo_evento }} - {{ $inscripcion->evento->nombre_evento }}
    - Deportista: {{ $usuario->primer_nombre }} {{ $usuario->segundo_nombre }} {{ $usuario->primer_apellido }} {{ $usuario->segundo_apellido }}
    - Club: {{ $inscripcion->usuario->Club->club }}
    - Liga: {{ $inscripcion->usuario->Liga->liga }}
    @php
        $tipoArmasIds = json_decode($inscripcion->codigo_arma);
        $armas = [];
    @endphp
    @if ($tipoArmasIds && is_array($tipoArmasIds))
        @foreach ($tipoArmasIds as $armaId)
            @php
                $arma = \App\Models\Arma::find($armaId);
            @endphp
            @if ($arma)
                @php
                    $armas[] = $arma->tipoArma->arma;
                @endphp
            @endif
        @endforeach
    - Armas a competir: {{ implode(', ', $armas) }}
    @endif

    - Categoría Deportista: {{ $inscripcion->tipoCategoria->nombre }} {{ $inscripcion->tipoCategoria->uso_categoria }}

    Gracias,
    {{ config('app.name') }}

</x-mail::message>
