<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Correo Electrónico - VENTANILLA</title>
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
                <h2>Verificación de Correo Electrónico</h2>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <x-guest-layout>
                    <x-authentication-card>
                        <div class="mb-4 text-sm text-gray-600">
                            {{ __('Antes de continuar, ¿Podría verificar su dirección de correo electrónico ingresando el Código de Verificación que le acabamos de enviar por correo electrónico?') }}
                        </div>

                        <form action="{{ route('verification.verify') }}" method="POST">
                            @csrf
                            <div>
                                <x-label for="verification_pin">Código de Verificación</x-label>
                                <x-input type="text" class="block mt-1 w-full" name="verification_pin"
                                    id="verification_pin" required />
                            </div>
                            <div class="mt-4">
                                <x-button>Verificar</x-button>
                            </div>
                        </form>
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf

                            <div m>
                                <x-button type="submit">
                                    {{ __('Reenviar Correo Electrónico') }}
                                </x-button>
                            </div>
                        </form>

                        @if (session('status') == 'verification-link-sent')
                            <div class="mb-4 font-medium text-sm text-green-600">
                                {{ __('Se envió un nuevo Código de Verificación a la dirección de correo electrónico') }}
                            </div>
                        @endif

                        {{-- <div class="mt-4 flex items-center justify-between"> --}}
                        <div class="flex items-center justify-end mt-4">
                            {{-- <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                href="{{ route('profile.show') }}">
                                {{ __('Editar perfil') }}</a> --}}

                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf

                                <button type="submit"
                                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ml-2">
                                    {{ __('Cerrar sesión') }}
                                </button>
                            </form>
                        </div>
                        {{-- </div> --}}
                    </x-authentication-card>
                </x-guest-layout>
            </div> <!-- .login-container -->
        </div>
    </div>
</body>

</html>
