<x-mail::message>

    # POR FAVOR NO RESPONDA ESTE EMAIL
    Se ha recepcionado a través de la Ventanilla única virtual una inscripción con los siguientes datos:

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
