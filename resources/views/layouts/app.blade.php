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
      <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.ico')}}">
      <!-- Bootstrap core CSS -->
      <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
      <!-- Custom fonts for this template -->
      <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,700;0,800;0,900;1,600&display=swap" rel="stylesheet">
      <!-- Custom styles for this template -->
      <link href="{{ asset('css/style-digy.css')}}" rel="stylesheet">
   </head>
   <body>
      <nav class="navbar navbar-expand-lg navbar-dark py-lg-4" id="mainNav">
         <div class="container">
            <a class="navbar-brand" href="#"><img src="img/logo-main.png"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
               <a class="navbar-logo" href="#"><img src="img/logo-main.png"></a>
               <ul class="navbar-nav ml-auto">
                  <li class="nav-item active px-lg-4">
                     <a class="nav-link text-uppercase text-expanded" href="#">Become a Service Provider
                     <span class="sr-only">(current)</span>
                     </a>
                  </li>
                  <li class="nav-item px-lg-4">
                     <a class="nav-link text-uppercase text-expanded" href="#">Our Services</a>
                  </li>
                  @guest
                  <li class="nav-item px-lg-2">
                     <a class="nav-link text-uppercase text-expanded btn btn-secondary signbtn" href="/register">Sign up</a>
                  </li>
                  <li class="nav-item px-lg-2">
                     <a class="nav-link text-uppercase text-expanded btn btn-primary loginbtn" href="/login">Login</a>
                  </li>
                  @else
                  <li class="nav-item dropdown">
                     <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                     {{ Auth::user()->first_name }} <span class="caret"></span>
                     </a>
                     <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
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
      @yield('content')
      <footer class="footer text-white text-center py-5">
         <div class="container mb-3">
            <div class="row m-0">
               <div class="col-lg-4 col-md-12 col-xs-12 fotlogo">
                  <a href="#"><img src="{{ asset('img/mainlogo.png')}}"></a>
               </div>
               <div class="col-lg-4 col-md-12 col-xs-12">
                  <ul class="fotlist">
                     <li><a href="#">Become a service provider</a></li>
                     <li><a href="#">Our services</a></li>
                  </ul>
               </div>
               <div class="col-lg-4 col-md-12 col-xs-12 sociallink">
                  <ul class="">
                     <li><a href="#" class="facebook"></a></li>
                     <li><a href="#" class="insta"></a></li>
                  </ul>
               </div>
            </div>
         </div>
         <div class="container">
            <div class="row m-0">
               <div class="col-lg-12">
                  <p class="m-0 small">&copy; 2020 A Place for Rover, Inc. All Rights Reserved.</p>
               </div>
            </div>
         </div>
      </footer>
      <!-- Bootstrap core JavaScript -->
      <script src="vendor/jquery/jquery.min.js"></script>
      <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
   </body>
</html>