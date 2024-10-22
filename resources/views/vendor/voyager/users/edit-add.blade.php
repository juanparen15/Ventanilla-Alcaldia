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
                <div class="col-md-8">
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
                            @php
                                if (isset($dataTypeContent->tipo_documento)) {
                                    $selected_tipo_documento = $dataTypeContent->tipo_documento;
                                } else {
                                    $selected_tipo_documento = null; // Cambia '' por null
                                }
                            @endphp
                            <div class="form-group">
                                <h5 for="tipo_documento">{{ __('Tipo Documento') }}</h5>
                                <select class="form-control select2" id="tipo_documento" name="tipo_documento">
                                    @foreach (Voyager::tipoDocumento() as $tipo_documento)
                                        <option value="{{ $tipo_documento->id }}"
                                            {{ $tipo_documento->id == $selected_tipo_documento ? 'selected' : '' }}>
                                            {{ $tipo_documento->tipo_documento }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @can('editRoles', $dataTypeContent)
                                <div class="form-group">
                                    <h5 for="documento_tercero">{{ __('Usuario') }}</h5>
                                    <input required="true" type="text" class="form-control" id="username" name="username"
                                        placeholder="{{ __('Numero de Documento') }}"
                                        value="{{ old('username', $dataTypeContent->username ?? '') }}">
                                </div>

                                <div class="form-group">
                                    <h5 for="email">{{ __('Correo') }}</h5>
                                    <input required="true" type="email" class="form-control" id="email" name="email"
                                        placeholder="{{ __('Correo') }}"
                                        value="{{ old('email', $dataTypeContent->email ?? '') }}">
                                </div>
                            @endcan


                            @if (Auth::user()->role_id == '2')
                                <div class="form-group">
                                    <h5 for="documento_tercero">{{ __('Número de Documento') }}</h5>
                                    <label
                                        for="documento_tercero">{{ old('username', $dataTypeContent->username ?? '') }}</label>
                                </div>
                            @endif
                            <div class="form-group">
                                <h5 for="primer_nombre">{{ __('Primer Nombre') }}</h5>
                                <input required="true" type="text" class="form-control" id="primer_nombre"
                                    name="primer_nombre" placeholder="{{ __('Primer Nombre') }}"
                                    value="{{ old('primer_nombre', $dataTypeContent->primer_nombre ?? '') }}">
                            </div>

                            <div class="form-group">
                                <h5 for="segundo_nombre">{{ __('Segundo Nombre') }}</h5>
                                <input type="text" class="form-control" id="segundo_nombre" name="segundo_nombre"
                                    placeholder="{{ __('Segundo Nombre') }}"
                                    value="{{ old('segundo_nombre', $dataTypeContent->segundo_nombre ?? '') }}">
                            </div>

                            <div class="form-group">
                                <h5 for="primer_apellido">{{ __('Primer Apellido') }}</h5>
                                <input required="true" type="text" class="form-control" id="primer_apellido"
                                    name="primer_apellido" placeholder="{{ __('Primer Apellido') }}"
                                    value="{{ old('primer_apellido', $dataTypeContent->primer_apellido ?? '') }}">
                            </div>

                            <div class="form-group">
                                <h5 for="segundo_apellido">{{ __('Segundo Apellido') }}</h5>
                                <input type="text" class="form-control" id="segundo_apellido" name="segundo_apellido"
                                    placeholder="{{ __('Segundo Apellido') }}"
                                    value="{{ old('segundo_apellido', $dataTypeContent->segundo_apellido ?? '') }}">
                            </div>
                            <div class="form-group">
                                <h5 for="movil">{{ __('Móvil') }}</h5>
                                <input required="true" type="number" class="form-control" id="movil" name="movil"
                                    placeholder="{{ __('Móvil') }}"
                                    value="{{ old('movil', $dataTypeContent->movil ?? '') }}">
                            </div>
                            <div class="form-group">
                                <h5 for="direccion">{{ __('Dirección') }}</h5>
                                <input required="true" type="text" class="form-control" id="direccion" name="direccion"
                                    placeholder="{{ __('Dirección') }}"
                                    value="{{ old('direccion', $dataTypeContent->direccion ?? '') }}">
                            </div>
                            <div class="form-group">
                                <h5 for="fecha_nacimiento">{{ __('Fecha de Nacimiento') }}</h5>
                                <input required="true" type="date" class="form-control" id="fecha_nacimiento"
                                    name="fecha_nacimiento" placeholder="{{ __('Fecha de Nacimiento') }}"
                                    value="{{ old('fecha_nacimiento', $dataTypeContent->fecha_nacimiento ?? '') }}">
                            </div>

                            @php
                                if (isset($dataTypeContent->departamentos)) {
                                    $selected_departamentos = $dataTypeContent->departamentos;
                                } else {
                                    $selected_departamentos = null; // Cambia '' por null
                                }
                            @endphp
                            <div class="form-group">
                                <h5 for="departamentos">{{ __('Departamento de Nacimiento') }}</h5>
                                <select class="form-control select2" id="departamentos" name="departamentos">
                                    <option value="" disabled selected>Seleccione un Departamento</option>
                                    @foreach (Voyager::departamentos() as $departamento)
                                        <option value="{{ $departamento->id }}"
                                            {{ $departamento->id == $selected_departamentos ? 'selected' : '' }}>
                                            {{ $departamento->departamento }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @php
                                if (isset($dataTypeContent->municipios)) {
                                    $selected_municipios = $dataTypeContent->municipios;
                                } else {
                                    $selected_municipios = null; // Cambia '' por null
                                }
                            @endphp
                            <div class="form-group">
                                <h5 for="municipios">{{ __('Municipio de Nacimiento') }}</h5>
                                <select class="form-control select2" id="municipios" name="municipios">
                                    <option value="" disabled selected>Seleccione un Municipio</option>
                                    @foreach (Voyager::municipios() as $municipio)
                                        <option value="{{ $municipio->id }}"
                                            {{ $municipio->id == $selected_municipios ? 'selected' : '' }}>
                                            {{ $municipio->municipio }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class="form-group">
                                <h5 for="peso">{{ __('Peso (KG)') }}</h5>
                                <input min="30" max="200" required="true" type="number"
                                    class="form-control" id="peso" name="peso"
                                    placeholder="{{ __('Peso KG') }}"
                                    value="{{ old('peso', $dataTypeContent->peso ?? '') }}">
                            </div> --}}
                            {{-- <div class="form-group">
                                <h5 for="altura">{{ __('Altura (CM)') }}</h5>
                                <input min="120" max="250" required="true" type="number"
                                    class="form-control" id="altura" name="altura"
                                    placeholder="{{ __('Altura (CM)') }}"
                                    value="{{ old('altura', $dataTypeContent->altura ?? '') }}">
                            </div> --}}
                            @php
                                if (isset($dataTypeContent->estado_civil)) {
                                    $selected_estado_civil = $dataTypeContent->estado_civil;
                                } else {
                                    $selected_estado_civil = null; // Cambia '' por null
                                }
                            @endphp
                            {{-- <div class="form-group">
                                <h5 for="estado_civil">{{ __('Estado Civil') }}</h5>
                                <select class="form-control select2" id="estado_civil" name="estado_civil">
                                    @foreach (Voyager::estadoCivil() as $estado_civil)
                                        <option value="{{ $estado_civil->id }}"
                                            {{ $estado_civil->id == $selected_estado_civil ? 'selected' : '' }}>
                                            {{ $estado_civil->estado_civil }}
                                        </option>
                                    @endforeach
                                </select>
                            </div> --}}

                            @php
                                if (isset($dataTypeContent->genero)) {
                                    $selected_genero = $dataTypeContent->genero;
                                } else {
                                    $selected_genero = null; // Cambia '' por null
                                }
                            @endphp
                            {{-- <div class="form-group">
                                <h5 for="genero">{{ __('Genero') }}</h5>
                                <select class="form-control select2" id="genero" name="genero">
                                    @foreach (Voyager::genero() as $genero)
                                        <option value="{{ $genero->id }}"
                                            {{ $genero->id == $selected_genero ? 'selected' : '' }}>
                                            {{ $genero->genero }}
                                        </option>
                                    @endforeach
                                </select>
                            </div> --}}

                            @php
                                if (isset($dataTypeContent->condicion_especial)) {
                                    $selected_condicion_especial = $dataTypeContent->condicion_especial;
                                } else {
                                    $selected_condicion_especial = null; // Cambia '' por null
                                }
                            @endphp
                            <div class="form-group">
                                <h5 for="condicion_especial">{{ __('Condición Especial') }}</h5>
                                <select class="form-control select2" id="condicion_especial" name="condicion_especial">
                                    <option value="" disabled selected>Seleccione una Condición Especial</option>
                                    @foreach (Voyager::condicion_especial() as $condicion_especial)
                                        <option value="{{ $condicion_especial->id }}"
                                            {{ $condicion_especial->id == $selected_condicion_especial ? 'selected' : '' }}>
                                            {{ $condicion_especial->condicion }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            @can('editRoles', $dataTypeContent)
                                <div class="form-group">
                                    <h5 for="password">{{ __('voyager::generic.password') }}</h5>
                                    @if (isset($dataTypeContent->password))
                                        <br>
                                        <small>{{ __('voyager::profile.password_hint') }}</small>
                                    @endif
                                    <input type="password" class="form-control" id="password" name="password"
                                        value="" autocomplete="new-password">
                                </div>

                                <div class="form-group">
                                    <h5 for="default_role">{{ __('voyager::profile.role_default') }}</h5>
                                    @php
                                        $dataTypeRows =
                                            $dataType->{isset($dataTypeContent->id) ? 'editRows' : 'addRows'};

                                        $row = $dataTypeRows
                                            ->where('field', 'user_belongsto_role_relationship')
                                            ->first();
                                        $options = $row->details;
                                    @endphp
                                    @include('voyager::formfields.relationship')
                                </div>
                                <div class="form-group">
                                    <h5 for="additional_roles">{{ __('voyager::profile.roles_additional') }}</h5>
                                    @php
                                        $row = $dataTypeRows
                                            ->where('field', 'user_belongstomany_role_relationship')
                                            ->first();
                                        $options = $row->details;
                                    @endphp
                                    @include('voyager::formfields.relationship')
                                </div>
                            @endcan
                            @php
                                if (isset($dataTypeContent->locale)) {
                                    $selected_locale = $dataTypeContent->locale;
                                } else {
                                    $selected_locale = config('app.locale', 'es');
                                }
                            @endphp

                        </div>
                    </div>
                </div>

                {{-- <div class="col-md-5">
                    <div class="panel panel-bordered">
                        <div class="panel">
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
                                <h5 for="locale">{{ __('voyager::generic.locale') }}</h5>
                                <select class="form-control select2" id="locale" name="locale">
                                    @foreach (Voyager::getLocales() as $locale)
                                        <option value="{{ $locale }}"
                                            {{ $locale == $selected_locale ? 'selected' : '' }}>{{ $locale }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div> --}}

                <div class="col-md-4">
                    <div class="panel panel panel-bordered panel-warning">
                        <div class="panel-body">
                            <div class="form-group">
                                @if (isset($dataTypeContent->avatar))
                                    <img src="{{ filter_var($dataTypeContent->avatar, FILTER_VALIDATE_URL) ? $dataTypeContent->avatar : Voyager::image($dataTypeContent->avatar) }}"
                                        style="width:300px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;" />
                                @endif
                                {{-- <input type="file" data-name="avatar" accept="image/*" name="avatar"> --}}
                                <div class="custom-file">
                                    <!-- Botón personalizado -->
                                    <label class="btn btn-primary" for="fileInput">Seleccionar Foto de Perfil</label>
                                    <!-- Input de archivo oculto -->
                                    <input type="file" class="custom-file-input" id="fileInput" data-name="avatar"
                                        accept="image/*" name="avatar" multiple style="display: none;">
                                    <!-- Visualización del nombre del archivo seleccionado (opcional) -->
                                    <span id="fileLabel"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <h5 for="documento_tercero">{{ __('Número de Documento') }}</h5>
                            </div>
                            <label for="documento_tercero">{{ old('username', $dataTypeContent->username ?? '') }}</label>
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
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <button type="submit" class="btn btn-primary pull-right save">
        {{ __('voyager::generic.save') }}
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
        $('document').ready(function() {
            $('.toggleswitch').bootstrapToggle();
        });
    </script>


    <script>
        var departamentos = $('#departamentos');
        var municipios = $('#municipios');

        $(document).ready(function() {
            departamentos.change(function() {
                var departamentos = $(this).val();
                // console.log("Cambio en departamentos detectado");
                if (departamentos) {
                    $.get('/get-municipios/' + departamentos, function(data) {
                        $('#municipios').empty();


                        $('#municipios').append(
                            '<option disabled selected>Seleccione un Municipio</option>'
                        );
                        $.each(data, function(key, value) {
                            $('#municipios').append('<option value="' + value.id +
                                '" name="' + value.id + '">' + value
                                .municipio + '</option>');
                        });
                        // Selecciona automáticamente la primera opción
                        $('#municipios').val($('#municipios option:first').val());
                    });
                } else {
                    // Si no se selecciona ningun departamento, limpia la lista de municipios
                    $('#municipios').empty();
                }
            });
        });
    </script>
@stop
