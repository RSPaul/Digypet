<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
    <link href="{{asset('css/sweetalert.css')}}" type="text/css" rel="stylesheet" />

    <base href="/">
</head>
<body ng-app="providerApp">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->first_name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('provider_profile') }}">
                                        Profile
                                    </a>
                                    <a class="dropdown-item" href="{{ route('provider_bookings') }}">
                                        Bookings
                                    </a>
                                    <a class="dropdown-item" href="{{ route('provider_services') }}">
                                        Services
                                    </a>
                                    <a class="dropdown-item" href="{{ route('provider_payments') }}">
                                        Payment
                                    </a>
                                    <a class="dropdown-item" href="{{ route('provider_messages') }}">
                                        Messages
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap core JavaScript -->
    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->
    
    <script src="{{ asset('vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('js/jquery-ui.js')}}"></script>

    <script src="{{asset('js/sweetalert.min.js')}}"></script>

    <script src="{{asset('js/angular/libs/angular.min.js')}}"></script>
    <script src="{{asset('js/angular/libs/angular-sanitize.js')}}"></script>
    <script src="{{asset('js/angular/libs/angular-route.js')}}"></script>
    <script src="{{asset('js/angular/libs/angular-cookies.js')}}"></script>
    <script src="{{asset('js/angular/apps/provider-app.js')}}"></script>
    <script src="{{asset('js/angular/libs/dirPagination.js')}}"></script>
    <script src="{{asset('js/angular/controllers/provider/profileCtrl.js')}}"></script>
    <script src="{{asset('js/angular/controllers/provider/dashboardCtrl.js')}}"></script>
    <script src="{{asset('js/angular/controllers/provider/servicesCtrl.js')}}"></script>
</body>
</html>
