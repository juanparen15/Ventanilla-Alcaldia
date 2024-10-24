@php
    // Obtener el valor del estado desde la relación radicado y convertir a minúsculas
    $estado = strtolower($data->estado ?? 'Desconocido'); // Obtener el nombre del estado en minúsculas
    $color = '';

    switch ($estado) {
        case 'radicado': // Como ahora está en minúsculas, se compara con 'radicado'
            $color = 'yellow';
            break;
        case 'en proceso':
            $color = 'orange';
            break;
        case 'entregado':
            $color = 'green';
            break;
        case 'cancelado':
            $color = 'red';
            break;
        default:
            $color = 'grey';
            break;
    }
@endphp

<!-- Mostrar el círculo de color y el estado -->
<span style="display: inline-block; width: 15px; height: 15px; background-color: {{ $color }}; border-radius: 50%; margin-right: 10px;"></span>
{{ ucfirst($estado) }} <!-- ucfirst() capitaliza solo la primera letra del estado -->
