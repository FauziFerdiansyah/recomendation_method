<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <meta name="description" content="Mimi Resto Admin">
    <meta name="author" content="Asvicode">
    <meta name="robots" content="noindex, nofollow">

    <!-- FavIcons -->
    
    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('img/fav.png') }}" /> 
    <!-- END FavIcons -->

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @if(View::hasSection('title_web'))
            @yield('title_web')
        @else
            {{ config('app.name') }}
        @endif
    </title>
    <!-- Stylesheets -->
        <!-- Plugin styles -->
        <link rel="stylesheet" href="{{ asset('css/bundle.css') }}" type="text/css">
        <!-- App styles -->
        <link rel="stylesheet" href="{{ asset('css/app.min.css') }}" type="text/css">
    <!-- END Stylesheets -->
    @yield('css')

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

</head>
<body class="form-membership">
    {{-- Main Content --}}
    @yield('content')
    {{-- END Main Content --}}
    <!-- Javascript -->
    <script src="{{ asset('js/bundle.js') }}" ></script>
    <script src="{{ asset('js/app.min.js') }}" ></script>
    <!-- END Javascript -->

    @yield('scripts')
    @stack('scripts')

</body>
</html>
