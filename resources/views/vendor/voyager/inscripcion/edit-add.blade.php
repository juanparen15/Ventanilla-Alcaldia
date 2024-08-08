@php
    $edit = !is_null($dataTypeContent->getKey());
    $add = is_null($dataTypeContent->getKey());
@endphp

@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title', __('voyager::generic.' . ($edit ? 'edit' : 'add')) . ' ' .
    $dataType->getTranslatedAttribute('display_name_singular'))

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager::generic.' . ($edit ? 'edit' : 'add')) . ' ' . $dataType->getTranslatedAttribute('display_name_singular') }}
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">
                    <!-- form start -->
                    <form role="form" class="form-edit-add"
                        action="{{ $edit ? route('voyager.' . $dataType->slug . '.update', $dataTypeContent->getKey()) : route('voyager.' . $dataType->slug . '.store') }}"
                        method="POST" enctype="multipart/form-data">
                        <!-- PUT Method if we are editing -->
                        @if ($edit)
                            {{ method_field('PUT') }}
                        @endif

                        <!-- CSRF TOKEN -->
                        {{ csrf_field() }}

                        <div class="panel-body">

                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Adding / Editing -->
                            @php
                                $dataTypeRows = $dataType->{$edit ? 'editRows' : 'addRows'};
                            @endphp

                            {{-- @foreach ($dataTypeRows as $row)
                                <!-- GET THE DISPLAY OPTIONS -->
                                @php
                                    $display_options = $row->details->display ?? null;
                                    if ($dataTypeContent->{$row->field . '_' . ($edit ? 'edit' : 'add')}) {
                                        $dataTypeContent->{$row->field} =
                                            $dataTypeContent->{$row->field . '_' . ($edit ? 'edit' : 'add')};
                                    }
                                @endphp
                                @if (isset($row->details->legend) && isset($row->details->legend->text))
                                    <legend class="text-{{ $row->details->legend->align ?? 'center' }}"
                                        style="background-color: {{ $row->details->legend->bgcolor ?? '#f0f0f0' }};padding: 5px;">
                                        {{ $row->details->legend->text }}</legend>
                                @endif

                                <div class="form-group @if ($row->type == 'hidden') hidden @endif col-md-{{ $display_options->width ?? 12 }} {{ $errors->has($row->field) ? 'has-error' : '' }}"
                                    @if (isset($display_options->id)) {{ "id=$display_options->id" }} @endif>
                                    {{ $row->slugify }}
                                    <h5 class="control-label" for="name">
                                        {{ $row->getTranslatedAttribute('display_name') }}</h5>
                                    @include('voyager::multilingual.input-hidden-bread-edit-add')
                                    @if ($add && isset($row->details->view_add))
                                        @include($row->details->view_add, [
                                            'row' => $row,
                                            'dataType' => $dataType,
                                            'dataTypeContent' => $dataTypeContent,
                                            'content' => $dataTypeContent->{$row->field},
                                            'view' => 'add',
                                            'options' => $row->details,
                                        ])
                                    @elseif ($edit && isset($row->details->view_edit))
                                        @include($row->details->view_edit, [
                                            'row' => $row,
                                            'dataType' => $dataType,
                                            'dataTypeContent' => $dataTypeContent,
                                            'content' => $dataTypeContent->{$row->field},
                                            'view' => 'edit',
                                            'options' => $row->details,
                                        ])
                                    @elseif (isset($row->details->view))
                                        @include($row->details->view, [
                                            'row' => $row,
                                            'dataType' => $dataType,
                                            'dataTypeContent' => $dataTypeContent,
                                            'content' => $dataTypeContent->{$row->field},
                                            'action' => $edit ? 'edit' : 'add',
                                            'view' => $edit ? 'edit' : 'add',
                                            'options' => $row->details,
                                        ])
                                    @elseif ($row->type == 'relationship')
                                        @include('voyager::formfields.relationship', [
                                            'options' => $row->details,
                                        ])
                                    @else
                                        @if ($row->type == 'text')
                                            <input type="text" class="form-control formatted-number"
                                                name="{{ $row->field }}" value="{{ $dataTypeContent->{$row->field} }}">
                                        @else
                                            {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                                        @endif
                                    @endif

                                    @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                        {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                    @endforeach
                                    @if ($errors->has($row->field))
                                        @foreach ($errors->get($row->field) as $error)
                                            <span class="help-block">{{ $error }}</span>
                                        @endforeach
                                    @endif
                                </div>
                            @endforeach --}}

                            <div class="form-group">
                                <h5>{{ __('¿Acepta las políticas de tratamiento de datos?') }}</h5>
                                <div class="toggle-switch">
                                    <input type="checkbox" id="acepta_politicas" name="acepta_politicas"
                                        {{ old('acepta_politicas', $dataTypeContent->acepta_politicas ?? '') == 'SI' ? 'checked' : '' }}>
                                </div>
                            </div>

                            <!-- Campo de categoría -->
                            @php
                                if (isset($dataTypeContent->codigo_tipo_categoria)) {
                                    $selected_categoria = $dataTypeContent->codigo_tipo_categoria;
                                } else {
                                    $selected_categoria = null; // Cambia '' por null
                                }
                            @endphp
                            {{-- <div class="form-group">
                                <h5 for="codigo_tipo_categoria">{{ __('Categoria') }}</h5>
                                <select name="codigo_tipo_categoria" id="codigo_tipo_categoria"
                                    class="form-control select2">
                                    @foreach (Voyager::categoria() as $categoria)
                                        <option value="{{ $categoria->codigo_tipo_categoria }}"
                                            {{ $categoria->codigo_tipo_categoria == $selected_categoria ? 'selected' : '' }}>
                                            {{ $categoria->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <!-- Campo de categoría -->
                            <div class="form-group">
                                <h5 for="codigo_tipo_categoria">{{ __('Categoría') }}</h5>
                                <select name="codigo_tipo_categoria" id="codigo_tipo_categoria"
                                    class="form-control select2">
                                    <option value="" disabled selected>Seleccione una Categoría</option>
                                    @if (is_array(Voyager::categoria()) || is_object(Voyager::categoria()))
                                        @foreach (Voyager::categoria() as $categoria)
                                            <option value="{{ $categoria['codigo_tipo_categoria'] }}"
                                                {{ $categoria['codigo_tipo_categoria'] == $selected_categoria ? 'selected' : '' }}>
                                                {{ $categoria['nombre_completo'] }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            @php
                                // Obtener el ID del usuario autenticado
                                $userId = Auth::id();

                                // Método para verificar si el usuario ya está registrado en un evento
                                function isRegistered($userId, $eventoId)
                                {
                                    return \App\Models\Inscripcion::where('user_id', $userId)
                                        ->where('codigo_evento', $eventoId)
                                        ->exists();
                                }

                                if (isset($dataTypeContent->codigo_evento)) {
                                    $selected_evento = $dataTypeContent->codigo_evento;
                                } else {
                                    $selected_evento = null; // Cambia '' por null
                                }
                            @endphp

                            <!-- Campo de evento -->
                            <div class="form-group">
                                <h5 for="codigo_evento">{{ __('Evento') }}</h5>
                                <select name="codigo_evento" id="codigo_evento" class="form-control select2">
                                    <option value="" disabled selected>Seleccione un Evento</option>
                                    @if (is_array(Voyager::eventos()) || is_object(Voyager::eventos()))
                                        @foreach (Voyager::eventos() as $evento)
                                            @php
                                                // Verifica si el usuario ya está registrado en el evento
                                                $isRegistered = isRegistered($userId, $evento->codigo_evento);
                                            @endphp

                                            @if (!$isRegistered)
                                                <!-- Muestra la opción solo si no está registrado -->
                                                <option value="{{ $evento->codigo_evento }}"
                                                    {{ $evento->codigo_evento == $selected_evento ? 'selected' : '' }}>
                                                    {{ $evento->nombre_evento }}
                                                </option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            @php
                            // Decodificar los datos almacenados en formato JSON
                            $selected_modalidad_arma = isset($dataTypeContent->codigo_tipo_arma_evento)
                                ? json_decode($dataTypeContent->codigo_tipo_arma_evento, true) // true para obtener un array
                                : [];
                        @endphp
                        
                        <div class="form-group">
                            <h5 for="codigo_tipo_arma_evento">Modalidades de Arma - (Seleccione Una o Varias)</h5>
                            <select multiple class="form-control select2" id="modalidad_arma" name="codigo_tipo_arma_evento[]">
                                @foreach (Voyager::evento_detalle() as $modalidadArma)
                                    <option value="{{ $modalidadArma->codigo_evento }}"
                                        {{ in_array($modalidadArma->codigo_evento, $selected_modalidad_arma) ? 'selected' : '' }}>
                                        {{ $modalidadArma->evento->nombre_evento }} -
                                        {{ $modalidadArma->tipoArma->arma }} -
                                        {{ $modalidadArma->tipoModalidadArma->modalidad }} -
                                        {{ $modalidadArma->horario }} - {{ $modalidadArma->lugar }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                                            
                            @php
                                // Decodificar los datos almacenados en formato JSON
                                $selected_arma = isset($dataTypeContent->codigo_arma)
                                    ? json_decode($dataTypeContent->codigo_arma)
                                    : [];
                            @endphp

                            <!-- Selector Múltiple de Tipo de Arma -->
                            <div class="form-group">
                                <h5 for="codigo_arma">Mi Galería de Armas - (Seleccione Una o Varias)</h5>
                                <select multiple class="form-control select2" id="codigo_arma" name="codigo_arma[]">
                                    @if (is_array(Voyager::armas()) || is_object(Voyager::armas()))
                                        @foreach (Voyager::armas() as $arma)
                                            <option value="{{ $arma->codigo_arma }}"
                                                {{ in_array($arma->codigo_arma, $selected_arma) ? 'selected' : '' }}
                                                data-metodo-propulsion="{{ $arma->metodoPropulsion->metodo_propulsion }}">
                                                {{ $arma->metodoPropulsion->metodo_propulsion }} -
                                                {{ $arma->numero_serie }} -
                                                {{ $arma->tipoArma->arma }} - {{ $arma->calibre->nombre_comun }} -
                                                {{ $arma->tipoPropiedad->tipo_propiedad }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>


                            <div class="form-group">
                                <h5 for="valor">{{ __('Valor') }}</h5>
                                <input type="text" class="form-control formatted-number" id="valor" name="valor"
                                    placeholder="{{ __('Valor') }}"
                                    value="{{ old('valor', $dataTypeContent->valor ?? '') }}">
                            </div>

                            <div class="form-group">
                                <a target="blank" type="button" class="btn btn-primary float-right"
                                    href="https://checkout.wompi.co/l/0vsdUZ"><i class="voyager-paypal"></i> PAGOS EN
                                    LINEA</a>
                            </div>

                            <div class="form-group">
                                <h5 for="comprobante_pago">{{ __('Número Comprobante de Pago') }}</h5>
                                <input type="text" class="form-control" id="comprobante_pago" name="comprobante_pago"
                                    placeholder="{{ __('Número Comprobante de Pago') }}"
                                    value="{{ old('comprobante_pago', $dataTypeContent->comprobante_pago ?? '') }}">
                            </div>
                            <div class="form-group">
                                @if (
                                    !empty($dataTypeContent->pdf_comprobante_pago) &&
                                        (is_array(json_decode($dataTypeContent->pdf_comprobante_pago)) ||
                                            is_object(json_decode($dataTypeContent->pdf_comprobante_pago))))
                                    @foreach (json_decode($dataTypeContent->pdf_comprobante_pago) as $pdf)
                                        <div class="file-preview">
                                            <a href="{{ filter_var($pdf->download_link ?? '', FILTER_VALIDATE_URL) ? $pdf->download_link : Voyager::image($pdf->download_link) }}"
                                                target="_blank">
                                                {{ $pdf->original_name ?? basename($pdf->download_link) }}
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="custom-file">
                                    <label class="btn btn-primary" for="fileInput">Seleccionar Comprobantes de Pago</label>
                                    <input type="file" class="custom-file-input" id="fileInput"
                                        data-name="pdf_comprobante_pago" accept=".pdf" name="pdf_comprobante_pago"
                                        style="display: none;">
                                    <span id="fileLabel"></span>
                                </div>
                            </div>

                            {{-- <div id="permisoPorteFields" style="display: none;">
                                <div class="form-group">
                                    <h5 for="fecha_permiso_porte">{{ __('Fecha de Permiso de Porte') }}</h5>
                                    <input type="text" class="form-control datepicker" id="fecha_permiso_porte"
                                        name="fecha_permiso_porte" placeholder="{{ __('Fecha de Permiso de Porte') }}"
                                        value="{{ old('fecha_permiso_porte', $dataTypeContent->fecha_permiso_porte ?? '') }}">
                                </div>

                                <div class="form-group">
                                    <h5 for="numero_permiso_porte">{{ __('Número de Permiso de Porte') }}</h5>
                                    <input type="text" class="form-control" id="numero_permiso_porte"
                                        name="numero_permiso_porte" placeholder="{{ __('Numero de Permiso de Porte') }}"
                                        value="{{ old('numero_permiso_porte', $dataTypeContent->numero_permiso_porte ?? '') }}">
                                </div>

                                <div class="form-group">
                                    <h5 for="titular_permiso_porte">{{ __('Titular de Permiso de Porte') }}</h5>
                                    <input type="text" class="form-control" id="titular_permiso_porte"
                                        name="titular_permiso_porte"
                                        placeholder="{{ __('Titular de Permiso de Porte') }}"
                                        value="{{ old('titular_permiso_porte', $dataTypeContent->titular_permiso_porte ?? '') }}">
                                </div>
                            </div> --}}

                            <div class="form-group" id="consentimientoPadresGroup" style="display: block;">
                                @if (
                                    !empty($dataTypeContent->consentimiento_padres) &&
                                        (is_array(json_decode($dataTypeContent->consentimiento_padres)) ||
                                            is_object(json_decode($dataTypeContent->consentimiento_padres))))
                                    @foreach (json_decode($dataTypeContent->consentimiento_padres) as $pdf)
                                        <div class="file-preview">
                                            <a href="{{ filter_var($pdf->download_link ?? '', FILTER_VALIDATE_URL) ? $pdf->download_link : Voyager::image($pdf->download_link) }}"
                                                target="_blank">
                                                {{ $pdf->original_name ?? basename($pdf->download_link) }}
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="custom-file">
                                    <label class="btn btn-primary" for="fileInputPadres">Seleccionar Consentimiento de
                                        Padres</label>
                                    <input type="file" class="custom-file-input" id="fileInputPadres"
                                        data-name="consentimiento_padres" accept=".pdf" name="consentimiento_padres"
                                        style="display: none;">
                                    <span id="fileLabelPadres"></span>
                                </div>
                            </div>

                            <!-- Campo de archivo de Permiso de Porte -->
                            <div class="form-group" id="permisoPorteFileGroup" style="display: none;">
                                @if (
                                    !empty($dataTypeContent->pdf_permiso_porte) &&
                                        (is_array(json_decode($dataTypeContent->pdf_permiso_porte)) ||
                                            is_object(json_decode($dataTypeContent->pdf_permiso_porte))))
                                    @foreach (json_decode($dataTypeContent->pdf_permiso_porte) as $pdf)
                                        <div class="file-preview">
                                            <a href="{{ filter_var($pdf->download_link ?? '', FILTER_VALIDATE_URL) ? $pdf->download_link : Voyager::image($pdf->download_link) }}"
                                                target="_blank">
                                                {{ $pdf->original_name ?? basename($pdf->download_link) }}
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="custom-file">
                                    <label class="btn btn-primary" for="fileInputPermisoPorte">Seleccionar Permiso de
                                        Porte</label>
                                    <input type="file" class="custom-file-input" id="fileInputPermisoPorte"
                                        data-name="pdf_permiso_porte" accept=".pdf" name="pdf_permiso_porte"
                                        style="display: none;">
                                    <span id="fileLabelPermisoPorte"></span>
                                </div>
                            </div>


                        </div><!-- panel-body -->

                        <div class="panel-footer">
                        @section('submit-buttons')
                            <button type="submit"
                                class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
                        @stop
                        @yield('submit-buttons')
                    </div>
                </form>

                <div style="display:none">
                    <input type="hidden" id="upload_url" value="{{ route('voyager.upload') }}">
                    <input type="hidden" id="upload_type_slug" value="{{ $dataType->slug }}">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-danger" id="confirm_delete_modal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="voyager-warning"></i> {{ __('voyager::generic.are_you_sure') }}
                </h4>
            </div>

            <div class="modal-body">
                <h4>{{ __('voyager::generic.are_you_sure_delete') }} '<span class="confirm_delete_name"></span>'</h4>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                    data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                <button type="button" class="btn btn-danger"
                    id="confirm_delete">{{ __('voyager::generic.delete_confirm') }}</button>
            </div>
        </div>
    </div>
</div>
<!-- End Delete File Modal -->
@stop

@section('javascript')
<script>
    var params = {};
    var $file;

    function deleteHandler(tag, isMulti) {
        return function() {
            $file = $(this).siblings(tag);

            params = {
                slug: '{{ $dataType->slug }}',
                filename: $file.data('file-name'),
                id: $file.data('id'),
                field: $file.parent().data('field-name'),
                multi: isMulti,
                _token: '{{ csrf_token() }}'
            }

            $('.confirm_delete_name').text(params.filename);
            $('#confirm_delete_modal').modal('show');
        };
    }

    $(document).ready(function() {
        function formatNumberWithDecimals(x) {
            if (x === "") return "";

            // Convertir a número de punto flotante y luego a cadena con 2 decimales
            var number = parseFloat(x).toFixed(2);

            // Asegurarse de que el número no tenga más de 15 dígitos enteros
            var parts = number.split('.');
            if (parts[0].length > 15) {
                parts[0] = parts[0].slice(-15); // Mantener solo los últimos 15 dígitos si hay más
            }

            return parts.join('.');
        }

        // Formatear todos los campos de entrada al cargar la página
        $('input.formatted-number').each(function() {
            var $input = $(this);
            var value = $input.val().replace(/[^0-9.]/g,
                ''); // Eliminar caracteres no numéricos excepto el punto
            $input.val(formatNumberWithDecimals(value)); // Formatear con decimales
        });

        // Formatear el campo de entrada en tiempo real mientras el usuario escribe
        $('input.formatted-number').on('input', function() {
            var $input = $(this);
            var value = $input.val();

            // Permitir solo caracteres numéricos y el punto
            var sanitizedValue = value.replace(/[^0-9.]/g, '');

            // Prevenir múltiples puntos decimales
            var parts = sanitizedValue.split('.');
            if (parts.length > 2) {
                sanitizedValue = parts[0] + '.' + parts[1];
            }

            // Limitar a 2 decimales
            if (parts.length == 2) {
                parts[1] = parts[1].slice(0, 2);
                sanitizedValue = parts.join('.');
            }

            // Asegurarse de que la parte entera no tenga más de 15 dígitos
            if (parts[0].length > 15) {
                parts[0] = parts[0].slice(-15); // Mantener solo los últimos 15 dígitos si hay más
                sanitizedValue = parts.join('.');
            }

            $input.val(sanitizedValue);
        });

        // Existing initialization scripts
        $('.toggleswitch').bootstrapToggle();

        $('.form-group input[type=date]').each(function(idx, elt) {
            if (elt.hasAttribute('data-datepicker')) {
                elt.type = 'text';
                $(elt).datetimepicker($(elt).data('datepicker'));
            } else if (elt.type != 'date') {
                elt.type = 'text';
                $(elt).datetimepicker({
                    format: 'L',
                    extraFormats: ['YYYY-MM-DD']
                }).datetimepicker($(elt).data('datepicker'));
            }
        });

        @if ($isModelTranslatable)
            $('.side-body').multilingual({
                "editing": true
            });
        @endif

        $('.side-body input[data-slug-origin]').each(function(i, el) {
            $(el).slugify();
        });

        $('.form-group').on('click', '.remove-multi-image', deleteHandler('img', true));
        $('.form-group').on('click', '.remove-single-image', deleteHandler('img', false));
        $('.form-group').on('click', '.remove-multi-file', deleteHandler('a', true));
        $('.form-group').on('click', '.remove-single-file', deleteHandler('a', false));

        $('#confirm_delete').on('click', function() {
            $.post('{{ route('voyager.' . $dataType->slug . '.media.remove') }}', params, function(
                response) {
                if (response && response.data && response.data.status && response.data.status ==
                    200) {
                    toastr.success(response.data.message);
                    $file.parent().fadeOut(300, function() {
                        $(this).remove();
                    });
                } else {
                    toastr.error("Error removing file.");
                }
            });

            $('#confirm_delete_modal').modal('hide');
        });

        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

<script>
    var codigoEvento = $('#codigo_evento');
    var modalidadArma = $('#modalidad_arma');

    $(document).ready(function() {
        codigoEvento.change(function() {
            var codigoEventoVal = $(this).val(); // Obtener el ID del evento seleccionado
            if (codigoEventoVal) {
                $.get('/get-modalidades-by-evento/' + codigoEventoVal, function(data) {
                    modalidadArma.empty();
                    $.each(data, function(key, value) {
                        modalidadArma.append('<option value="' +
                            value.codigo_evento_detalle + '">' +
                            value.evento.nombre_evento + ' - ' +
                            value.tipo_arma.arma + ' - ' +
                            value.tipo_modalidad_arma.modalidad + ' - ' +
                            value.horario + ' - ' + value.lugar +
                            '</option>');
                    });
                });
            } else {
                modalidadArma.empty();
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Inicializar el datetimepicker
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd', // Formato de la fecha
            autoclose: true, // Cerrar automáticamente después de seleccionar la fecha
            todayHighlight: true, // Resaltar la fecha actual
            startDate: 'today' // Iniciar desde la fecha actual
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.toggle-switch input[type="checkbox"]').bootstrapToggle({
            on: '{{ __('SI') }}',
            off: '{{ __('NO') }}',
            size: 'small', // Puedes ajustar el tamaño aquí
            onstyle: 'success', // Estilo para "SI"
            offstyle: 'danger' // Estilo para "NO"
        });
    });
</script>
<script>
    $(document).ready(function() {
        var additionalConfig = {
            selector: 'textarea.richTextBox[name="observaciones"]',
        }

        $.extend(additionalConfig, {!! json_encode($options->tinymceOptions ?? (object) []) !!})

        tinymce.init(window.voyagerTinyMCE.getConfig(additionalConfig));
    });
</script>

<script>
    $(document).ready(function() {
        // Función para comprobar la selección y mostrar/ocultar campos
        function checkArmaSelection() {
            var selectedArmas = $('#codigo_arma').val();
            var showFields = false;

            // Obtener las armas y sus métodos de propulsión
            @foreach (Voyager::armas() as $arma)
                if (selectedArmas.includes('{{ $arma->codigo_arma }}') &&
                    '{{ strtolower($arma->metodoPropulsion->metodo_propulsion) }}' === 'fuego') {
                    showFields = true;
                }
            @endforeach

            // Mostrar u ocultar los campos de permiso de porte
            if (showFields) {
                $('#permisoPorteFileGroup').show();
                // Hacer obligatorios los campos si se muestran
                $('#fileInputPermisoPorte').attr('required', true);
            } else {
                $('#permisoPorteFileGroup').hide();
                $('#fileInputPermisoPorte').removeAttr('required');
            }
        }

        // Ejecutar la función al cargar la página y al cambiar la selección
        checkArmaSelection();
        $('#codigo_arma').change(checkArmaSelection);
    });
</script>


<script>
    $(document).ready(function() {
        // Función para actualizar el nombre de los archivos seleccionados
        function updateFileLabel(inputId, labelId, newFileName) {
            $('#' + inputId).on('change', function() {
                var files = $(this)[0].files;
                if (files.length > 0) {
                    // Crear un nuevo archivo con el nombre deseado
                    var file = files[0];
                    var renamedFile = new File([file], newFileName, {
                        type: file.type
                    });

                    // Crear un nuevo objeto FileList con el archivo renombrado
                    var dataTransfer = new DataTransfer();
                    dataTransfer.items.add(renamedFile);

                    // Asignar el nuevo objeto FileList al input de archivo
                    $('#' + inputId)[0].files = dataTransfer.files;

                    // Actualizar la etiqueta del archivo
                    $('#' + labelId).text(newFileName);
                }
            });
        }

        // Llamar a la función para cada grupo de archivos con el nuevo nombre deseado
        updateFileLabel('fileInput', 'fileLabel', 'consignación.pdf');
        updateFileLabel('fileInputPadres', 'fileLabelPadres', 'cpadres.pdf');
        updateFileLabel('fileInputPermisoPorte', 'fileLabelPermisoPorte', 'porte.pdf');
    });
</script>

<script>
    $(document).ready(function() {

        var userAge = {{ voyager::edad() }}; // Edad del usuario autenticado

        // Mostrar/ocultar el campo de consentimiento de padres según la edad del usuario
        if (userAge < 18) {
            $('#consentimientoPadresGroup').show();
        } else {
            $('#consentimientoPadresGroup').hide();
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    $(document).ready(function() {
        $('form').submit(function(event) {
            var isValid = true; // Variable para verificar la validez del formulario

            // Validar campo de Comprobantes de Pago
            if ($('#fileInput').get(0).files.length === 0) {
                // Mostrar SweetAlert2 para el mensaje de error
                Swal.fire({
                    title: 'Debe seleccionar al menos un archivo para Comprobantes de Pago',
                    icon: 'error',
                    confirmButtonText: 'Entendido'
                });
                isValid = false; // Marcar el formulario como inválido
            }

            // Validar campo de Permiso de Porte si es visible
            if ($('#permisoPorteFileGroup').is(':visible') && $('#fileInputPermisoPorte').get(0).files
                .length === 0) {
                // Mostrar SweetAlert2 para el mensaje de error
                Swal.fire({
                    title: 'Debe seleccionar al menos un archivo para Permiso de Porte',
                    icon: 'error',
                    confirmButtonText: 'Entendido'
                });
                isValid = false; // Marcar el formulario como inválido
            }

            var edad = {{ voyager::edad() }};

            // Validar campo de Consentimiento de Padres si es visible
            if (edad < 18 && $('#fileInputPadres').get(0).files.length === 0) {
                // Mostrar SweetAlert2 para el mensaje de error
                Swal.fire({
                    title: 'Debe seleccionar al menos un archivo para Consentimiento de Padres',
                    icon: 'error',
                    confirmButtonText: 'Entendido'
                });
                isValid = false; // Marcar el formulario como inválido
            }

            // Si el formulario no es válido, detener el envío del formulario
            if (!isValid) {
                event.preventDefault();
            }
        });
    });
</script>



<script>
    $(document).ready(function() {
        // Intercepta el envío del formulario
        $('.form-edit-add').on('submit', function(event) {
            // Verifica si no se han aceptado las políticas
            if ($('input[name="acepta_politicas"]').length > 0 && !$('input[name="acepta_politicas"]')
                .is(':checked')) {
                // Evita el envío del formulario
                event.preventDefault();

                // Muestra SweetAlert2 para confirmar la acción
                Swal.fire({
                    title: 'Debe aceptar las políticas',
                    text: 'Por favor, acepte las políticas antes de continuar.',
                    icon: 'warning',
                    confirmButtonText: 'Entendido'
                });
                return;
            }

            // Verifica si se ha seleccionado un evento
            if ($('select[name="codigo_evento"]').val() === null) {
                // Evita el envío del formulario
                event.preventDefault();

                // Muestra SweetAlert2 para informar al usuario
                Swal.fire({
                    title: 'Debe seleccionar un Evento',
                    text: 'Por favor, seleccione un Evento antes de continuar.',
                    icon: 'warning',
                    confirmButtonText: 'Entendido'
                });
                return;
            }
            // Verifica si se ha seleccionado una categoría
            if ($('select[name="codigo_tipo_categoria"]').val() === null) {
                // Evita el envío del formulario
                event.preventDefault();

                // Muestra SweetAlert2 para informar al usuario
                Swal.fire({
                    title: 'Debe seleccionar una categoría',
                    text: 'Por favor, seleccione una categoría antes de continuar.',
                    icon: 'warning',
                    confirmButtonText: 'Entendido'
                });
                return;
            }

            // Verifica si se ha seleccionado al menos una modalidad de arma
            if ($('select[name="codigo_tipo_arma_evento[]"]').val().length === 0) {
                // Evita el envío del formulario
                event.preventDefault();

                // Muestra SweetAlert2 para informar al usuario
                Swal.fire({
                    title: 'Debe seleccionar al menos una modalidad de arma',
                    text: 'Por favor, seleccione al menos una modalidad de arma antes de continuar.',
                    icon: 'warning',
                    showCancelButton: false,
                    confirmButtonText: 'Entendido'
                });
                return;
            }

            // Verifica si se ha ingresado un valor
            if ($('#valor').val().trim() === '') {
                // Evita el envío del formulario
                event.preventDefault();

                // Muestra SweetAlert2 para informar al usuario
                Swal.fire({
                    title: 'Debe ingresar un valor',
                    text: 'Por favor, ingrese un valor antes de continuar.',
                    icon: 'warning',
                    showCancelButton: false,
                    confirmButtonText: 'Entendido'
                });
                return;
            }

            // Verifica si se ha ingresado un número de comprobante de pago
            if ($('#comprobante_pago').val().trim() === '') {
                // Evita el envío del formulario
                event.preventDefault();

                // Muestra SweetAlert2 para informar al usuario
                Swal.fire({
                    title: 'Debe ingresar un número de comprobante de pago',
                    text: 'Por favor, ingrese un número de comprobante de pago antes de continuar.',
                    icon: 'warning',
                    showCancelButton: false,
                    confirmButtonText: 'Entendido'
                });
                return;
            }

            // Verifica si se ha seleccionado al menos un tipo de arma
            if ($('select[name="codigo_arma[]"]').val().length === 0) {
                // Evita el envío del formulario
                event.preventDefault();

                // Muestra SweetAlert2 para informar al usuario
                Swal.fire({
                    title: 'Debe seleccionar un tipo de arma',
                    text: 'Por favor, crea o selecciona al menos un tipo de arma antes de continuar.',
                    icon: 'warning',
                    showCancelButton: false,
                    confirmButtonText: 'Entendido'
                });
                return;
            }
        });

        $(document).ready(function() {
            // Función para actualizar el valor de inscripción
            function updateValorInscripcion() {
                var modalidadesSeleccionadas = $('#modalidad_arma').val();
                var codigoTipoArma = $('#codigo_tipo_arma').val(); // Ajusta según tu estructura
                var codigoTipoCategoria = $('#codigo_tipo_categoria')
                    .val(); // Ajusta según tu estructura

                // Verificar si se ha seleccionado al menos una modalidad de arma
                if (modalidadesSeleccionadas.length === 0) {
                    $('#valor').val('');
                    return;
                }

                $.ajax({
                    url: '/get-valor-inscripcion',
                    type: 'POST',
                    data: {
                        modalidades_seleccionadas: modalidadesSeleccionadas,
                        codigo_tipo_arma: codigoTipoArma,
                        codigo_tipo_categoria: codigoTipoCategoria,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#valor').val(response.valor);
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'Entendido'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error',
                            text: 'No se pudo obtener el valor. Inténtelo nuevamente.',
                            icon: 'error',
                            confirmButtonText: 'Entendido'
                        });
                    }
                });
            }

            // Llamar a la función de actualización al cargar la página
            updateValorInscripcion();

            // Llamar a la función de actualización cuando cambie alguno de los selectores
            $('#modalidad_arma, #codigo_tipo_arma, #codigo_tipo_categoria').change(function() {
                updateValorInscripcion();
            });

            // También asegúrate de que la función se llame cuando se cargue la página por primera vez
            $(window).on('load', function() {
                updateValorInscripcion();
            });
        });
    });
</script>
@stop
