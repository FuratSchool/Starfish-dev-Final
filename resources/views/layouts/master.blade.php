<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="author" content="Jim en Valliant"/>
    <meta name="description" content="Starfish"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:url"           content="{{Request::url()}}" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="My Starfish" />
    <meta property="og:description"   content="My starfish is een platform voor alternative geneeswijze" />
    <meta property="og:image"         content="{{asset("images/logo.png")}}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}" />
    <title>@yield('title', 'Starfish') | Starfish</title>
    @section('styles')
        <link rel="stylesheet" type="text/css" href="{{asset('css/master.css')}}"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/footer.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.css')}}">
    @show
</head>
<body>
<div class="col-md-12"><a role="button" class="btn btn-success col-md-12" href="{{route('admin.admin')}}">ADMIN</a></div>

<div class="container">
    <div class="row">
        <img src="{{asset('images/logo.png')}}" class="toplogo">
    </div>
    <!-- AddToAny BEGIN -->
    <div class="a2a_kit a2a_kit_size_32 a2a_floating_style a2a_vertical_style" style="left:0; top:150px;">
        <a class="a2a_button_facebook"></a>
        <a class="a2a_button_twitter"></a>
        <a class="a2a_button_google_plus"></a>
        <a class="a2a_button_whatsapp"></a>
        <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
    </div>
    <script async src="https://static.addtoany.com/menu/page.js"></script>
    <!-- AddToAny END -->
    @yield('main')
</div>
<div class="container">
@include('layouts.footer')
</div>
@section('scripts')
    <script src="{{asset('js/cookie_handler.js')}}"></script>
    <script src="{{asset('js/jquery-3.2.2.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.js')}}"></script>
@show
</body>
</html>