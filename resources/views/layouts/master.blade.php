<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="author" content="Jim en Valliant"/>
    <meta name="description" content="Starfish"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:url" content="{{Request::url()}}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="My Starfish"/>
    <meta property="og:description" content="My starfish is een platform voor alternative geneeswijze"/>
    <meta property="og:image" content="{{asset("images/logo.png")}}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}"/>
    <title>@yield('title', 'Starfish') | Starfish</title>
    @section('styles')
        <link rel="stylesheet" type="text/css" href="{{asset('css/starfish.css')}}"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/footer.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.css')}}">
    @show
</head>
<body>

<header>
    <nav class="navbar main-navigation bg-white text-dark">
        <div class="justify-content-start">
            <img src="{{asset('images/Starfish-logo-zonder-text.png')}}" width="50px">
            <h2 class="Starfish-Logo-with-text Roboto-light">Starfish</h2>
        </div>
        <ul class="nav justify-content-center nav-spacing">
            <li class="nav-item nav-item-color">
                <a class="nav-link" href="{{route('landing')}}">Home</a>
            </li>
            <li class="nav-item nav-item-color">
                <a class="nav-link " href="{{route('health')}}">Health</a>
            </li>
            <li class="nav-item nav-item-color">
                <a class="nav-link" href="{{route('philosophy')}}">Philosophy</a>
            </li>
            <li class="nav-item nav-item-color">
                <a class="nav-link" href="{{route('complaints')}}">Imbalance</a>
            </li>
            <li class="nav-item nav-item-color">
                <a class="nav-link" href="{{route('treatments')}}">Treatments</a>
            </li>

            <li class="nav-item dropdown nav-item-color">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Other
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Kids</a>
                    <a class="dropdown-item" href="#">Pets</a>
                    <a class="dropdown-item" href="#">Webshop</a>
                    <a class="dropdown-item" href="#">Contact</a>
                </div>
            </li>
        </ul>
        <ul class="nav justify-content-end">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        </ul>
    </nav>
</header>

@yield('main')
@include('layouts.footer')
@section('scripts')
    <script src="{{asset('js/cookie_handler.js')}}"></script>
    <script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('js/bootstrap3.7.js')}}"></script>
@show
</body>
</html>