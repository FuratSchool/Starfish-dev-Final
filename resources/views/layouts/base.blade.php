<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
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
        <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.css')}}">
    @show
</head>
<body>

<div class="col-md-12"><a role="button" class="btn btn-success col-md-12" href="{{route('admin.admin')}}">ADMIN</a>
</div>

    @yield('main')
@include('layouts.footer')
</body>
</html>