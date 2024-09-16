<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autenticación de Dos Factores - VENTANILLA</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            margin: 0;
            background-color: #f4f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container-fluid {
            height: 100%;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
        }

        .image-section {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100%;
            flex: 1;
            min-height: 300px;
            position: relative;
            box-shadow: 10px 0 20px rgba(0, 0, 0, 0.5);
            /* Sombra a la derecha */
            transition: filter 1s ease;
            z-index: 1;
            /* Asegura que esté por debajo del contenedor de login */
        }

        .image-section:hover {
            filter: grayscale(100%);
        }

        .login-section {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #ffffff;
            flex: 1;
            min-height: 300px;
            position: relative;
            z-index: 2;
            /* Asegura que esté por encima del contenedor de imagen */
            padding-left: 15px;
            /* Espacio para la sombra */
        }

        .login-container {
            max-width: 400px;
            width: 100%;
            padding: 30px;
            background: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .login-container img {
            display: block;
            margin: 0 auto 20px;
            max-width: 150px;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            border-radius: 5px;
            box-shadow: none;
            border-color: #ddd;
        }

        .btn-primary {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            background-color: #007bff;
            border-color: #007bff;
            box-shadow: none;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .text-sm {
            font-size: 0.875rem;
            color: #666;
        }

        .underline {
            text-decoration: underline;
        }

        .text-center {
            text-align: center;
        }

        @media (max-width: 768px) {
            .image-section {
                display: none;
                /* Oculta la imagen en dispositivos móviles */
            }

            .login-section {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }
    </style>
</head>

<body>
    <?php $admin_logo_img = Voyager::setting('admin.icon_image', ''); ?>
    <?php $admin_bg_image = Voyager::setting('admin.bg_image', ''); ?>
    <div class="container-fluid">
        <div class="col-lg-6 col-md-6 image-section"
            style="background-image: url('{{ $admin_bg_image ? Voyager::image($admin_bg_image) : voyager_asset('images/fedetiro.png') }}');">
        </div>
        <div class="col-lg-6 col-md-6 login-section">
            <div class="login-container">
                <div class="logo-icon-container">
                    <?php $admin_logo_img = Voyager::setting('admin.icon_image', ''); ?>
                    @if ($admin_logo_img == '')
                        <a href="{{ url('/') }}">
                            <img src="{{ $admin_logo_img ? Voyager::image($admin_logo_img) : voyager_asset('images/fedetiro.png') }}"
                                alt="VENTANILLA Logo">
                        </a>
                    @else
                        <a href="{{ url('/') }}">
                            <img src="{{ Voyager::image($admin_logo_img) }}" alt="Logo Icon">
                        </a>
                    @endif
                </div>
                </a>
                <h2>Autenticación de Dos Factores</h2>
                <x-guest-layout>
                    <x-authentication-card>
                        <div x-data="{ recovery: false }">
                            <div class="mb-4 text-sm text-gray-600" x-show="!recovery">
                                {{ __('Confirme el acceso a su cuenta ingresando el código de autenticación proporcionado por su aplicación de autenticación.') }}
                            </div>

                            <div class="mb-4 text-sm text-gray-600" x-cloak x-show="recovery">
                                {{ __('Confirme el acceso a su cuenta ingresando uno de sus códigos de recuperación de emergencia.') }}
                            </div>

                            <x-validation-errors class="mb-4" />

                            <form method="POST" action="{{ route('two-factor.login') }}">
                                @csrf

                                <div class="mt-4" x-show="!recovery">
                                    <x-label for="code" value="{{ __('Código') }}" />
                                    <x-input id="code" class="block mt-1 w-full" type="text" inputmode="numeric"
                                        name="code" autofocus x-ref="code" autocomplete="one-time-code" />
                                </div>

                                <div class="mt-4" x-cloak x-show="recovery">
                                    <x-label for="recovery_code" value="{{ __('Código de recuperación') }}" />
                                    <x-input id="recovery_code" class="block mt-1 w-full" type="text"
                                        name="recovery_code" x-ref="recovery_code" autocomplete="one-time-code" />
                                </div>

                                <div class="flex items-center justify-end mt-4">
                                    <button type="button"
                                        class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer"
                                        x-show="!recovery"
                                        x-on:click="
                                                recovery = true;
                                                $nextTick(() => { $refs.recovery_code.focus() })
                                            ">
                                        {{ __('Utilice un código de recuperación') }}
                                    </button>

                                    <button type="button"
                                        class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer"
                                        x-cloak x-show="recovery"
                                        x-on:click="
                                                recovery = false;
                                                $nextTick(() => { $refs.code.focus() })
                                            ">
                                        {{ __('Utilice un código de autenticación') }}
                                    </button>

                                    <x-button class="ml-4">
                                        {{ __('Iniciar Sesión') }}
                                    </x-button>
                                </div>
                            </form>
                        </div>
                    </x-authentication-card>
                </x-guest-layout>
            </div> <!-- .login-container -->
        </div>
    </div>
</body>

</html>
