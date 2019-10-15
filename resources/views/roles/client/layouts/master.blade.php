<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel=icon href="/favicon.ico" type="image/x-icon">
        <title>@yield('title') | Henson Franklyn</title>

        {{-- Expose named route functionality to vue components/js --}}
        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
                'baseUrl' => url('/'),
                'routes' => collect(\Route::getRoutes())->mapWithKeys(function ($route) { return [$route->getName() => $route->uri()]; })
            ]) !!};
        </script>

        {{-- end --}}

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        @yield('stylesheets')
    </head>
    <body>
        <nav class="pushy pushy-left">
            <div class="pushy-content">
                <nav class="mobile-nav">
                    @include('roles.client.layouts.nav')
                </nav>
            </div>
        </nav>
        <div class="site-overlay"></div>
        <div id="container">
            <div id="app">
                <nav class="vertical">
                    @include('roles.client.layouts.nav')
                </nav>
                <header>
                    <i id="mobile_nav_trigger" class="menu-btn fas fa-bars"></i>
                    <div id="actions">
                        <div id="user_icon_container">
                            <div id="user_icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <a id="logout" href="{{ url('/logout') }}">Logout</a>
                        </div>
                    </div>
                </header>

                <main class="py-4">
                    <div class="container-fluid">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (isset($success))
                            <div class="alert alert-success">
                                {{$success}}
                            </div>
                        @endif
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>
        <script src="{{ asset('js/tinymce.js') }}" defer></script>
        <script src="{{ asset('js/app.js') }}" defer></script>
        @yield('scripts')
    </body>
</html>
