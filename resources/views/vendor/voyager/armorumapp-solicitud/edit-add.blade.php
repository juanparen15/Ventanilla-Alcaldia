@extends('voyager::master')

@section('page_title', __('voyager::generic.' . (isset($dataTypeContent->id) ? 'edit' : 'add')) . ' ' .
    $dataType->getTranslatedAttribute('display_name_singular'))

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager::generic.' . (isset($dataTypeContent->id) ? 'edit' : 'add')) . ' ' . $dataType->getTranslatedAttribute('display_name_singular') }}
    </h1>
@stop

@section('content')

    <div class="page-content container-fluid">
        <form class="form-edit-add" role="form"
            action="@if (!is_null($dataTypeContent->getKey())) {{ route('voyager.' . $dataType->slug . '.update', $dataTypeContent->getKey()) }}@else{{ route('voyager.' . $dataType->slug . '.store') }} @endif"
            method="POST" enctype="multipart/form-data" autocomplete="off">
            <!-- PUT Method if we are editing -->
            @if (isset($dataTypeContent->id))
                {{ method_field('PUT') }}
            @endif
            {{ csrf_field() }}

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-bordered">
                        {{-- <div class="panel"> --}}
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="panel-body">
                            <div class="form-group">

                                <a target="blank" type="button" class="btn btn-primary"
                                    href="https://checkout.wompi.co/l/0vsdUZ"><i class="voyager-paypal"></i> PAGOS EN
                                    LINEA</a>
                            </div>
                            @php
                                if (isset($dataTypeContent->tipo_peticion)) {
                                    $selected_tipo_peticion = $dataTypeContent->tipo_peticion;
                                } else {
                                    $selected_tipo_peticion = null; // Cambia '' por null
                                }
                            @endphp
                            <div class="form-group">
                                <h5 for="tipo_peticion">{{ __('Tipo de Petición') }}</h5>
                                <select class="form-control select2" id="tipo_peticion" name="tipo_peticion">
                                    {{-- <option value="" disabled selected>Seleccione un Tipo de Petición</option> --}}
                                    @foreach (Voyager::tipo_peticion() as $tipo_peticion)
                                        <option value="{{ $tipo_peticion->tipo_peticion }}"
                                            {{ $tipo_peticion->tipo_peticion == $selected_tipo_peticion ? 'selected' : '' }}>
                                            {{ $tipo_peticion->tipo_peticion }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Cargar Una Sola Imagen
                            <div class="form-group" id="imagen_option">
                                <h5 for="imagen">{{ __('Imagen') }}</h5>
                                @if (isset($dataTypeContent->imagen))
                                    <img src="{{ filter_var($dataTypeContent->imagen, FILTER_VALIDATE_URL) ? $dataTypeContent->imagen : Voyager::image($dataTypeContent->imagen) }}"
                                        style="width:200px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;" />
                                @endif
                                <input type="file" data-name="imagen" accept="image/*" name="imagen">
                            </div> --}}

                            {{-- Cargar Multiples Imagenes  --}}
                            <div class="form-group" id="imagen_option">
                                <h5 for="imagen">{{ __('Imágenes') }}</h5>
                                @if (isset($dataTypeContent->imagen))
                                    @foreach (json_decode($dataTypeContent->imagen) as $imagen)
                                        <img src="{{ filter_var($imagen, FILTER_VALIDATE_URL) ? $imagen : Voyager::image($imagen) }}"
                                            style="width:200px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;" />
                                    @endforeach
                                @endif
                                <div class="custom-file">
                                    <!-- Botón personalizado -->
                                    <label class="btn btn-primary" for="fileInput"><i class="voyager-images"></i>
                                        Seleccionar imágenes</label>
                                    <!-- Input de archivo oculto -->
                                    <input type="file" class="custom-file-input" id="fileInput" data-name="imagen[]"
                                        accept="image/*" name="imagen[]" multiple style="display: none;">
                                    <label class="invalid-feedback" style="display: none;">Por favor, seleccione una
                                        imagen.</label>
                                    {{-- <span id="fileLabel"></span> --}}

                                </div>
                            </div>


                            <div class="form-group">
                                <h5 for="asunto">{{ __('Asunto') }}</h5>
                                <input required="true" type="text" class="form-control" id="asunto" name="asunto"
                                    placeholder="{{ __('Asunto') }}"
                                    value="{{ old('asunto', $dataTypeContent->asunto ?? '') }}">
                            </div>

                            <div class="form-group">
                                <h5 for="mensaje">{{ __('Mensaje') }}</h5>
                                {{-- <textarea required="true" class="form-control" id="mensaje" name="mensaje"></textarea> --}}
                                <textarea class="form-control richTextBox" id="richtext mensaje" name="mensaje"></textarea>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- <div class="col-md-4">
                    <div class="panel panel panel-bordered panel-warning">
                        <div class="panel-body">
                            <div class="form-group">
                                @if (isset($dataTypeContent->avatar))
                                    <img src="{{ filter_var($dataTypeContent->avatar, FILTER_VALIDATE_URL) ? $dataTypeContent->avatar : Voyager::image($dataTypeContent->avatar) }}"
                                        style="width:200px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;" />
                                @endif
                                <input type="file" data-name="avatar" accept="image/*" name="avatar">
                            </div>
                            <div class="form-group">
                                <h5 for="username">{{ __('Número de Documento') }}</h5>
                            </div>
                            <label for="username">{{ old('username', $dataTypeContent->username ?? '') }}</label>
                            <br></br>
                            <div class="form-group">
                                <h5 for="primer_nombre">{{ __('Nombre Completo') }}</h5>
                            </div>
                            <label for="primer_nombre">{{ old('primer_nombre', $dataTypeContent->primer_nombre ?? '') }}
                                {{ old('segundo_nombre', $dataTypeContent->segundo_nombre ?? '') }}
                                {{ old('primer_apellido', $dataTypeContent->primer_apellido ?? '') }}
                                {{ old('segundo_apellido', $dataTypeContent->segundo_apellido ?? '') }}</label>
                            <br></br>
                            <div class="form-group">
                                <h5 for="direccion">{{ __('Dirección') }}</h5>
                            </div>
                            <label for="direccion">{{ old('direccion', $dataTypeContent->direccion ?? '') }}</label>
                            <br></br>
                            <div class="form-group">
                                <h5 for="movil">{{ __('Móvil') }}</h5>
                            </div>
                            <label for="movil">{{ old('movil', $dataTypeContent->movil ?? '') }}</label>
                            <br></br>
                            <div class="form-group">
                                <h5 for="">{{ __('Porcentaje de Descuento') }}</h5>
                            </div>
                            <label>{{ Voyager::setting('admin.descuento', '0%') }}</label>
                            <br></br>
                            <div class="form-group">
                                <h5 for="">{{ __('Valor Credencial') }}</h5>
                            </div>
                            <label>{{ Voyager::setting('admin.valor_credencial', '$') }}</label>
                        </div>
                    </div>

                </div> --}}
            </div>
    </div>

    <button type="submit" class="btn btn-primary pull-right save">
        {{-- {{ __('voyager::generic.save') }} --}}
        Enviar
    </button>
    </form>
    <div style="display:none">
        <input type="hidden" id="upload_url" value="{{ route('voyager.upload') }}">
        <input type="hidden" id="upload_type_slug" value="{{ $dataType->slug }}">
    </div>
    </div>
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

        $('document').ready(function() {
            $('.toggleswitch').bootstrapToggle();

            //Init datepicker for date fields if data-datepicker attribute defined
            //or if browser does not handle date inputs
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
                    if (response &&
                        response.data &&
                        response.data.status &&
                        response.data.status == 200) {

                        toastr.success(response.data.message);
                        $file.parent().fadeOut(300, function() {
                            $(this).remove();
                        })
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
            // Función para mostrar u ocultar el mensaje de validación cuando se cambia el campo de imagen
            $('#fileInput').change(function() {
                // Verificar si hay algún archivo seleccionado
                if ($(this).get(0).files.length === 0) {
                    // Si no hay archivos seleccionados, mostrar el mensaje de validación
                    $(this).next('.invalid-feedback').show();
                } else {
                    // Si hay archivos seleccionados, ocultar el mensaje de validación
                    $(this).next('.invalid-feedback').hide();
                }
            });

            // Función para mostrar u ocultar la opción de imagen según el tipo de petición seleccionado
            function toggleImagenOption() {
                var tipoPeticion = $('#tipo_peticion').val();

                // Si el tipo de petición seleccionado es igual a 'solicitud credencial FEDETIRO', mostrar la opción de imagen y hacerla requerida
                if (tipoPeticion == 'solicitud credencial FEDETIRO') {
                    $('#imagen_option').show();
                    $('#fileInput').attr('required', 'required');
                } else {
                    // De lo contrario, ocultar la opción de imagen, quitar el atributo required y ocultar el mensaje de validación
                    $('#imagen_option').hide();
                    $('#fileInput').removeAttr('required');
                    $('#fileInput').next('.invalid-feedback').hide();
                }
            }

            // Ejecutar la función toggleImagenOption() cuando el valor del campo tipo_peticion cambie
            $('#tipo_peticion').change(function() {
                toggleImagenOption();
            });

            // Ejecutar la función toggleImagenOption() al cargar la página para inicializar la visibilidad de la opción de imagen
            toggleImagenOption();
        });
    </script>



    <script>
        $(document).ready(function() {
            var additionalConfig = {
                selector: 'textarea.richTextBox[name="mensaje"]',
            }

            $.extend(additionalConfig, {!! json_encode($options->tinymceOptions ?? (object) []) !!})

            tinymce.init(window.voyagerTinyMCE.getConfig(additionalConfig));
        });
    </script>
@stop
