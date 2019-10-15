<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel=icon href="/favicon.ico" type="image/x-icon">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Expose named route functionality to vue components/js --}}
    <script>
        window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
                'baseUrl' => url('/'),
                'routes' => collect(\Route::getRoutes())->mapWithKeys(function ($route) { return [$route->getName() => $route->uri()]; })
            ]) !!};
    </script>

    {{-- end --}}

    <title>@yield('title') | Henson Franklyn</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="auth-page">
    <v-app id="app">
        <div class="full-screen-bg">
            <img id="background_img" src="{{asset('img/auth/background.jpg')}}">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 col-md-6 mx-auto auth-container">
                        <div class="text-center">
                            <img id="logo" src="{{asset('img/logo.svg')}}">
                        </div>
                        @yield('content')
                    </div>
                </div>
            </div>
            <div class="footer-block">
                <img id="footer_icons" src="{{asset('img/auth/footer-icons.png')}}">
                <img id="formation_footer" src="{{asset('img/auth/by-formation.svg')}}">
            </div>
        </div>
    </v-app>
</body>
</html>
