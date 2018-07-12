<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="description" content="Starfish - Home"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Starfish') | Starfish</title>

    @section('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/footer.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{asset("css/bootstrap.css")}}">
    @show

    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}" />
</head>
<body>
<div class="col-md-12"><a role="button" class="btn btn-success col-md-12" href="{{route('admin.admin')}}">ADMIN</a></div>

@yield('body')
@section('scripts')
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="{{asset('js/cookie_handler.js')}}"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
@show
@include('layouts.footer')
</body>
</html>