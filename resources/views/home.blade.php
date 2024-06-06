<!DOCTYPE html>
<html lang="en" class="light scroll-smooth" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title class="title">{{ Voyager::setting('site.title', 'FEDETIRO') }},
        {{ Voyager::setting('site.description', 'Bienvenido a Fedetiro') }} </title>
    <meta name="description" content="Responsive Tailwind CSS Template">
    <meta name="version" content="1.0.0">
    <!-- favicon -->
    <?php $admin_logo_img = Voyager::setting('admin.icon_image', ''); ?>
    <link href="{{ Voyager::image($admin_logo_img) }}" rel="shortcut icon">
    <!-- Css -->
    <link href="assets/libs/swiper/css/swiper.min.css" rel="stylesheet">
    <!-- Main Css -->
    <link href="assets/libs/tobii/css/tobii.min.css" rel="stylesheet">
    <link href="assets/libs/tiny-slider/tiny-slider.css" rel="stylesheet">
    <link href="assets/libs/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="assets/css/tailwind.css">

</head>

<body class="font-libre_franklin text-base text-black dark:text-white bg-white dark:bg-slate-900">
    <!-- Loader Start -->
    {{-- <div id="preloader">
        <div id="status">
            <div class="logo">
                <?php $admin_loader = Voyager::setting('admin.loader', ''); ?>
                <img src="{{ Voyager::image($admin_loader) }}"
                    class="d-block mx-auto animate-[spin_10s_linear_infinite]" style="height:100px!important;"
                    alt="Logo Icon">
            </div>
            <div class="justify-content-center">
                <div class="text-center">
                    <h4 class="mb-0 mt-2 text-lg font-semibold">{{ Voyager::setting('site.title', 'FEDETIRO') }}</h4>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Loader End -->


    <!-- Navbar Start -->
    <nav class="navbar" id="navbar">
        <div class="container relative flex flex-wrap items-center justify-between">
            <a class="navbar-brand md:me-8" href="">
                <span class="inline-block dark:hidden">
                    <?php $admin_logo_img = Voyager::setting('admin.icon_image', ''); ?>
                    <img src="{{ Voyager::image($admin_logo_img) }}" style="height:50px!important;" class="l-dark"
                        alt="Logo Icon">
                    <img src="{{ Voyager::image($admin_logo_img) }}" style="height:50px!important;" class="l-light"
                        alt="Logo Icon">
                </span>
                <img src="{{ Voyager::image($admin_logo_img) }}" style="height:50px!important;"
                    class="hidden dark:inline-block" alt="Logo Icon">
            </a>

            <div class="nav-icons flex items-center lg_992:order-2 ms-auto md:ms-8">
                <!-- Navbar Button -->
                <ul class="list-none menu-social mb-0">
                    @if (Route::has('login'))
                        {{-- <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right"> --}}
                        <li class="inline">
                            @auth
                                <a href="{{ url('/admin') }}"
                                    class="h-8 px-4 text-[12px] tracking-wider inline-flex items-center justify-center font-medium rounded-md bg-teal-500 text-white uppercase">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="h-8 px-4 text-[12px] tracking-wider inline-flex items-center justify-center font-medium rounded-md bg-teal-500 text-white uppercase">Iniciar
                                    Sesión</a>
                            </li>
                            <li class="inline">
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="h-8 px-4 text-[12px] tracking-wider inline-flex items-center justify-center font-medium rounded-md bg-teal-500 text-white uppercase">Registro</a>
                                @endif
                            </li>
                        @endauth
                        {{-- </div> --}}
                    @endif

                    {{-- <li class="inline">
                        <a href=""
                            class="h-8 px-4 text-[12px] tracking-wider inline-flex items-center justify-center font-medium rounded-md bg-teal-500 text-white uppercase">Login</a>
                    </li> --}}
                </ul>
                <!-- Navbar Collapse Manu Button -->
                <button data-collapse="menu-collapse" type="button"
                    class="collapse-btn inline-flex items-center ms-2 text-dark dark:text-white lg_992:hidden"
                    aria-controls="menu-collapse" aria-expanded="false">
                    <span class="sr-only">Menu</span>
                    <i class="mdi mdi-menu text-[24px]"></i>
                </button>
            </div>

            <!-- Navbar Manu -->
            <div class="navigation lg_992:order-1 lg_992:flex hidden ms-auto" id="menu-collapse">
                <ul class="navbar-nav nav-light sidebar-nav" id="navbar-navlist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#home">Inicio</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="#services">Servicios</a>
                    </li> --}}
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="#review">Testimonios</a>
                    </li> --}}
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="#pricing">Pricing</a>
                    </li> --}}
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="#blog">Blogs</a>
                    </li> --}}
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="#contact">Contactanos</a>
                    </li> --}}
                </ul>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Start Hero -->
    <section class="swiper-slider-hero relative block h-screen" id="home">
        <div class="swiper-container absolute end-0 top-0 w-full h-full">
            <div class="swiper-wrapper">
                <div class="swiper-slide flex items-center overflow-hidden">
                    <?php $slider1 = Voyager::setting('home.slider1'); ?>
                    <div class="slide-inner absolute end-0 top-0 w-full h-full slide-bg-image flex items-center bg-center bg-opacity-0;"
                        data-background="{{ Voyager::image($slider1) }}">
                        <div class="absolute inset-0 bg-black/70"></div>
                        <div class="container relative">
                            <div class="grid grid-cols-1">
                                <div class="">
                                    <h1
                                        class="font-bold lg:leading-normal leading-normal tracking-wide text-4xl lg:text-5xl capitalize text-white mb-5">
                                        {{ Voyager::setting('home.titulo1') }}</h1>
                                    <p class="text-white/70 text-lg max-w-xl">
                                        {{ Voyager::setting('home.subtitulo1') }}</p>
                                    <div class="mt-6">
                                        <a href=""
                                            class="h-10 px-6 tracking-wide inline-flex items-center justify-center font-medium rounded-md bg-teal-500 text-white">Ver
                                            Más</a>
                                    </div>
                                </div>
                            </div><!--end grid-->
                        </div><!--end container-->
                    </div><!-- end slide-inner -->
                </div> <!-- end swiper-slide -->

                <div class="swiper-slide flex items-center overflow-hidden">
                    <?php $slider2 = Voyager::setting('home.slider2'); ?>
                    <div class="slide-inner absolute end-0 top-0 w-full h-full slide-bg-image flex items-center bg-center bg-opacity-0;"
                        data-background="{{ Voyager::image($slider2) }}">
                        <div class="absolute inset-0 bg-black/70"></div>
                        <div class="container relative">
                            <div class="grid grid-cols-1">
                                <div class="">
                                    <h1
                                        class="font-bold lg:leading-normal leading-normal tracking-wide text-4xl lg:text-5xl capitalize text-white mb-5">
                                        {{ Voyager::setting('home.titulo2') }}</h1>
                                    <p class="text-white/70 text-lg max-w-xl">{{ Voyager::setting('home.subtitulo2') }}
                                    </p>

                                    <div class="mt-6">
                                        <a href=""
                                            class="h-10 px-6 tracking-wide inline-flex items-center justify-center font-medium rounded-md bg-teal-500 text-white">Ver
                                            Más</a>
                                    </div>
                                </div>
                            </div><!--end grid-->
                        </div><!--end container-->
                    </div><!-- end slide-inner -->
                </div> <!-- end swiper-slide -->

                <div class="swiper-slide flex items-center overflow-hidden">
                    <?php $slider3 = Voyager::setting('home.slider3', ''); ?>
                    <div class="slide-inner absolute end-0 top-0 w-full h-full slide-bg-image flex items-center bg-center bg-opacity-0;"
                        data-background="{{ Voyager::image($slider3) }}">
                        <div class="absolute inset-0 bg-black/70"></div>
                        <div class="container relative">
                            <div class="grid grid-cols-1">
                                <div class="">
                                    <h1
                                        class="font-bold lg:leading-normal leading-normal tracking-wide text-4xl lg:text-5xl capitalize text-white mb-5">
                                        {{ Voyager::setting('home.titulo3') }}</h1>
                                    <p class="text-white/70 text-lg max-w-xl">
                                        {{ Voyager::setting('home.subtitulo3') }}</p>
                                    <div class="mt-6">
                                        <a href=""
                                            class="h-10 px-6 tracking-wide inline-flex items-center justify-center font-medium rounded-md bg-teal-500 text-white">Ver
                                            Más</a>
                                    </div>
                                </div>
                            </div><!--end grid-->
                        </div><!--end container-->
                    </div><!-- end slide-inner -->
                </div> <!-- end swiper-slide -->

                <div class="swiper-slide flex items-center overflow-hidden">
                    <?php $slider4 = Voyager::setting('home.slider4', ''); ?>
                    <div class="slide-inner absolute end-0 top-0 w-full h-full slide-bg-image flex items-center bg-center bg-opacity-0;"
                        data-background="{{ Voyager::image($slider4) }}">
                        <div class="absolute inset-0 bg-black/70"></div>
                        <div class="container relative">
                            <div class="grid grid-cols-1">
                                <div class="">
                                    <h1
                                        class="font-bold lg:leading-normal leading-normal tracking-wide text-4xl lg:text-5xl capitalize text-white mb-5">
                                        {{ Voyager::setting('home.titulo4') }}</h1>
                                    <p class="text-white/70 text-lg max-w-xl">
                                        {{ Voyager::setting('home.subtitulo4') }}</p>
                                    <div class="mt-6">
                                        <a href=""
                                            class="h-10 px-6 tracking-wide inline-flex items-center justify-center font-medium rounded-md bg-teal-500 text-white">Ver
                                            Más</a>
                                    </div>
                                </div>
                            </div><!--end grid-->
                        </div><!--end container-->
                    </div><!-- end slide-inner -->
                </div> <!-- end swiper-slide -->
            </div>
            <!-- end swiper-wrapper -->

            <!-- swipper controls -->
            <div class="swiper-pagination"></div>
            <div
                class="swiper-button-next bg-transparent w-[35px] h-[35px] leading-[35px] -mt-[30px] bg-none border border-solid border-white/50 text-white hover:bg-teal-500 rounded-full text-center">
            </div>
            <div
                class="swiper-button-prev bg-transparent w-[35px] h-[35px] leading-[35px] -mt-[30px] bg-none border border-solid border-white/50 text-white hover:bg-teal-500 rounded-full text-center">
            </div>
        </div><!--end container-->
    </section><!--end section-->
    <!-- Hero End -->

    <!-- Start About -->
    <section class="relative md:py-24 py-16">
        <div class="container relative">
            <div class="grid md:grid-cols-12 grid-cols-1 items-center gap-6">
                <div class="md:col-span-6">
                    <div class="lg:me-8">
                        <div class="relative">
                            <?php $bg_politicas = Voyager::setting('home.bg_politicas', ''); ?>
                            <img src="{{ Voyager::image($bg_politicas) }}"
                                class="rounded-full shadow dark:shadow-gray-700" alt="Logo Icon">
                            {{-- <img src="assets/images/about.jpg" class="rounded-full shadow dark:shadow-gray-700"
                                alt=""> --}}

                            {{-- <div class="absolute top-1/2 -translate-y-1/2 start-0 end-0 mx-auto size-56 flex justify-center items-center bg-white dark:bg-slate-900 rounded-full shadow dark:shadow-gray-700">
                                <div class="text-center">
                                    <span class="text-teal-500 text-2xl font-semibold mb-0 block"><span
                                            class="counter-value text-6xl font-semibold"
                                            data-target="15">1</span>+</span>
                                    <span class="font-semibold block mt-2">Years <br> Experience</span>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>

                <div class="md:col-span-6">
                    <div class="lg:ms-8">
                        {{-- <h6 class="text-teal-500 text-sm font-semibold uppercase mb-2">Who Are We ?</h6> --}}
                        <h1 class="font-semibold text-2xl leading-normal mb-4">
                            {{ Voyager::setting('home.titulo_politicas') }}</h1>

                        <p class="text-slate-400 max-w-xl mb-6">{{ Voyager::setting('home.text_politicas') }}</p>

                        <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 mt-6 gap-6">
                            <div class="group relative overflow-hidden">
                                <div class="relative overflow-hidden rounded-md shadow dark:shadow-gray-800">
                                    <?php $bg_politica1 = Voyager::setting('home.bg_politica1', ''); ?>
                                    <img src="{{ Voyager::image($bg_politica1) }}"
                                        class="group-hover:scale-110 duration-500" alt="Logo Icon">
                                    {{-- <img src="assets/images/blog/01.jpg" class="group-hover:scale-110 duration-500"
                                        alt=""> --}}
                                </div>

                                <div class="mt-6">
                                    {{-- <a href=""
                                        class="title text-lg font-semibold hover:text-teal-500 duration-500 ease-in-out">La
                                        Ventanilla Única de Servicios no tiene intermediarios.</a> --}}
                                    <h2 class="text-slate-400 mt-2">{{ Voyager::setting('home.text_politica1') }}</h2>


                                </div>
                            </div><!--end content-->

                            <div class="group relative overflow-hidden">
                                <div class="relative overflow-hidden rounded-md shadow dark:shadow-gray-800">
                                    <?php $bg_politica2 = Voyager::setting('home.bg_politica2', ''); ?>
                                    <img src="{{ Voyager::image($bg_politica2) }}"
                                        class="group-hover:scale-110 duration-500" alt="Logo Icon">
                                    {{-- <img src="assets/images/blog/02.jpg" class="group-hover:scale-110 duration-500"
                                        alt=""> --}}
                                </div>

                                <div class="mt-6">
                                    <p class="text-slate-400 mt-2">{{ Voyager::setting('home.text_politica2') }}</p>
                                </div>
                            </div><!--end content-->

                            <div class="group relative overflow-hidden">
                                <div class="relative overflow-hidden rounded-md shadow dark:shadow-gray-800">
                                    <?php $bg_politica3 = Voyager::setting('home.bg_politica3', ''); ?>
                                    <img src="{{ Voyager::image($bg_politica3) }}"
                                        class="group-hover:scale-110 duration-500" alt="Logo Icon">
                                    {{-- <img src="assets/images/blog/03.jpg" class="group-hover:scale-110 duration-500"
                                        alt=""> --}}
                                </div>
                                <div class="mt-6">
                                    <p class="text-slate-400 mt-2">{{ Voyager::setting('home.text_politica3') }}</p>
                                </div>
                            </div><!--end content-->
                        </div><!--end grid-->

                        {{-- @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/admin') }}"
                                    class="h-10 px-6 tracking-wide inline-flex items-center justify-center font-medium rounded-md bg-teal-500 text-white">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="h-10 px-6 tracking-wide inline-flex items-center justify-center font-medium rounded-md bg-teal-500 text-white">Iniciar
                                    Sesión</a>
                            @endauth
                        @endif --}}
                        {{-- <a href=""
                            class="h-10 px-6 tracking-wide inline-flex items-center justify-center font-medium rounded-md bg-teal-500 text-white">Read
                            More <i class="mdi mdi-chevron-right align-middle ms-0.5"></i></a> --}}
                    </div>
                </div>
            </div>
        </div><!--end container-->
    </section><!--end section-->
    <!-- End About -->

    {{-- <!-- Start Feature -->
    <section class="relative md:py-24 py-16 bg-slate-50 dark:bg-slate-800" id="services">
        <div class="container relative">
            <div class="grid grid-cols-1 pb-6 text-center">
                <h3 class="font-semibold text-2xl leading-normal mb-4">Our Services</h3>

                <p class="text-slate-400 max-w-xl mx-auto">This is just a simple text made for this unique and awesome
                    template, you can replace it with any text.</p>
            </div><!--end grid-->

            <div class="grid lg:grid-cols-4 md:grid-cols-2 sm:grid-cols-2 grid-cols-1 gap-6 mt-6">
                <div
                    class="group rounded-md shadow dark:shadow-gray-700 relative bg-white dark:bg-slate-900 p-6 overflow-hidden h-fit">
                    <div
                        class="flex items-center justify-center size-14 -rotate-45 bg-gradient-to-r from-transparent to-teal-500/10 text-teal-500 text-center rounded-full group-hover:bg-teal-500/10 duration-500">
                        <i data-feather="trending-up" class="size-6 rotate-45"></i>
                    </div>

                    <div class="content mt-6 relative z-1">
                        <a href="" class="title text-lg font-semibold hover:text-teal-500">Grow Your
                            Business</a>
                        <p class="text-slate-400 mt-3">If the distribution of letters and 'words' is random, the reader
                            will not be distracted from making.</p>

                        <div class="mt-6">
                            <a href="" class="text-teal-500">Read More <i
                                    class="mdi mdi-chevron-right align-middle"></i></a>
                        </div>
                    </div>

                    <div class="absolute bottom-0 -end-16">
                        <i data-feather="trending-up"
                            class="size-48 text-teal-500 opacity-[0.04] dark:opacity-[0.04] group-hover:opacity-10 duration-500"></i>
                    </div>
                </div><!--end feature content-->

                <div
                    class="group rounded-md shadow dark:shadow-gray-700 relative bg-white dark:bg-slate-900 p-6 overflow-hidden h-fit">
                    <div
                        class="flex items-center justify-center size-14 -rotate-45 bg-gradient-to-r from-transparent to-teal-500/10 text-teal-500 text-center rounded-full group-hover:bg-teal-500/10 duration-500">
                        <i data-feather="dollar-sign" class="size-6 rotate-45"></i>
                    </div>

                    <div class="content mt-6 relative z-1">
                        <a href="" class="title text-lg font-semibold hover:text-teal-500">Drive More Sales</a>
                        <p class="text-slate-400 mt-3">If the distribution of letters and 'words' is random, the reader
                            will not be distracted from making.</p>

                        <div class="mt-6">
                            <a href="" class="text-teal-500">Read More <i
                                    class="mdi mdi-chevron-right align-middle"></i></a>
                        </div>
                    </div>

                    <div class="absolute bottom-0 -end-16">
                        <i data-feather="dollar-sign"
                            class="size-48 text-teal-500 opacity-[0.04] dark:opacity-[0.04] group-hover:opacity-10 duration-500"></i>
                    </div>
                </div><!--end feature content-->

                <div
                    class="group rounded-md shadow dark:shadow-gray-700 relative bg-white dark:bg-slate-900 p-6 overflow-hidden h-fit">
                    <div
                        class="flex items-center justify-center size-14 -rotate-45 bg-gradient-to-r from-transparent to-teal-500/10 text-teal-500 text-center rounded-full group-hover:bg-teal-500/10 duration-500">
                        <i data-feather="compass" class="size-6 rotate-45"></i>
                    </div>

                    <div class="content mt-6 relative z-1">
                        <a href="" class="title text-lg font-semibold hover:text-teal-500">Handled By
                            Expert</a>
                        <p class="text-slate-400 mt-3">If the distribution of letters and 'words' is random, the reader
                            will not be distracted from making.</p>

                        <div class="mt-6">
                            <a href="" class="text-teal-500">Read More <i
                                    class="mdi mdi-chevron-right align-middle"></i></a>
                        </div>
                    </div>

                    <div class="absolute bottom-0 -end-16">
                        <i data-feather="compass"
                            class="size-48 text-teal-500 opacity-[0.04] dark:opacity-[0.04] group-hover:opacity-10 duration-500"></i>
                    </div>
                </div><!--end feature content-->

                <div
                    class="group rounded-md shadow dark:shadow-gray-700 relative bg-white dark:bg-slate-900 p-6 overflow-hidden h-fit">
                    <div
                        class="flex items-center justify-center size-14 -rotate-45 bg-gradient-to-r from-transparent to-teal-500/10 text-teal-500 text-center rounded-full group-hover:bg-teal-500/10 duration-500">
                        <i data-feather="command" class="size-6 rotate-45"></i>
                    </div>

                    <div class="content mt-6 relative z-1">
                        <a href="" class="title text-lg font-semibold hover:text-teal-500">Discussion For
                            Idea</a>
                        <p class="text-slate-400 mt-3">If the distribution of letters and 'words' is random, the reader
                            will not be distracted from making.</p>

                        <div class="mt-6">
                            <a href="" class="text-teal-500">Read More <i
                                    class="mdi mdi-chevron-right align-middle"></i></a>
                        </div>
                    </div>

                    <div class="absolute bottom-0 -end-16">
                        <i data-feather="command"
                            class="size-48 text-teal-500 opacity-[0.04] dark:opacity-[0.04] group-hover:opacity-10 duration-500"></i>
                    </div>
                </div><!--end feature content-->

                <div
                    class="group rounded-md shadow dark:shadow-gray-700 relative bg-white dark:bg-slate-900 p-6 overflow-hidden h-fit">
                    <div
                        class="flex items-center justify-center size-14 -rotate-45 bg-gradient-to-r from-transparent to-teal-500/10 text-teal-500 text-center rounded-full group-hover:bg-teal-500/10 duration-500">
                        <i data-feather="box" class="size-6 rotate-45"></i>
                    </div>

                    <div class="content mt-6 relative z-1">
                        <a href="" class="title text-lg font-semibold hover:text-teal-500">Web Design</a>
                        <p class="text-slate-400 mt-3">If the distribution of letters and 'words' is random, the reader
                            will not be distracted from making.</p>

                        <div class="mt-6">
                            <a href="" class="text-teal-500">Read More <i
                                    class="mdi mdi-chevron-right align-middle"></i></a>
                        </div>
                    </div>

                    <div class="absolute bottom-0 -end-16">
                        <i data-feather="box"
                            class="size-48 text-teal-500 opacity-[0.04] dark:opacity-[0.04] group-hover:opacity-10 duration-500"></i>
                    </div>
                </div><!--end feature content-->

                <div
                    class="group rounded-md shadow dark:shadow-gray-700 relative bg-white dark:bg-slate-900 p-6 overflow-hidden h-fit">
                    <div
                        class="flex items-center justify-center size-14 -rotate-45 bg-gradient-to-r from-transparent to-teal-500/10 text-teal-500 text-center rounded-full group-hover:bg-teal-500/10 duration-500">
                        <i data-feather="camera" class="size-6 rotate-45"></i>
                    </div>

                    <div class="content mt-6 relative z-1">
                        <a href="" class="title text-lg font-semibold hover:text-teal-500">Network Security</a>
                        <p class="text-slate-400 mt-3">If the distribution of letters and 'words' is random, the reader
                            will not be distracted from making.</p>

                        <div class="mt-6">
                            <a href="" class="text-teal-500">Read More <i
                                    class="mdi mdi-chevron-right align-middle"></i></a>
                        </div>
                    </div>

                    <div class="absolute bottom-0 -end-16">
                        <i data-feather="camera"
                            class="size-48 text-teal-500 opacity-[0.04] dark:opacity-[0.04] group-hover:opacity-10 duration-500"></i>
                    </div>
                </div><!--end feature content-->

                <div
                    class="group rounded-md shadow dark:shadow-gray-700 relative bg-white dark:bg-slate-900 p-6 overflow-hidden h-fit">
                    <div
                        class="flex items-center justify-center size-14 -rotate-45 bg-gradient-to-r from-transparent to-teal-500/10 text-teal-500 text-center rounded-full group-hover:bg-teal-500/10 duration-500">
                        <i data-feather="bell" class="size-6 rotate-45"></i>
                    </div>

                    <div class="content mt-6 relative z-1">
                        <a href="" class="title text-lg font-semibold hover:text-teal-500">Social Media</a>
                        <p class="text-slate-400 mt-3">If the distribution of letters and 'words' is random, the reader
                            will not be distracted from making.</p>

                        <div class="mt-6">
                            <a href="" class="text-teal-500">Read More <i
                                    class="mdi mdi-chevron-right align-middle"></i></a>
                        </div>
                    </div>

                    <div class="absolute bottom-0 -end-16">
                        <i data-feather="bell"
                            class="size-48 text-teal-500 opacity-[0.04] dark:opacity-[0.04] group-hover:opacity-10 duration-500"></i>
                    </div>
                </div><!--end feature content-->

                <div
                    class="group rounded-md shadow dark:shadow-gray-700 relative bg-white dark:bg-slate-900 p-6 overflow-hidden h-fit">
                    <div
                        class="flex items-center justify-center size-14 -rotate-45 bg-gradient-to-r from-transparent to-teal-500/10 text-teal-500 text-center rounded-full group-hover:bg-teal-500/10 duration-500">
                        <i data-feather="monitor" class="size-6 rotate-45"></i>
                    </div>

                    <div class="content mt-6 relative z-1">
                        <a href="" class="title text-lg font-semibold hover:text-teal-500">Design &
                            Branding</a>
                        <p class="text-slate-400 mt-3">If the distribution of letters and 'words' is random, the reader
                            will not be distracted from making.</p>

                        <div class="mt-6">
                            <a href="" class="text-teal-500">Read More <i
                                    class="mdi mdi-chevron-right align-middle"></i></a>
                        </div>
                    </div>

                    <div class="absolute bottom-0 -end-16">
                        <i data-feather="monitor"
                            class="size-48 text-teal-500 opacity-[0.04] dark:opacity-[0.04] group-hover:opacity-10 duration-500"></i>
                    </div>
                </div><!--end feature content-->
            </div><!--end grid-->
        </div><!--end container-->
    </section><!--end section-->
    <!-- End Features --> --}}

    <!-- Start Process -->
    <section class="realtive md:py-24 py-16">
        <div class="container relative">
            <div class="grid grid-cols-1 pb-6 text-center">
                <h3 class="font-semibold text-2xl leading-normal mb-4">{{ Voyager::setting('home.title_tramites') }}
                </h3>

                <p class="text-slate-400 max-w-xl mx-auto">{{ Voyager::setting('home.text_tramites') }}</p>
            </div><!--end grid-->

            <div class="grid md:grid-cols-12 grid-cols-1 mt-6 gap-6">
                <div class="lg:col-span-4 md:col-span-5">
                    <div class="sticky top-20">
                        <ul class="flex-column p-6 bg-white dark:bg-slate-900 shadow dark:shadow-gray-700 rounded-md"
                            id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                            <li role="presentation">
                                <button
                                    class="px-4 py-2 text-start text-base font-medium rounded-md w-full hover:text-teal-500 duration-500"
                                    id="profile-tab" data-tabs-target="#profile" type="button" role="tab"
                                    aria-controls="profile" aria-selected="true">
                                    {{-- <h1 class="block">1</h1> --}}
                                    <span
                                        class="text-lg mt-2 block">{{ Voyager::setting('home.title_servicio1') }}</span>
                                    <span class="block mt-2">{{ Voyager::setting('home.text_servicio1') }}</span>
                                </button>
                            </li>
                            <li role="presentation">
                                <button
                                    class="px-4 py-2 text-start text-base font-medium rounded-md w-full mt-6 duration-500"
                                    id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab"
                                    aria-controls="dashboard" aria-selected="false">
                                    {{-- <span class="block">Step 2</span> --}}
                                    <span
                                        class="text-lg mt-2 block">{{ Voyager::setting('home.title_servicio2') }}</span>
                                    <span class="block mt-2">{{ Voyager::setting('home.text_servicio2') }}</span>
                                </button>
                            </li>
                            <li role="presentation">
                                <button
                                    class="px-4 py-2 text-start text-base font-medium rounded-md w-full mt-6 duration-500"
                                    id="settings-tab" data-tabs-target="#settings" type="button" role="tab"
                                    aria-controls="settings" aria-selected="false">
                                    {{-- <span class="block">Step 3</span> --}}
                                    <span
                                        class="text-lg mt-2 block">{{ Voyager::setting('home.title_servicio3') }}</span>
                                    <span class="block mt-2">{{ Voyager::setting('home.text_servicio3') }}</span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="lg:col-span-8 md:col-span-7">
                    <div id="myTabContent"
                        class="p-6 bg-white dark:bg-slate-900 shadow dark:shadow-gray-700 rounded-md">
                        <div class="" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <?php $bg_servicio1 = Voyager::setting('home.bg_servicio1', ''); ?>
                            <img src="{{ Voyager::image($bg_servicio1) }}"
                                class="shadow dark:shadow-gray-700 rounded-md" alt="Logo Icon">
                            {{-- <img src="assets/images/blog/01.jpg" class="shadow dark:shadow-gray-700 rounded-md"
                                alt=""> --}}

                            {{-- <div class="mt-6">
                                <h5 class="text-lg font-medium">SEO Audit</h5>
                                <p class="text-slate-400 mt-4">Lorem ipsum dolor sit amet, consectetur adipisicing
                                    elit. Itaque, impedit vitae. Nobis, similique omnis cumque sapiente laboriosam animi
                                    quod cupiditate?</p>
                                <div class="mt-4">
                                    <a href="" class="text-teal-500">Read More <i
                                            class="mdi mdi-chevron-right align-middle"></i></a>
                                </div>
                            </div> --}}
                        </div>
                        <div class="hidden " id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                            <?php $bg_servicio2 = Voyager::setting('home.bg_servicio2', ''); ?>
                            <img src="{{ Voyager::image($bg_servicio2) }}"
                                class="shadow dark:shadow-gray-700 rounded-md" alt="Logo Icon">
                            {{-- <img src="assets/images/blog/02.jpg" class="shadow dark:shadow-gray-700 rounded-md"
                                alt=""> --}}

                            {{-- <div class="mt-6">
                                <h5 class="text-lg font-medium">Project Execution</h5>
                                <p class="text-slate-400 mt-4">Lorem ipsum dolor sit amet, consectetur adipisicing
                                    elit. Itaque, impedit vitae. Nobis, similique omnis cumque sapiente laboriosam animi
                                    quod cupiditate?</p>
                                <div class="mt-4">
                                    <a href="" class="text-teal-500">Read More <i
                                            class="mdi mdi-chevron-right align-middle"></i></a>
                                </div>
                            </div> --}}
                        </div>
                        <div class="hidden " id="settings" role="tabpanel" aria-labelledby="settings-tab">
                            <?php $bg_servicio3 = Voyager::setting('home.bg_servicio3', ''); ?>
                            <img src="{{ Voyager::image($bg_servicio3) }}"
                                class="shadow dark:shadow-gray-700 rounded-md" alt="Logo Icon">
                            {{-- <img src="assets/images/blog/03.jpg" class="shadow dark:shadow-gray-700 rounded-md"
                                alt=""> --}}

                            {{-- <div class="mt-6">
                                <h5 class="text-lg font-medium">Results & Reporting</h5>
                                <p class="text-slate-400 mt-4">Lorem ipsum dolor sit amet, consectetur adipisicing
                                    elit. Itaque, impedit vitae. Nobis, similique omnis cumque sapiente laboriosam animi
                                    quod cupiditate?</p>
                                <div class="mt-4">
                                    <a href="" class="text-teal-500">Read More <i
                                            class="mdi mdi-chevron-right align-middle"></i></a>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div><!--end grid-->
        </div><!--end container-->
    </section><!--end section-->
    <!-- End Process -->

    {{-- <section class="relative md:py-24 py-16 md:pt-0 pt-0">
        <div class="container relative">
            <div class="grid grid-cols-1 justify-center">
                <div class="relative z-1">
                    <div class="grid grid-cols-1 md:text-start text-center justify-center">
                        <div class="relative">
                            <img src="assets/images/home.png" alt="">
                            <div class="absolute bottom-2/4 translate-y-2/4 start-0 end-0 text-center">
                                <a href="#!" data-type="youtube" data-id="S_CGed6E610"
                                    class="lightbox size-20 rounded-full shadow-lg dark:shadow-gray-700 inline-flex items-center justify-center bg-white dark:bg-slate-900 text-teal-500 dark:text-white">
                                    <i class="mdi mdi-play inline-flex items-center justify-center text-2xl"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="content md:mt-8">
                        <div class="grid lg:grid-cols-12 grid-cols-1 md:text-start text-center justify-center">
                            <div class="lg:col-start-2 lg:col-span-10">
                                <div class="grid md:grid-cols-2 grid-cols-1 items-center">
                                    <div class="mt-8">
                                        <div class="section-title text-md-start">
                                            <h6 class="text-white/70 text-sm font-semibold uppercase">Get Free Trial
                                            </h6>
                                            <h3 class="font-semibold text-2xl leading-normal text-white mt-2">Get An
                                                Easy Start <br> With Upcover Now</h3>
                                        </div>
                                    </div>

                                    <div class="mt-8">
                                        <div class="section-title text-md-start">
                                            <p class="text-white/70 max-w-xl mx-auto mb-2">This is just a simple text
                                                made for this unique and awesome template, you can replace it with any
                                                text.</p>
                                            <a href="" class="text-white">Read More <i
                                                    class="mdi mdi-chevron-right align-middle"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end row -->
        </div><!--end container-->

        <div class="absolute bottom-0 start-0 end-0 sm:h-2/3 h-4/5 bg-gradient-to-b from-teal-400 to-teal-500"></div>
    </section><!--end section-->
    <!-- End --> --}}

    {{-- <!-- Start Review -->
    <section class="relative md:py-24 py-16" id="review">
        <div class="container relative">
            <div class="grid grid-cols-1 pb-6 text-center">
                <h3 class="font-semibold text-2xl leading-normal mb-4">What Our Users Say</h3>

                <p class="text-slate-400 max-w-xl mx-auto">This is just a simple text made for this unique and awesome
                    template, you can replace it with any text.</p>
            </div><!--end grid-->

            <div class="grid grid-cols-1 mt-6">
                <div class="tiny-three-item">
                    <div class="tiny-slide text-center">
                        <div class="cursor-e-resize">
                            <div
                                class="content relative rounded shadow dark:shadow-gray-700 m-2 p-6 bg-white dark:bg-slate-900 before:content-[''] before:absolute before:start-1/2 before:-bottom-[4px] before:box-border before:border-8 before:rotate-[45deg] before:border-t-transparent before:border-e-white dark:before:border-e-slate-900 before:border-b-white dark:before:border-b-slate-900 before:border-s-transparent before:shadow-testi dark:before:shadow-gray-700 before:origin-top-left">
                                <i class="mdi mdi-format-quote-open mdi-48px text-teal-500"></i>
                                <p class="text-slate-400">" It seems that only fragments of the original text remain in
                                    the Lorem Ipsum texts used today. "</p>
                                <ul class="list-none mb-0 text-amber-400 mt-3">
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                </ul>
                            </div>

                            <div class="text-center mt-5">
                                <img src="assets/images/team/01.jpg"
                                    class="size-14 rounded-full shadow-md dark:shadow-gray-700 mx-auto"
                                    alt="">
                                <h6 class="mt-2 font-semibold">Calvin Carlo</h6>
                                <span class="text-slate-400 text-sm">Manager</span>
                            </div>
                        </div>
                    </div>

                    <div class="tiny-slide text-center">
                        <div class="cursor-e-resize">
                            <div
                                class="content relative rounded shadow dark:shadow-gray-700 m-2 p-6 bg-white dark:bg-slate-900 before:content-[''] before:absolute before:start-1/2 before:-bottom-[4px] before:box-border before:border-8 before:rotate-[45deg] before:border-t-transparent before:border-e-white dark:before:border-e-slate-900 before:border-b-white dark:before:border-b-slate-900 before:border-s-transparent before:shadow-testi dark:before:shadow-gray-700 before:origin-top-left">
                                <i class="mdi mdi-format-quote-open mdi-48px text-teal-500"></i>
                                <p class="text-slate-400">" The most well-known dummy text is the 'Lorem Ipsum', which
                                    is said to have originated in the 16th century. "</p>
                                <ul class="list-none mb-0 text-amber-400 mt-3">
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                </ul>
                            </div>

                            <div class="text-center mt-5">
                                <img src="assets/images/team/02.jpg"
                                    class="size-14 rounded-full shadow-md dark:shadow-gray-700 mx-auto"
                                    alt="">
                                <h6 class="mt-2 font-semibold">Christa Smith</h6>
                                <span class="text-slate-400 text-sm">Manager</span>
                            </div>
                        </div>
                    </div>

                    <div class="tiny-slide text-center">
                        <div class="cursor-e-resize">
                            <div
                                class="content relative rounded shadow dark:shadow-gray-700 m-2 p-6 bg-white dark:bg-slate-900 before:content-[''] before:absolute before:start-1/2 before:-bottom-[4px] before:box-border before:border-8 before:rotate-[45deg] before:border-t-transparent before:border-e-white dark:before:border-e-slate-900 before:border-b-white dark:before:border-b-slate-900 before:border-s-transparent before:shadow-testi dark:before:shadow-gray-700 before:origin-top-left">
                                <i class="mdi mdi-format-quote-open mdi-48px text-teal-500"></i>
                                <p class="text-slate-400">" One disadvantage of Lorum Ipsum is that in Latin certain
                                    letters appear more frequently than others. "</p>
                                <ul class="list-none mb-0 text-amber-400 mt-3">
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                </ul>
                            </div>

                            <div class="text-center mt-5">
                                <img src="assets/images/team/03.jpg"
                                    class="size-14 rounded-full shadow-md dark:shadow-gray-700 mx-auto"
                                    alt="">
                                <h6 class="mt-2 font-semibold">Jemina CLone</h6>
                                <span class="text-slate-400 text-sm">Manager</span>
                            </div>
                        </div>
                    </div>

                    <div class="tiny-slide text-center">
                        <div class="cursor-e-resize">
                            <div
                                class="content relative rounded shadow dark:shadow-gray-700 m-2 p-6 bg-white dark:bg-slate-900 before:content-[''] before:absolute before:start-1/2 before:-bottom-[4px] before:box-border before:border-8 before:rotate-[45deg] before:border-t-transparent before:border-e-white dark:before:border-e-slate-900 before:border-b-white dark:before:border-b-slate-900 before:border-s-transparent before:shadow-testi dark:before:shadow-gray-700 before:origin-top-left">
                                <i class="mdi mdi-format-quote-open mdi-48px text-teal-500"></i>
                                <p class="text-slate-400">" Thus, Lorem Ipsum has only limited suitability as a visual
                                    filler for German texts. "</p>
                                <ul class="list-none mb-0 text-amber-400 mt-3">
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                </ul>
                            </div>

                            <div class="text-center mt-5">
                                <img src="assets/images/team/04.jpg"
                                    class="size-14 rounded-full shadow-md dark:shadow-gray-700 mx-auto"
                                    alt="">
                                <h6 class="mt-2 font-semibold">Smith Vodka</h6>
                                <span class="text-slate-400 text-sm">Manager</span>
                            </div>
                        </div>
                    </div>

                    <div class="tiny-slide text-center">
                        <div class="cursor-e-resize">
                            <div
                                class="content relative rounded shadow dark:shadow-gray-700 m-2 p-6 bg-white dark:bg-slate-900 before:content-[''] before:absolute before:start-1/2 before:-bottom-[4px] before:box-border before:border-8 before:rotate-[45deg] before:border-t-transparent before:border-e-white dark:before:border-e-slate-900 before:border-b-white dark:before:border-b-slate-900 before:border-s-transparent before:shadow-testi dark:before:shadow-gray-700 before:origin-top-left">
                                <i class="mdi mdi-format-quote-open mdi-48px text-teal-500"></i>
                                <p class="text-slate-400">" There is now an abundance of readable dummy texts. These
                                    are usually used when a text is required. "</p>
                                <ul class="list-none mb-0 text-amber-400 mt-3">
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                </ul>
                            </div>

                            <div class="text-center mt-5">
                                <img src="assets/images/team/05.jpg"
                                    class="size-14 rounded-full shadow-md dark:shadow-gray-700 mx-auto"
                                    alt="">
                                <h6 class="mt-2 font-semibold">Cristino Murfi</h6>
                                <span class="text-slate-400 text-sm">Manager</span>
                            </div>
                        </div>
                    </div>

                    <div class="tiny-slide text-center">
                        <div class="cursor-e-resize">
                            <div
                                class="content relative rounded shadow dark:shadow-gray-700 m-2 p-6 bg-white dark:bg-slate-900 before:content-[''] before:absolute before:start-1/2 before:-bottom-[4px] before:box-border before:border-8 before:rotate-[45deg] before:border-t-transparent before:border-e-white dark:before:border-e-slate-900 before:border-b-white dark:before:border-b-slate-900 before:border-s-transparent before:shadow-testi dark:before:shadow-gray-700 before:origin-top-left">
                                <i class="mdi mdi-format-quote-open mdi-48px text-teal-500"></i>
                                <p class="text-slate-400">" According to most sources, Lorum Ipsum can be traced back
                                    to a text composed by Cicero. "</p>
                                <ul class="list-none mb-0 text-amber-400 mt-3">
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                    <li class="inline"><i class="mdi mdi-star"></i></li>
                                </ul>
                            </div>

                            <div class="text-center mt-5">
                                <img src="assets/images/team/06.jpg"
                                    class="size-14 rounded-full shadow-md dark:shadow-gray-700 mx-auto"
                                    alt="">
                                <h6 class="mt-2 font-semibold">Cristino Murfi</h6>
                                <span class="text-slate-400 text-sm">Manager</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end grid-->
        </div><!--end container-->
    </section><!--end section-->
    <!-- End Review--> --}}

    <!-- Start Pricing -->
    {{-- <section class="relative md:py-24 py-16 bg-slate-50 dark:bg-slate-800" id="pricing">
        <div class="container relative">
            <div class="grid grid-cols-1 pb-6 text-center">
                <h3 class="font-semibold text-2xl leading-normal mb-4">Our Pricing</h3>
                <p class="text-slate-400 max-w-xl mx-auto">This is just a simple text made for this unique and awesome
                    template, you can replace it with any text.</p>
            </div><!--end grid-->

            <div class="grid lg:grid-cols-4 md:grid-cols-2 grid-cols-1 mt-6 gap-6">
                <div
                    class="group p-6 relative overflow-hidden shadow dark:shadow-gray-700 bg-white dark:bg-slate-900 rounded-md h-fit">
                    <h6 class="font-semibold mb-5 text-xl">Free</h6>

                    <div class="flex mb-5">
                        <span class="text-lg font-medium">$</span>
                        <span class="price text-5xl h6 font-semibold mb-0">0</span>
                        <span class="text-lg font-medium self-end mb-1">/mo</span>
                    </div>

                    <ul class="list-none text-slate-400">
                        <li class="mb-1 flex"><i
                                class="mdi mdi-check-circle-outline text-teal-500 text-[20px] align-middle me-2"></i>
                            <span>We offers a free month of service for new customers.</span>
                        </li>
                    </ul>
                    <a href=""
                        class="h-10 px-6 tracking-wide inline-flex items-center justify-center font-medium rounded-md bg-teal-500/5 hover:bg-teal-500 text-teal-500 hover:text-white w-full mt-5">Free
                        Demo</a>
                </div><!--end content-->

                <div
                    class="group p-6 relative overflow-hidden shadow dark:shadow-gray-700 bg-white dark:bg-slate-900 rounded-md h-fit">
                    <h6 class="font-semibold mb-5 text-xl">Single</h6>

                    <div class="flex mb-5">
                        <span class="text-lg font-medium">$</span>
                        <span class="price text-5xl h6 font-semibold mb-0">9</span>
                        <span class="text-lg font-medium self-end mb-1">/mo</span>
                    </div>

                    <ul class="list-none text-slate-400">
                        <li class="mb-1 flex"><i
                                class="mdi mdi-check-circle-outline text-teal-500 text-[20px] align-middle me-2"></i>
                            <span>We offers a free 7 days of service for new customers.</span>
                        </li>
                        <li class="mb-1 flex"><i
                                class="mdi mdi-check-circle-outline text-teal-500 text-[20px] align-middle me-2"></i>
                            <span>Our Talented & Experienced Marketing Agency</span>
                        </li>
                    </ul>
                    <a href=""
                        class="h-10 px-6 tracking-wide inline-flex items-center justify-center font-medium rounded-md bg-teal-500/5 hover:bg-teal-500 text-teal-500 hover:text-white w-full mt-5">Subscribe
                        Now</a>
                </div><!--end content-->

                <div
                    class="group relative overflow-hidden shadow dark:shadow-gray-700 bg-white dark:bg-slate-900 rounded-md h-fit">
                    <div
                        class="bg-gradient-to-tr from-teal-500 to-indigo-600 text-white py-2 px-6 h6 text-lg font-medium">
                        Popular</div>
                    <div class="p-6">
                        <h6 class="font-semibold mb-5 text-xl">Professional</h6>

                        <div class="flex mb-5">
                            <span class="text-lg font-medium">$</span>
                            <span class="price text-5xl h6 font-semibold mb-0">49</span>
                            <span class="text-lg font-medium self-end mb-1">/mo</span>
                        </div>

                        <ul class="list-none text-slate-400">
                            <li class="mb-1 flex"><i
                                    class="mdi mdi-check-circle-outline text-teal-500 text-[20px] align-middle me-2"></i>
                                <span>We offers a free 14 days of service for new customers.</span>
                            </li>
                            <li class="mb-1 flex"><i
                                    class="mdi mdi-check-circle-outline text-teal-500 text-[20px] align-middle me-2"></i>
                                <span>Full Access</span>
                            </li>
                            <li class="mb-1 flex"><i
                                    class="mdi mdi-check-circle-outline text-teal-500 text-[20px] align-middle me-2"></i>
                                <span>Source Files</span>
                            </li>
                            <li class="mb-1 flex"><i
                                    class="mdi mdi-check-circle-outline text-teal-500 text-[20px] align-middle me-2"></i>
                                <span>Free Appointments</span>
                            </li>
                            <li class="mb-1 flex"><i
                                    class="mdi mdi-check-circle-outline text-teal-500 text-[20px] align-middle me-2"></i>
                                <span>Enhanced Security</span>
                            </li>
                            <li class="mb-1 flex"><i
                                    class="mdi mdi-check-circle-outline text-teal-500 text-[20px] align-middle me-2"></i>
                                <span>Free Installment</span>
                            </li>
                        </ul>
                        <a href=""
                            class="h-10 px-6 tracking-wide inline-flex items-center justify-center font-medium rounded-md bg-teal-500 text-white w-full mt-5">Buy
                            Now</a>

                        <p class="text-sm text-slate-400 mt-1.5"><span class="text-red-600">*</span>T&C Apply</p>
                    </div>
                </div><!--end content-->

                <div
                    class="group p-[1px] relative overflow-hidden shadow dark:shadow-gray-700 rounded-md bg-gradient-to-tr from-teal-500 to-indigo-600 h-fit">
                    <div class="p-6 bg-white dark:bg-slate-900 rounded-md">
                        <h6 class="font-semibold mb-5 text-xl">Custom</h6>

                        <p class="text-slate-400 mb-5">Pricing plan will be as per client or company requirements</p>

                        <ul class="list-none">
                            <li class="mb-1 font-medium flex"><i
                                    class="mdi mdi-check-circle-outline text-teal-500 text-[20px] align-middle me-2"></i>
                                <span>Custom Pricing</span>
                            </li>
                        </ul>
                        <a href=""
                            class="h-10 px-6 tracking-wide inline-flex items-center justify-center font-medium rounded-md bg-teal-500/5 hover:bg-teal-500 text-teal-500 hover:text-white w-full mt-5">Talk
                            to us</a>
                    </div>
                </div><!--end content-->
            </div><!--end grid-->
        </div>
    </section> --}}
    <!-- End Pricing -->

    {{-- <!-- Start Blog -->
    <section class="relative md:py-24 py-16" id="blog">
        <div class="container relative">
            <div class="grid grid-cols-1 pb-6 text-center">
                <h3 class="font-semibold text-2xl leading-normal mb-4">Blog or News</h3>

                <p class="text-slate-400 max-w-xl mx-auto">This is just a simple text made for this unique and awesome
                    template, you can replace it with any text.</p>
            </div><!--end grid-->

            <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 mt-6 gap-6">
                <div class="group relative overflow-hidden">
                    <div class="relative overflow-hidden rounded-md shadow dark:shadow-gray-800">
                        <img src="assets/images/blog/01.jpg" class="group-hover:scale-110 duration-500"
                            alt="">
                    </div>

                    <div class="mt-6">
                        <div class="flex mb-4">
                            <span class="flex items-center text-slate-400 text-sm"><i data-feather="calendar"
                                    class="size-4 text-slate-900 dark:text-white me-1.5"></i>20th December, 2023</span>
                            <span class="flex items-center text-slate-400 text-sm ms-3"><i data-feather="clock"
                                    class="size-4 text-slate-900 dark:text-white me-1.5"></i>5 min read</span>
                        </div>

                        <a href=""
                            class="title text-lg font-semibold hover:text-teal-500 duration-500 ease-in-out">Design
                            your apps in your own way</a>
                        <p class="text-slate-400 mt-2">This is required when, for example, the final text is not yet
                            available.</p>

                        <div class="mt-3">
                            <a href="" class="text-teal-500">Read More <i
                                    class="mdi mdi-chevron-right align-middle"></i></a>
                        </div>
                    </div>
                </div><!--end content-->

                <div class="group relative overflow-hidden">
                    <div class="relative overflow-hidden rounded-md shadow dark:shadow-gray-800">
                        <img src="assets/images/blog/02.jpg" class="group-hover:scale-110 duration-500"
                            alt="">
                    </div>

                    <div class="mt-6">
                        <div class="flex mb-4">
                            <span class="flex items-center text-slate-400 text-sm"><i data-feather="calendar"
                                    class="size-4 text-slate-900 dark:text-white me-1.5"></i>20th December, 2023</span>
                            <span class="flex items-center text-slate-400 text-sm ms-3"><i data-feather="clock"
                                    class="size-4 text-slate-900 dark:text-white me-1.5"></i>5 min read</span>
                        </div>

                        <a href=""
                            class="title text-lg font-semibold hover:text-teal-500 duration-500 ease-in-out">How apps
                            is changing the IT world</a>
                        <p class="text-slate-400 mt-2">This is required when, for example, the final text is not yet
                            available.</p>

                        <div class="mt-3">
                            <a href="" class="text-teal-500">Read More <i
                                    class="mdi mdi-chevron-right align-middle"></i></a>
                        </div>
                    </div>
                </div><!--end content-->

                <div class="group relative overflow-hidden">
                    <div class="relative overflow-hidden rounded-md shadow dark:shadow-gray-800">
                        <img src="assets/images/blog/03.jpg" class="group-hover:scale-110 duration-500"
                            alt="">
                    </div>

                    <div class="mt-6">
                        <div class="flex mb-4">
                            <span class="flex items-center text-slate-400 text-sm"><i data-feather="calendar"
                                    class="size-4 text-slate-900 dark:text-white me-1.5"></i>20th December, 2023</span>
                            <span class="flex items-center text-slate-400 text-sm ms-3"><i data-feather="clock"
                                    class="size-4 text-slate-900 dark:text-white me-1.5"></i>5 min read</span>
                        </div>

                        <a href=""
                            class="title text-lg font-semibold hover:text-teal-500 duration-500 ease-in-out">Smartest
                            Applications for Business</a>
                        <p class="text-slate-400 mt-2">This is required when, for example, the final text is not yet
                            available.</p>

                        <div class="mt-3">
                            <a href="" class="text-teal-500">Read More <i
                                    class="mdi mdi-chevron-right align-middle"></i></a>
                        </div>
                    </div>
                </div><!--end content-->
            </div><!--end grid-->
        </div><!--end container-->
    </section><!--end section-->
    <!-- End Blog --> --}}

    {{-- <section class="relative lg:py-24 py-16 bg-slate-50 dark:bg-slate-800" id="contact">
        <div class="container relative">
            <div class="grid grid-cols-1 pb-6 text-center">
                <h3 class="font-semibold text-2xl leading-normal mb-4">CONTÁCTANOS</h3>

                <p class="text-slate-400 max-w-xl mx-auto">This is just a simple text made for this unique and awesome
                    template, you can replace it with any text.</p>
            </div><!--end grid-->

            <div class="grid md:grid-cols-12 grid-cols-1 items-center gap-6">
                <div class="md:col-span-6">
                    <div class="lg:me-8">
                        <div class="relative">
                            <?php $bg_contact = Voyager::setting('site.bg_contact', ''); ?>
                            <img src="{{ Voyager::image($bg_contact) }}"
                                class="rounded-full shadow dark:shadow-gray-700" alt="Logo Icon">
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-5 md:col-span-6">
                    <div class="lg:ms-5">
                        <div class="bg-white dark:bg-slate-900 rounded-md shadow dark:shadow-gray-700 p-6">
                            <form method="post" name="myForm" id="myForm" onsubmit="return validateForm()">
                                <p class="mb-0" id="error-msg"></p>
                                <div id="simple-msg"></div>
                                <div class="grid lg:grid-cols-12 grid-cols-1 gap-3">
                                    <div class="lg:col-span-6">
                                        <label for="name" class="font-semibold">Tu Nombre:</label>
                                        <input name="name" id="name" type="text"
                                            class="mt-2 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-100 dark:border-gray-800 focus:ring-0"
                                            placeholder="Nombre :">
                                    </div>

                                    <div class="lg:col-span-6">
                                        <label for="email" class="font-semibold">Tu Correo:</label>
                                        <input name="email" id="email" type="email"
                                            class="mt-2 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-100 dark:border-gray-800 focus:ring-0"
                                            placeholder="Correo :">
                                    </div>

                                    <div class="lg:col-span-12">
                                        <label for="subject" class="font-semibold">Asunto:</label>
                                        <input name="subject" id="subject"
                                            class="mt-2 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-100 dark:border-gray-800 focus:ring-0"
                                            placeholder="Asunto :">
                                    </div>

                                    <div class="lg:col-span-12">
                                        <label for="comments" class="font-semibold">Mensaje:</label>
                                        <textarea name="comments" id="comments"
                                            class="mt-2 w-full py-2 px-3 h-28 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-100 dark:border-gray-800 focus:ring-0"
                                            placeholder="Mensaje :"></textarea>
                                    </div>
                                </div>
                                <button type="submit" id="submit" name="send"
                                    class="h-10 px-6 tracking-wide inline-flex items-center justify-center font-medium rounded-md bg-teal-500 text-white mt-2">Enviar
                                    Mensaje</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--end container-->
    </section> --}}

    <!-- Footer Start -->
    <footer class="footer bg-dark-footer relative text-gray-200 dark:text-gray-200">
        <div class="py-[30px] px-0 border-t border-slate-800">
            <div class="container relative text-center">
                <div class="grid lg:grid-cols-12 md:grid-cols-3 grid-cols-1 items-center">
                    <div class="lg:col-span-3 md:text-start text-center">
                        <?php $admin_logo_img = Voyager::setting('admin.icon_image', ''); ?>
                        <img src="{{ Voyager::image($admin_logo_img) }}" style="height:50px!important;"
                            class="mx-auto md:me-auto md:ms-0" alt="Logo Icon">
                    </div>

                    <div class="lg:col-span-5 text-center mt-6 md:mt-0">
                        <p class="mb-0">©
                            <script>
                                document.write(new Date().getFullYear())
                            </script> Fedetiro. Hecho con <i class="mdi mdi-heart text-red-600"></i> por
                            <a href="https://armorumsgdea.net" target="_blank" class="text-reset">ARMORUM VU-SGDEA
                                ®</a>
                        </p>
                    </div>

                    <ul class="lg:col-span-4 list-none md:text-end text-center mt-6 md:mt-0">
                        <li class="inline"><a href="https://www.facebook.com/Fedetirocol?mibextid=ibOpuV"
                                target="_blank"
                                class="size-8 inline-flex justify-center items-center border border-gray-800 rounded-md hover:border-teal-500 dark:hover:border-teal-500 hover:bg-teal-500 dark:hover:bg-teal-500"><i
                                    data-feather="facebook" class="size-4 align-middle" title="facebook"></i></a>
                        </li>
                        <li class="inline"><a href="https://www.instagram.com/fedetirocol/" target="_blank"
                                class="size-8 inline-flex justify-center items-center border border-gray-800 rounded-md hover:border-teal-500 dark:hover:border-teal-500 hover:bg-teal-500 dark:hover:bg-teal-500"><i
                                    data-feather="instagram" class="size-4 align-middle" title="instagram"></i></a>
                        </li>
                        <li class="inline"><a href="https://x.com/fedetirocol?s=21" target="_blank"
                                class="size-8 inline-flex justify-center items-center border border-gray-800 rounded-md hover:border-teal-500 dark:hover:border-teal-500 hover:bg-teal-500 dark:hover:bg-teal-500"><i
                                    data-feather="twitter" class="size-4 align-middle" title="twitter"></i></a></li>
                        <li class="inline"><a href="https://www.youtube.com/@eventosfedetiro" target="_blank"
                                class="size-8 inline-flex justify-center items-center border border-gray-800 rounded-md hover:border-teal-500 dark:hover:border-teal-500 hover:bg-teal-500 dark:hover:bg-teal-500"><i
                                    data-feather="youtube" class="size-4 align-middle" title="youtube"></i></a></li>
                        <li class="inline"><a href="mailto:info@fedetirocol.com"
                                class="size-8 inline-flex justify-center items-center border border-gray-800 rounded-md hover:border-teal-500 dark:hover:border-teal-500 hover:bg-teal-500 dark:hover:bg-teal-500"><i
                                    data-feather="mail" class="size-4 align-middle" title="email"></i></a></li>
                    </ul><!--end icon-->
                </div><!--end grid-->
            </div><!--end container-->
        </div>
    </footer><!--end footer-->
    <!-- Footer End -->

    <!-- Back to top -->
    <a href="#" onclick="topFunction()" id="back-to-top"
        class="back-to-top fixed hidden text-lg rounded-full z-10 bottom-5 right-5 size-9 text-center bg-teal-500 text-white leading-9"><i
            class="mdi mdi-arrow-up"></i></a>
    <!-- Back to top -->

    <!-- Switcher -->
    <div class="fixed top-1/4 -right-1 z-3">
        <span class="relative inline-block rotate-90">
            <input type="checkbox" class="checkbox opacity-0 absolute" id="chk">
            <label
                class="label bg-slate-900 dark:bg-white shadow dark:shadow-gray-800 cursor-pointer rounded-full flex justify-between items-center p-1 w-14 h-8"
                for="chk">
                <i data-feather="moon" class="w-[18px] h-[18px] text-yellow-500"></i>
                <i data-feather="sun" class="w-[18px] h-[18px] text-yellow-500"></i>
                <span class="ball bg-white dark:bg-slate-900 rounded-full absolute top-[2px] left-[2px] size-7"></span>
            </label>
        </span>
    </div>
    <!-- Switcher -->

    <!-- LTR & RTL Mode Code -->
    <div class="fixed top-[40%] -right-3 z-50">
        <a href="" id="switchRtl">
            <span
                class="py-1 px-3 relative inline-block rounded-t-md -rotate-90 bg-white dark:bg-slate-900 shadow-md dark:shadow dark:shadow-gray-800 font-medium rtl:block ltr:hidden">LTR</span>
            <span
                class="py-1 px-3 relative inline-block rounded-t-md -rotate-90 bg-white dark:bg-slate-900 shadow-md dark:shadow dark:shadow-gray-800 font-medium ltr:block rtl:hidden">RTL</span>
        </a>
    </div>
    <!-- LTR & RTL Mode Code -->

    <!-- JAVASCRIPTS -->
    <script src="assets/libs/swiper/js/swiper.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>
    <script src="assets/libs/gumshoejs/gumshoe.polyfills.min.js"></script>
    <script src="assets/libs/tobii/js/tobii.min.js"></script>
    <script src="assets/libs/tiny-slider/min/tiny-slider.js"></script>
    <script src="assets/js/plugins.init.js"></script>
    <script src="assets/js/app.js"></script>
    <!-- JAVASCRIPTS -->
</body>

</html>
