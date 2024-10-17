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
                        {{-- Manejo de errores --}}
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
                            {{-- Cargar tipo de peticiones --}}
                            @php
                                $tipoPeticiones = Voyager::tipo_peticion();
                                $selected_tipo_peticion = $dataTypeContent->tipo_peticion ?? null;
                            @endphp

                            {{-- Campo de selección de tipo de petición --}}
                            <div class="form-group">
                                <h5 for="tipo_peticion">{{ __('Tipo de Petición') }}</h5>
                                <select class="form-control select2" id="tipo_peticion" name="tipo_peticion">
                                    @foreach ($tipoPeticiones as $tipo_peticion)
                                        <option value="{{ $tipo_peticion->tipo_peticion }}"
                                            {{ $tipo_peticion->tipo_peticion == $selected_tipo_peticion ? 'selected' : '' }}>
                                            {{ $tipo_peticion->tipo_peticion }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Opción de carga de imagen --}}
                            <div class="form-group" id="imagen_option">
                                <h5 for="foto">{{ __('Anexos (PDF)') }}</h5>
                                @if (!empty($dataTypeContent->foto))
                                    @foreach (json_decode($dataTypeContent->foto) as $pdf)
                                        <div class="file-preview">
                                            <a href="{{ filter_var($pdf->download_link ?? '', FILTER_VALIDATE_URL) ? $pdf->download_link : Voyager::image($pdf->download_link) }}"
                                                target="_blank">
                                                {{ $pdf->original_name ?? basename($pdf->download_link) }}
                                            </a>
                                        </div>
                                    @endforeach
                                @endif

                                <div class="custom-file">
                                    <label class="btn btn-primary" for="fileInput"><i class="voyager-images"></i>
                                        Seleccionar Archivo</label>
                                    <input type="file" class="custom-file-input" id="fileInput" data-name="foto"
                                        accept=".pdf" name="foto" style="display: none;">
                                    <span id="fileLabel"></span>
                                </div>
                            </div>

                            {{-- Opción de carga de cédula --}}
                            <div class="form-group" id="cedula_option">
                                <h5 for="cedula">{{ __('Anexos (JPG, PNG)') }}</h5>
                                @if (!empty($dataTypeContent->cedula))
                                    @foreach (json_decode($dataTypeContent->cedula) as $pdf)
                                        <div class="file-preview">
                                            <a href="{{ filter_var($pdf->download_link ?? '', FILTER_VALIDATE_URL) ? $pdf->download_link : Voyager::image($pdf->download_link) }}"
                                                target="_blank">
                                                {{ $pdf->original_name ?? basename($pdf->download_link) }}
                                            </a>
                                        </div>
                                    @endforeach
                                @endif

                                <div class="custom-file">
                                    <label class="btn btn-primary" for="fileInputCedula"><i class="voyager-credit-card"></i>
                                        Seleccionar Archivo</label>
                                    <input type="file" class="custom-file-input" id="fileInputCedula" data-name="cedula"
                                        accept="image/*" name="cedula" style="display: none;">
                                    <span id="fileLabelCedula"></span>
                                </div>
                            </div>

                            {{-- Opción de carga de pago --}}
                            <div class="form-group" id="pago_option">
                                <h5 for="pago">{{ __('Anexos (MP3, MP4)') }}</h5>
                                @if (!empty($dataTypeContent->pago))
                                    @foreach (json_decode($dataTypeContent->pago) as $pdf)
                                        <div class="file-preview">
                                            <a href="{{ filter_var($pdf->download_link ?? '', FILTER_VALIDATE_URL) ? $pdf->download_link : Voyager::image($pdf->download_link) }}"
                                                target="_blank">
                                                {{ $pdf->original_name ?? basename($pdf->download_link) }}
                                            </a>
                                        </div>
                                    @endforeach
                                @endif

                                <div class="custom-file">
                                    <label class="btn btn-primary" for="fileInputPago"><i class="voyager-images"></i>
                                        Seleccionar Archivo</label>
                                    <input type="file" class="custom-file-input" id="fileInputPago" data-name="pago"
                                        accept="audio/*, video/*" name="pago" style="display: none;">
                                    <span id="fileLabelPago"></span>
                                </div>
                            </div>

                            {{-- Opción de carga de archivo opcional --}}
                            <div class="form-group" id="otro_archivo_option">
                                <h5 for="otro_archivo">{{ __('Subir otro archivo (opcional)') }}</h5>
                                @if (!empty($dataTypeContent->otro_archivo))
                                    @foreach (json_decode($dataTypeContent->otro_archivo) as $pdf)
                                        <div class="file-preview">
                                            <a href="{{ filter_var($pdf->download_link ?? '', FILTER_VALIDATE_URL) ? $pdf->download_link : Voyager::image($pdf->download_link) }}"
                                                target="_blank">
                                                {{ $pdf->original_name ?? basename($pdf->download_link) }}
                                            </a>
                                        </div>
                                    @endforeach
                                @endif

                                <div class="custom-file">
                                    <label class="btn btn-primary" for="fileInputOtroArchivo"><i class="voyager-upload"></i>
                                        Seleccionar Archivo</label>
                                    <input type="file" class="custom-file-input" id="fileInputOtroArchivo"
                                        data-name="otro_archivo" accept="application/pdf" name="otro_archivo"
                                        style="display: none;">
                                    <span id="fileLabelOtroArchivo"></span>
                                </div>
                            </div>

                            {{-- Campo de asunto --}}
                            <div class="form-group">
                                <h5 for="asunto">{{ __('Asunto') }}</h5>
                                <input required="true" type="text" class="form-control" id="asunto" name="asunto"
                                    placeholder="{{ __('Asunto') }}"
                                    value="{{ old('asunto', $dataTypeContent->asunto ?? '') }}">
                            </div>

                            {{-- Campo de mensaje --}}
                            <div class="form-group">
                                <h5 for="mensaje">{{ __('Mensaje') }}</h5>
                                <textarea class="form-control" id="richtext mensaje" name="mensaje"></textarea>
                            </div>

                            {{-- Botón de pago en línea --}}
                            <!-- <div class="form-group">
                                                                    <a target="blank" type="button" class="btn btn-primary float-right" href="https://checkout.wompi.co/l/0vsdUZ"><i class="voyager-paypal"></i> PAGOS EN LÍNEA</a>
                                                                </div> -->
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary pull-right save">Enviar</button>
        </form>

        <div style="display:none">
            <input type="hidden" id="upload_url" value="{{ route('voyager.upload') }}">
            <input type="hidden" id="upload_type_slug" value="{{ $dataType->slug }}">
        </div>
    @stop

    @section('javascript')
        <script>
            $(document).ready(function() {
                $('form').submit(function(event) {
                    // Validaciones de campos de archivo
                    if ($('#imagen_option').is(':visible') && $('#fileInput').get(0).files.length === 0) {
                        $('#fileInput').siblings('.invalid-feedback').show();
                        event.preventDefault();
                    } else {
                        $('#fileInput').siblings('.invalid-feedback').hide();
                    }

                    if ($('#cedula_option').is(':visible') && $('#fileInputCedula').get(0).files.length === 0) {
                        $('#fileInputCedula').siblings('.invalid-feedback').show();
                        event.preventDefault();
                    } else {
                        $('#fileInputCedula').siblings('.invalid-feedback').hide();
                    }

                    if ($('#pago_option').is(':visible') && $('#fileInputPago').get(0).files.length === 0) {
                        $('#fileInputPago').siblings('.invalid-feedback').show();
                        event.preventDefault();
                    } else {
                        $('#fileInputPago').siblings('.invalid-feedback').hide();
                    }
                });
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function() {

                // Validación de tamaño del archivo
                function validateFileSize(input, maxSizeMB) {
                    var file = input.files[0];
                    var fileSizeMB = file.size / (1024 * 1024); // Convierte bytes a MB
                    if (fileSizeMB > maxSizeMB) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Archivo demasiado grande',
                            text: 'El archivo no debe superar los ' + maxSizeMB + ' MB.',
                        });
                        input.value = ''; // Limpia el campo de archivo
                        return false;
                    }
                    return true;
                }

                // Validación para cada input de archivo
                $('#fileInput').on('change', function() {
                    validateFileSize(this, 5); // 5 MB límite
                });

                $('#fileInputCedula').on('change', function() {
                    validateFileSize(this, 5);
                });

                $('#fileInputPago').on('change', function() {
                    validateFileSize(this, 5);
                });

                $('#fileInputOtroArchivo').on('change', function() {
                    validateFileSize(this, 5);
                });

                var tipoPeticiones = @json($tipoPeticiones);
                var tipoPeticionSelect = $('#tipo_peticion');
                var imagenOption = $('#imagen_option');
                var cedulaOption = $('#cedula_option');
                var pagoOption = $('#pago_option');

                tipoPeticionSelect.change(function() {
                    var selectedTipoPeticion = $(this).val();
                    var selectedPeticion = tipoPeticiones.find(function(peticion) {
                        return peticion.tipo_peticion === selectedTipoPeticion;
                    });

                    if (selectedPeticion) {
                        imagenOption.toggle(selectedPeticion.foto === 1);
                        cedulaOption.toggle(selectedPeticion.cedula === 1);
                        pagoOption.toggle(selectedPeticion.pago === 1);
                    } else {
                        imagenOption.hide();
                        cedulaOption.hide();
                        pagoOption.hide();
                    }
                });

                tipoPeticionSelect.trigger('change');
            });
        </script>

        <script>
            $(document).ready(function() {
                var additionalConfig = {
                    selector: 'textarea.richTextBox[name="mensaje"]',
                }

                $.extend(additionalConfig, {!! json_encode($options->tinymceOptions ?? (object) []) !!});

                tinymce.init(window.voyagerTinyMCE.getConfig(additionalConfig));
            });
        </script>

        <script>
            $(document).ready(function() {
                function getFileExtension(mimeType) {
                    switch (mimeType) {
                        case 'image/png':
                            return 'png';
                        case 'image/jpeg':
                            return 'jpg';
                        case 'application/pdf':
                            return 'pdf';
                        case 'audio/mpeg':
                            return 'mp3';
                        case 'audio/wav':
                            return 'wav';
                        case 'video/mp4':
                            return 'mp4';
                        case 'video/webm':
                            return 'webm';
                            // Agrega más casos según sea necesario
                        default:
                            return 'bin'; // Extensión por defecto si no se encuentra
                    }
                }


                function updateFileLabel(inputId, labelId, baseFileName) {
                    $('#' + inputId).on('change', function() {
                        var files = $(this)[0].files;
                        if (files.length > 0) {
                            var file = files[0];
                            var fileExtension = getFileExtension(file.type);
                            var newFileName = baseFileName + '.' + fileExtension;

                            var renamedFile = new File([file], newFileName, {
                                type: file.type
                            });

                            var dataTransfer = new DataTransfer();
                            dataTransfer.items.add(renamedFile);

                            $('#' + inputId)[0].files = dataTransfer.files;
                            $('#' + labelId).text(newFileName);
                        }
                    });
                }

                updateFileLabel('fileInput', 'fileLabel', '{{ time() }}-imagen');
                updateFileLabel('fileInputCedula', 'fileLabelCedula', '{{ time() }}-cedula');
                updateFileLabel('fileInputPago', 'fileLabelPago', '{{ time() }}-pago');
                updateFileLabel('fileInputOtroArchivo', 'fileLabelOtroArchivo',
                    '{{ time() }}-otro-archivo');
            });
        </script>

        <script>
            function validateFileSize(input, maxSizeMB) {
                var file = input.files[0];
                var fileSizeMB = file.size / (1024 * 1024); // Convierte bytes a MB
                if (fileSizeMB > maxSizeMB) {
                    alert('El archivo no debe superar los ' + maxSizeMB + ' MB.');
                    input.value = ''; // Limpia el campo de archivo
                    return false;
                }
                return true;
            }
        </script>
    @stop
