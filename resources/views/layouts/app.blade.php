<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <meta name="description" content="Collaborative Filtering Admin">
    <meta name="author" content="Fauzi Ferdiansyah">
    <meta name="robots" content="noindex, nofollow">

    <!-- END FavIcon -->
    <!-- Load Font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400" rel="stylesheet">
    <!-- END Load Fonts -->
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @if(View::hasSection('title_web'))
            {{ config('app.name') }} - @yield('title_web')
        @else
            {{ config('app.name') }}
        @endif
    </title>
    <!-- Stylesheets -->

    <link href="{{ asset('css/bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css" />
    <!-- END Stylesheets -->
    @yield('css')

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

</head>
<body  class="horizontal-navigation">
    <!-- begin::preloader-->
    <div class="preloader">
        <div class="preloader-icon"></div>
    </div>
    <!-- begin::main -->
    <div class="layout-wrapper">
        <!-- end::preloader -->
        @include('includes.header')
        <div class="content-wrapper">
            @include('includes.navigation')
            <div class="content-body">
                <div class="content">
                    {{-- Main Content --}}
                    @yield('content')
                    {{-- END Main Content --}} 
                </div>
                @include('includes.footer')
            </div>
        </div>
    </div>
    <!-- end::main -->
    <!-- Javascript -->
    <script src="{{ asset('js/bundle.js') }}" ></script>

    @yield('scripts')
    @stack('scripts')
    
    <script src="{{ asset('js/app.min.js') }}" ></script>
    <!-- END Javascript -->

    

</body>
</html>
