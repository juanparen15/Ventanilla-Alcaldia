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

                            {{-- <!-- Adding / Editing -->
                            @php
                                $dataTypeRows = $dataType->{$edit ? 'editRows' : 'addRows'};
                            @endphp

                            @foreach ($dataTypeRows as $row)
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

                            @php
                                if (isset($dataTypeContent->codigo_metodo_propulsion)) {
                                    $selected_metodo_propulsion = $dataTypeContent->codigo_metodo_propulsion;
                                } else {
                                    $selected_metodo_propulsion = null;
                                }
                            @endphp
                            <div class="form-group">
                                <h5 for="codigo_metodo_propulsion">{{ __('Metodo de Propulsión') }}</h5>
                                <select name="codigo_metodo_propulsion" id="codigo_metodo_propulsion"
                                    class="form-control select2">
                                    <option value="" disabled selected>Seleccione un Metodo de Propulsión</option>
                                    @foreach (Voyager::propulsion() as $propulsion)
                                        <option value="{{ $propulsion->codigo_metodo_propulsion }}"
                                            {{ $propulsion->codigo_metodo_propulsion == $selected_metodo_propulsion ? 'selected' : '' }}>
                                            {{ $propulsion->metodo_propulsion }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group">
                                <h5 for="numero_serie">{{ __('Número de Serie') }}</h5>
                                <input type="text" class="form-control" id="numero_serie" name="numero_serie"
                                    placeholder="{{ __('Número de Serie') }}"
                                    value="{{ old('numero_serie', $dataTypeContent->numero_serie ?? '') }}">
                            </div>

                            @php
                                if (isset($dataTypeContent->codigo_tipo_arma)) {
                                    $selected_codigo_tipo_arma = $dataTypeContent->codigo_tipo_arma;
                                } else {
                                    $selected_codigo_tipo_arma = null;
                                }
                            @endphp
                            <div class="form-group">
                                <h5 for="codigo_tipo_arma">{{ __('Tipo de Arma') }}</h5>
                                <select name="codigo_tipo_arma" id="codigo_tipo_arma" class="form-control select2">
                                    <option value="" disabled selected>Seleccione un Tipo de Arma</option>
                                    @foreach (Voyager::tipo_arma() as $tipoArma)
                                        <option value="{{ $tipoArma->id }}"
                                            {{ $tipoArma->id == $selected_codigo_tipo_arma ? 'selected' : '' }}>
                                            {{ $tipoArma->arma }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group">
                                <h5 for="numero_salvoconducto">{{ __('Número de Salvoconducto') }}</h5>
                                <input type="text" class="form-control" id="numero_salvoconducto"
                                    name="numero_salvoconducto" placeholder="{{ __('Número de Salvoconducto') }}"
                                    value="{{ old('numero_salvoconducto', $dataTypeContent->numero_salvoconducto ?? '') }}">
                            </div>


                            @php
                                // Decodificar el dato almacenado en formato JSON
                                $selected_codigo_calibre = isset($dataTypeContent->codigo_calibre)
                                    ? json_decode($dataTypeContent->codigo_calibre)
                                    : null;
                            @endphp

                            <div class="form-group">
                                <h5 for="codigo_calibre">Tipo de Calibre</h5>
                                <select class="form-control select2" id="codigo_calibre" name="codigo_calibre">
                                    <option value="" disabled selected>Seleccione un Tipo de Calibre</option>
                                    @foreach (Voyager::tipo_calibre() as $tipoCalibre)
                                        <option value="{{ $tipoCalibre->codigo_calibre }}"
                                            {{ $tipoCalibre->codigo_calibre == $selected_codigo_calibre ? 'selected' : '' }}>
                                            {{ $tipoCalibre->nombre_comun }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @php
                                // Decodificar el dato almacenado en formato JSON
                                $selected_codigo_fabricante = isset($dataTypeContent->codigo_fabricante)
                                    ? json_decode($dataTypeContent->codigo_fabricante)
                                    : null;
                            @endphp

                            <div class="form-group">
                                <h5 for="codigo_fabricante">Tipo de Fabricante</h5>
                                <select class="form-control select2" id="codigo_fabricante" name="codigo_fabricante">
                                    <option value="" disabled selected>Seleccione un Tipo de Fabricante</option>
                                    @foreach (Voyager::tipo_fabricante() as $tipoFabricante)
                                        <option value="{{ $tipoFabricante->codigo_fabricante }}"
                                            {{ $tipoFabricante->codigo_fabricante == $selected_codigo_fabricante ? 'selected' : '' }}>
                                            {{ $tipoFabricante->fabricante }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            {{-- <div id="permisoPorteFields" style="display: none;"> --}}
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
                                    name="titular_permiso_porte" placeholder="{{ __('Titular de Permiso de Porte') }}"
                                    value="{{ old('titular_permiso_porte', $dataTypeContent->titular_permiso_porte ?? '') }}">
                            </div>

                            {{-- </div> --}}

                            @php
                                // Decodificar el dato almacenado en formato JSON
                                $selected_codigo_sistema_operativo = isset($dataTypeContent->codigo_sistema_operativo)
                                    ? json_decode($dataTypeContent->codigo_sistema_operativo)
                                    : null;
                            @endphp

                            <div class="form-group">
                                <h5 for="codigo_sistema_operativo">Tipo de Sistema de Operación</h5>
                                <select class="form-control select2" id="codigo_sistema_operativo"
                                    name="codigo_sistema_operativo">
                                    <option value="" disabled selected>Seleccione un Tipo de Sistema de Operación
                                    </option>
                                    @foreach (Voyager::tipo_sistema_operacion() as $tipoSistema)
                                        <option value="{{ $tipoSistema->codigo_sistema_operativo }}"
                                            {{ $tipoSistema->codigo_sistema_operativo == $selected_codigo_sistema_operativo ? 'selected' : '' }}>
                                            {{ $tipoSistema->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            @php
                                // Decodificar el dato almacenado en formato JSON
                                $selected_codigo_tipo_propiedad = isset($dataTypeContent->codigo_tipo_propiedad)
                                    ? json_decode($dataTypeContent->codigo_tipo_propiedad)
                                    : null;
                            @endphp

                            <div class="form-group">
                                <h5 for="codigo_tipo_propiedad">Tipo de Propiedad</h5>
                                <select class="form-control select2" id="codigo_tipo_propiedad"
                                    name="codigo_tipo_propiedad">
                                    <option value="" disabled selected>Seleccione un Tipo de Propiedad</option>
                                    @foreach (Voyager::tipo_propiedad() as $tipoPropiedad)
                                        <option value="{{ $tipoPropiedad->codigo_tipo_propiedad }}"
                                            {{ $tipoPropiedad->codigo_tipo_propiedad == $selected_codigo_tipo_propiedad ? 'selected' : '' }}>
                                            {{ $tipoPropiedad->tipo_propiedad }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div><!-- panel-body -->

                        <div class="panel-footer">
                        @section('submit-buttons')
                            <button type="submit" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Intercepta el envío del formulario
        $('.form-edit-add').on('submit', function(event) {
            // Verifica si se ha seleccionado un tipo de propulsión
            if ($('select[name="codigo_metodo_propulsion"]').val() === null) {
                // Evita el envío del formulario
                event.preventDefault();

                // Muestra SweetAlert2 para informar al usuario
                Swal.fire({
                    title: 'Debe seleccionar un tipo de propulsión',
                    text: 'Por favor, seleccione un tipo de propulsión antes de continuar.',
                    icon: 'warning',
                    confirmButtonText: 'Entendido'
                });
                return;
            }

            // Verifica si el campo de salvoconducto está visible y si se ha ingresado un número de salvoconducto
            if ($('#numero_serie').is(':visible') && $('#numero_serie').val().trim() ===
                '') {
                // Evita el envío del formulario
                event.preventDefault();

                // Muestra SweetAlert2 para informar al usuario
                Swal.fire({
                    title: 'Debe ingresar un número de serie',
                    text: 'Por favor, ingrese un número de serie antes de continuar.',
                    icon: 'warning',
                    confirmButtonText: 'Entendido'
                });
                return;
            }

            // Verifica si se ha seleccionado al menos un tipo de arma
            if ($('select[name="codigo_tipo_arma"]').val() === null) {
                // Evita el envío del formulario
                event.preventDefault();

                // Muestra SweetAlert2 para informar al usuario
                Swal.fire({
                    title: 'Debe seleccionar un tipo de arma',
                    text: 'Por favor, seleccione un tipo de arma antes de continuar.',
                    icon: 'warning',
                    confirmButtonText: 'Entendido'
                });
                return;
            }


            // Verifica si el campo de salvoconducto está visible y si se ha ingresado un número de salvoconducto
            if ($('#numero_salvoconducto').is(':visible') && $('#numero_salvoconducto').val().trim() ===
                '') {
                // Evita el envío del formulario
                event.preventDefault();

                // Muestra SweetAlert2 para informar al usuario
                Swal.fire({
                    title: 'Debe ingresar un número de salvoconducto',
                    text: 'Por favor, ingrese un número de salvoconducto antes de continuar.',
                    icon: 'warning',
                    confirmButtonText: 'Entendido'
                });
                return;
            }

            // Verifica si se ha seleccionado al menos un tipo de arma
            if ($('select[name="codigo_calibre"]').val() === null) {
                // Evita el envío del formulario
                event.preventDefault();

                // Muestra SweetAlert2 para informar al usuario
                Swal.fire({
                    title: 'Debe seleccionar un tipo de calibre',
                    text: 'Por favor, seleccione un tipo de calibre antes de continuar.',
                    icon: 'warning',
                    confirmButtonText: 'Entendido'
                });
                return;
            }


            // Verifica si se ha seleccionado al menos un tipo de arma
            if ($('select[name="codigo_fabricante"]').val() === null) {
                // Evita el envío del formulario
                event.preventDefault();

                // Muestra SweetAlert2 para informar al usuario
                Swal.fire({
                    title: 'Debe seleccionar un tipo de fabricante',
                    text: 'Por favor, seleccione un tipo de fabricante antes de continuar.',
                    icon: 'warning',
                    confirmButtonText: 'Entendido'
                });
                return;
            }
            // Verifica si el campo de fecha de permiso de porte está visible y si se ha ingresado una fecha de permiso de porte
            if ($('#fecha_permiso_porte').is(':visible') && $('#fecha_permiso_porte').val().trim() ===
                '') {
                // Evita el envío del formulario
                event.preventDefault();

                // Muestra SweetAlert2 para informar al usuario
                Swal.fire({
                    title: 'Debe ingresar una fecha de permiso de porte',
                    text: 'Por favor, ingrese una fecha de permiso de porte antes de continuar.',
                    icon: 'warning',
                    confirmButtonText: 'Entendido'
                });
                return;
            }

            // Verifica si el campo de número de permiso de porte está visible y si se ha ingresado un número de permiso de porte
            if ($('#numero_permiso_porte').is(':visible') && $('#numero_permiso_porte').val().trim() ===
                '') {
                // Evita el envío del formulario
                event.preventDefault();

                // Muestra SweetAlert2 para informar al usuario
                Swal.fire({
                    title: 'Debe ingresar un número de permiso de porte',
                    text: 'Por favor, ingrese un número de permiso de porte antes de continuar.',
                    icon: 'warning',
                    confirmButtonText: 'Entendido'
                });
                return;
            }

            // Verifica si el campo de titular de permiso de porte está visible y si se ha ingresado un titular de permiso de porte
            if ($('#titular_permiso_porte').is(':visible') && $('#titular_permiso_porte').val()
                .trim() === '') {
                // Evita el envío del formulario
                event.preventDefault();

                // Muestra SweetAlert2 para informar al usuario
                Swal.fire({
                    title: 'Debe ingresar un titular de permiso de porte',
                    text: 'Por favor, ingrese un titular de permiso de porte antes de continuar.',
                    icon: 'warning',
                    confirmButtonText: 'Entendido'
                });
                return;
            }

            // Verifica si el campo de sistema operativo está visible y si se ha seleccionado un tipo de sistema operativo
            if ($('#codigo_sistema_operativo').is(':visible') && $(
                    'select[name="codigo_sistema_operativo"]').val() === null) {
                // Evita el envío del formulario
                event.preventDefault();

                // Muestra SweetAlert2 para informar al usuario
                Swal.fire({
                    title: 'Debe seleccionar un tipo de sistema operativo',
                    text: 'Por favor, seleccione un tipo de sistema operativo antes de continuar.',
                    icon: 'warning',
                    confirmButtonText: 'Entendido'
                });
                return;
            }

            // Verifica si el campo de sistema operativo está visible y si se ha seleccionado un tipo de sistema operativo
            if ($('#codigo_tipo_propiedad').is(':visible') && $(
                    'select[name="codigo_tipo_propiedad"]').val() === null) {
                // Evita el envío del formulario
                event.preventDefault();

                // Muestra SweetAlert2 para informar al usuario
                Swal.fire({
                    title: 'Debe seleccionar un tipo de propiedad',
                    text: 'Por favor, seleccione un tipo de propiedad antes de continuar.',
                    icon: 'warning',
                    confirmButtonText: 'Entendido'
                });
                return;
            }

        });
    });
</script>

<script>
    $(document).ready(function() {
        // Función para comprobar la selección y mostrar/ocultar campos
        function checkPropulsionSelection() {
            var selectedPropulsion = $('#codigo_metodo_propulsion').val();
            var hideFields = false;

            // Obtener los métodos de propulsión y verificar si es 'Aire' (case insensitive)
            @foreach (Voyager::propulsion() as $propulsion)
                if (selectedPropulsion == '{{ $propulsion->codigo_metodo_propulsion }}' &&
                    '{{ strtolower($propulsion->metodo_propulsion) }}'.toLowerCase() === 'aire') {
                    hideFields = true;
                }
            @endforeach

            // Mostrar u ocultar los campos de salvoconducto y sistema operativo
            if (hideFields) {
                $('#numero_salvoconducto').parent().hide();
                $('#numero_salvoconducto').removeAttr('required').val('');

                $('#codigo_sistema_operativo').parent().hide();
                $('#codigo_sistema_operativo').removeAttr('required').val('');
            } else {
                $('#numero_salvoconducto').parent().show();
                // $('#numero_salvoconducto').attr('required', true);

                $('#codigo_sistema_operativo').parent().show();
                // $('#codigo_sistema_operativo').attr('required', true);
            }
        }

        // Ejecutar la función al cargar la página y al cambiar la selección
        checkPropulsionSelection();
        $('#codigo_metodo_propulsion').change(checkPropulsionSelection);
    });
</script>

@stop
