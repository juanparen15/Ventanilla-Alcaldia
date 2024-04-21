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
                            @can('editRoles', $dataTypeContent)
                                <div class="form-group">
                                    <label for="username">{{ __('Usuario') }}</label>
                                    <input required="true" type="text" class="form-control" id="username" name="username"
                                        placeholder="{{ __('Usuario') }}"
                                        value="{{ old('username', $dataTypeContent->username ?? '') }}">
                                </div>

                                <div class="form-group">
                                    <label for="email">{{ __('Correo') }}</label>
                                    <input required="true" type="email" class="form-control" id="email" name="email"
                                        placeholder="{{ __('Correo') }}"
                                        value="{{ old('email', $dataTypeContent->email ?? '') }}">
                                </div>
                            @endcan

                            @php
                                if (isset($dataTypeContent->tipo_documento)) {
                                    $selected_tipo_documento = $dataTypeContent->tipo_documento;
                                } else {
                                    $selected_tipo_documento = null; // Cambia '' por null
                                }
                            @endphp
                            <div class="form-group">
                                <label for="tipo_documento">{{ __('Tipo Documento') }}</label>
                                <select class="form-control select2" id="tipo_documento" name="tipo_documento">
                                    @foreach (Voyager::tipoDocumento() as $tipo_documento)
                                        <option value="{{ $tipo_documento->id }}"
                                            {{ $tipo_documento->id == $selected_tipo_documento ? 'selected' : '' }}>
                                            {{ $tipo_documento->tipo_documento }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group">
                                <label for="primer_nombre">{{ __('Primer Nombre') }}</label>
                                <input required="true" type="text" class="form-control" id="primer_nombre"
                                    name="primer_nombre" placeholder="{{ __('Primer Nombre') }}"
                                    value="{{ old('primer_nombre', $dataTypeContent->primer_nombre ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label for="segundo_nombre">{{ __('Segundo Nombre') }}</label>
                                <input type="text" class="form-control" id="segundo_nombre" name="segundo_nombre"
                                    placeholder="{{ __('Segundo Nombre') }}"
                                    value="{{ old('segundo_nombre', $dataTypeContent->segundo_nombre ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label for="primer_apellido">{{ __('Primer Apellido') }}</label>
                                <input required="true" type="text" class="form-control" id="primer_apellido"
                                    name="primer_apellido" placeholder="{{ __('Primer Apellido') }}"
                                    value="{{ old('primer_apellido', $dataTypeContent->primer_apellido ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label for="segundo_apellido">{{ __('Segundo Apellido') }}</label>
                                <input type="text" class="form-control" id="segundo_apellido" name="segundo_apellido"
                                    placeholder="{{ __('Segundo Apellido') }}"
                                    value="{{ old('segundo_apellido', $dataTypeContent->segundo_apellido ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label for="movil">{{ __('Móvil') }}</label>
                                <input required="true" type="number" class="form-control" id="movil" name="movil"
                                    placeholder="{{ __('Móvil') }}"
                                    value="{{ old('movil', $dataTypeContent->movil ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label for="direccion">{{ __('Dirección') }}</label>
                                <input required="true" type="text" class="form-control" id="direccion" name="direccion"
                                    placeholder="{{ __('Dirección') }}"
                                    value="{{ old('direccion', $dataTypeContent->direccion ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label for="fecha_nacimiento">{{ __('Fecha de Nacimiento') }}</label>
                                <input required="true" type="date" class="form-control" id="fecha_nacimiento"
                                    name="fecha_nacimiento" placeholder="{{ __('Fecha de Nacimiento') }}"
                                    value="{{ old('fecha_nacimiento', $dataTypeContent->fecha_nacimiento ?? '') }}">
                            </div>
                            {{-- @php
                            if (isset($dataTypeContent->lugar_nacimiento)) {
                                $selected_lugar_nacimiento = $dataTypeContent->lugar_nacimiento;
                            } else {
                                $selected_lugar_nacimiento = config('app.locale', '');
                            }
                        @endphp
                            <div class="form-group">
                                <label for="lugar_nacimiento">{{ __('Lugar Nacimiento') }}</label>
                                <select class="form-control select2" id="lugar_nacimiento" name="lugar_nacimiento">
                                    @foreach (Voyager::getLocales() as $lugar_nacimiento)
                                        <option value="{{ $lugar_nacimiento }}"
                                            {{ $lugar_nacimiento == $lugar_nacimiento ? 'selected' : '' }}>{{ $lugar_nacimiento }}
                                        </option>
                                    @endforeach
                                </select>
                            </div> --}}
                            {{-- @php
                            if (isset($dataTypeContent->lugar_nacimiento)) {
                                $selected_lugar_nacimiento = $dataTypeContent->lugar_nacimiento;
                            } else {
                                $selected_lugar_nacimiento = config('app.locale', '');
                            }
                        @endphp
                            <div class="form-group">
                                <label for="lugar_nacimiento">{{ __('Lugar Nacimiento') }}</label>
                                <select class="form-control select2" id="lugar_nacimiento" name="lugar_nacimiento">
                                    @foreach (Voyager::getLocales() as $lugar_nacimiento)
                                        <option value="{{ $lugar_nacimiento }}"
                                            {{ $lugar_nacimiento == $lugar_nacimiento ? 'selected' : '' }}>{{ $lugar_nacimiento }}
                                        </option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="form-group">
                                <label for="peso">{{ __('Peso (KG)') }}</label>
                                <input min="30" max="200" required="true" type="number"
                                    class="form-control" id="peso" name="peso"
                                    placeholder="{{ __('Peso KG') }}"
                                    value="{{ old('peso', $dataTypeContent->peso ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label for="altura">{{ __('Altura (CM)') }}</label>
                                <input min="120" max="250" required="true" type="number"
                                    class="form-control" id="altura" name="altura"
                                    placeholder="{{ __('Altura (CM)') }}"
                                    value="{{ old('altura', $dataTypeContent->altura ?? '') }}">
                            </div>
                            @php
                                if (isset($dataTypeContent->estado_civil)) {
                                    $selected_estado_civil = $dataTypeContent->estado_civil;
                                } else {
                                    $selected_estado_civil = null; // Cambia '' por null
                                }
                            @endphp
                            <div class="form-group">
                                <label for="estado_civil">{{ __('Estado Civil') }}</label>
                                <select class="form-control select2" id="estado_civil" name="estado_civil">
                                    @foreach (Voyager::estadoCivil() as $estado_civil)
                                        <option value="{{ $estado_civil->id }}"
                                            {{ $estado_civil->id == $selected_estado_civil ? 'selected' : '' }}>
                                            {{ $estado_civil->estado_civil }} {{-- Ajusta esto según la estructura de tu modelo --}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- @php
                            if (isset($dataTypeContent->lugar_nacimiento)) {
                                $selected_lugar_nacimiento = $dataTypeContent->lugar_nacimiento;
                            } else {
                                $selected_lugar_nacimiento = config('app.locale', '');
                            }
                        @endphp
                            <div class="form-group">
                                <label for="lugar_nacimiento">{{ __('Género') }}</label>
                                <select class="form-control select2" id="lugar_nacimiento" name="lugar_nacimiento">
                                    @foreach (Voyager::getLocales() as $lugar_nacimiento)
                                        <option value="{{ $lugar_nacimiento }}"
                                            {{ $lugar_nacimiento == $lugar_nacimiento ? 'selected' : '' }}>{{ $lugar_nacimiento }}
                                        </option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="form-group">
                                <label for="inicio_competencia">{{ __('Inicio Competencia') }}</label>
                                <input required="true" type="date" class="form-control" id="inicio_competencia"
                                    name="inicio_competencia" placeholder="{{ __('Inicio Competencia') }}"
                                    value="{{ old('inicio_competencia', $dataTypeContent->inicio_competencia ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label for="practicando_tiro_desde">{{ __('Practica Tiro Desde') }}</label>
                                <input required="true" type="date" class="form-control" id="practicando_tiro_desde"
                                    name="practicando_tiro_desde" placeholder="{{ __('Practica Tiro Desde') }}"
                                    value="{{ old('practicando_tiro_desde', $dataTypeContent->practicando_tiro_desde ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label for="entrenador_personal">{{ __('Entrenador Personal') }}</label>
                                <input required="true" type="text" class="form-control" id="entrenador_personal"
                                    name="entrenador_personal" placeholder="{{ __('Entrenador Personal') }}"
                                    value="{{ old('entrenador_personal', $dataTypeContent->entrenador_personal ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label for="entrenador_nacional">{{ __('Entrenador Nacional') }}</label>
                                <input required="true" type="text" class="form-control" id="entrenador_nacional"
                                    name="entrenador_nacional" placeholder="{{ __('Entrenador Nacional') }}"
                                    value="{{ old('entrenador_nacional', $dataTypeContent->entrenador_nacional ?? '') }}">
                            </div>
                            {{-- @php
                            if (isset($dataTypeContent->lugar_nacimiento)) {
                                $selected_lugar_nacimiento = $dataTypeContent->lugar_nacimiento;
                            } else {
                                $selected_lugar_nacimiento = config('app.locale', '');
                            }
                        @endphp
                            <div class="form-group">
                                <label for="lugar_nacimiento">{{ __('Lateralidad') }}</label>
                                <select class="form-control select2" id="lugar_nacimiento" name="lugar_nacimiento">
                                    @foreach (Voyager::getLocales() as $lugar_nacimiento)
                                        <option value="{{ $lugar_nacimiento }}"
                                            {{ $lugar_nacimiento == $lugar_nacimiento ? 'selected' : '' }}>{{ $lugar_nacimiento }}
                                        </option>
                                    @endforeach
                                </select>
                            </div> --}}
                            {{-- @php
                            if (isset($dataTypeContent->lugar_nacimiento)) {
                                $selected_lugar_nacimiento = $dataTypeContent->lugar_nacimiento;
                            } else {
                                $selected_lugar_nacimiento = config('app.locale', '');
                            }
                        @endphp
                            <div class="form-group">
                                <label for="lugar_nacimiento">{{ __('Ojo Maestro') }}</label>
                                <select class="form-control select2" id="lugar_nacimiento" name="lugar_nacimiento">
                                    @foreach (Voyager::getLocales() as $lugar_nacimiento)
                                        <option value="{{ $lugar_nacimiento }}"
                                            {{ $lugar_nacimiento == $lugar_nacimiento ? 'selected' : '' }}>{{ $lugar_nacimiento }}
                                        </option>
                                    @endforeach
                                </select>
                            </div> --}}
                            {{-- @php
                            if (isset($dataTypeContent->lugar_nacimiento)) {
                                $selected_lugar_nacimiento = $dataTypeContent->lugar_nacimiento;
                            } else {
                                $selected_lugar_nacimiento = config('app.locale', '');
                            }
                        @endphp
                            <div class="form-group">
                                <label for="lugar_nacimiento">{{ __('Liga') }}</label>
                                <select class="form-control select2" id="lugar_nacimiento" name="lugar_nacimiento">
                                    @foreach (Voyager::getLocales() as $lugar_nacimiento)
                                        <option value="{{ $lugar_nacimiento }}"
                                            {{ $lugar_nacimiento == $lugar_nacimiento ? 'selected' : '' }}>{{ $lugar_nacimiento }}
                                        </option>
                                    @endforeach
                                </select>
                            </div> --}}
                            {{-- @php
                            if (isset($dataTypeContent->lugar_nacimiento)) {
                                $selected_lugar_nacimiento = $dataTypeContent->lugar_nacimiento;
                            } else {
                                $selected_lugar_nacimiento = config('app.locale', '');
                            }
                        @endphp
                            <div class="form-group">
                                <label for="lugar_nacimiento">{{ __('Club') }}</label>
                                <select class="form-control select2" id="lugar_nacimiento" name="lugar_nacimiento">
                                    @foreach (Voyager::getLocales() as $lugar_nacimiento)
                                        <option value="{{ $lugar_nacimiento }}"
                                            {{ $lugar_nacimiento == $lugar_nacimiento ? 'selected' : '' }}>{{ $lugar_nacimiento }}
                                        </option>
                                    @endforeach
                                </select>
                            </div> --}}

                            <div class="form-group">
                                <label for="medico_tramitante">{{ __('Medico Tratante') }}</label>
                                <input required="true" type="text" class="form-control" id="medico_tramitante"
                                    name="medico_tramitante" placeholder="{{ __('Medico Tratante') }}"
                                    value="{{ old('medico_tramitante', $dataTypeContent->medico_tramitante ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label for="lugar_entrenamiento">{{ __('Lugar de Entrenamiento') }}</label>
                                <input required="true" type="text" class="form-control" id="lugar_entrenamiento"
                                    name="lugar_entrenamiento" placeholder="{{ __('Lugar de Entrenamiento') }}"
                                    value="{{ old('lugar_entrenamiento', $dataTypeContent->lugar_entrenamiento ?? '') }}">
                            </div>

                            {{-- @php
                            if (isset($dataTypeContent->lugar_nacimiento)) {
                                $selected_lugar_nacimiento = $dataTypeContent->lugar_nacimiento;
                            } else {
                                $selected_lugar_nacimiento = config('app.locale', '');
                            }
                        @endphp
                            <div class="form-group">
                                <label for="lugar_nacimiento">{{ __('Tipos de Arma') }}</label>
                                <select class="form-control select2" id="lugar_nacimiento" name="lugar_nacimiento">
                                    @foreach (Voyager::getLocales() as $lugar_nacimiento)
                                        <option value="{{ $lugar_nacimiento }}"
                                            {{ $lugar_nacimiento == $lugar_nacimiento ? 'selected' : '' }}>{{ $lugar_nacimiento }}
                                        </option>
                                    @endforeach
                                </select>
                            </div> --}}

                            {{-- @php
                            if (isset($dataTypeContent->lugar_nacimiento)) {
                                $selected_lugar_nacimiento = $dataTypeContent->lugar_nacimiento;
                            } else {
                                $selected_lugar_nacimiento = config('app.locale', '');
                            }
                        @endphp
                            <div class="form-group">
                                <label for="lugar_nacimiento">{{ __('Modalidad de Arma') }}</label>
                                <select class="form-control select2" id="lugar_nacimiento" name="lugar_nacimiento">
                                    @foreach (Voyager::getLocales() as $lugar_nacimiento)
                                        <option value="{{ $lugar_nacimiento }}"
                                            {{ $lugar_nacimiento == $lugar_nacimiento ? 'selected' : '' }}>{{ $lugar_nacimiento }}
                                        </option>
                                    @endforeach
                                </select>
                            </div> --}}



                            {{-- <div class="form-group">
                                <label for="email">{{ __('voyager::generic.email') }}</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="{{ __('voyager::generic.email') }}"
                                    value="{{ old('email', $dataTypeContent->email ?? '') }}">
                            </div> --}}

                            <div class="form-group">
                                <label for="password">{{ __('voyager::generic.password') }}</label>
                                @if (isset($dataTypeContent->password))
                                    <br>
                                    <small>{{ __('voyager::profile.password_hint') }}</small>
                                @endif
                                <input type="password" class="form-control" id="password" name="password"
                                    value="" autocomplete="new-password">
                            </div>

                            @can('editRoles', $dataTypeContent)
                                <div class="form-group">
                                    <label for="default_role">{{ __('voyager::profile.role_default') }}</label>
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
                                    <label for="additional_roles">{{ __('voyager::profile.roles_additional') }}</label>
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
                            <div class="form-group">
                                <label for="locale">{{ __('voyager::generic.locale') }}</label>
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
                </div>

                <div class="col-md-4">
                    <div class="panel panel panel-bordered panel-warning">
                        <div class="panel-body">
                            <div class="form-group">
                                @if (isset($dataTypeContent->avatar))
                                    <img src="{{ filter_var($dataTypeContent->avatar, FILTER_VALIDATE_URL) ? $dataTypeContent->avatar : Voyager::image($dataTypeContent->avatar) }}"
                                        style="width:200px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;" />
                                @endif
                                <input type="file" data-name="avatar" name="avatar">
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
@stop
