<!DOCTYPE html>
<html lang="nl">
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
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">
    <title>@yield('title', 'Starfish') | Starfish</title>
    @section('styles')
        <link rel="stylesheet" type="text/css" href="{{asset('css/admin.css')}}"/>
        <link rel="stylesheet" type="text/css" href="{{asset('css/jquery-ui.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('css/font-awesome.css')}}">
    @show
</head>
<body>

<div id="topbar">
    <div class="topname">
        <h2>Admin Panel</h2>
    </div>
    <ul class="usercontrol">
        <li>
                <a href="{{route('admin.messages.index')}}">
                    <i class="fa fa-envelope fa-2x fa-inverse"></i>
                </a>
        </li>
        <li><a href="#"><i class="fa fa-question-circle fa-2x" aria-hidden="true"></i></a></li>
        <li><a href="{{route('admin.admin')}}"><i class="fa fa-home fa-2x" aria-hidden="true"></i></a></li>
        <li class="droptoggle">
            <a href="#">{{auth()->user()->username}}    <i class="fa fa-caret-down" aria-hidden="true"></i> </a>
        </li>
    </ul>
</div>
<div id="maincontent">
    <ul class="usermenu">
        <li><a href="{{route("admin.umgmt.show", auth()->user()->id)}}"><i class="fa fa-user" aria-hidden="true"></i>Account</a> </li>
        <li><a href="{{route("admin.usettings")}}"><i class="fa fa-sliders" aria-hidden="true"></i>Instellingen</a> </li>
        <li><a href="{{route("logout")}}"><i class="fa fa-sign-out" aria-hidden="true"></i>Uitloggen</a> </li>
    </ul>
    <ul id="sidenav">
        @if(Auth::user()->hasAccess('admin.specialists.index'))
        <li data-name="specialisten"><a href="{{route('admin.specialists.index')}}"><i class="fa fa-user-md fa-2x" aria-hidden="true"></i>Specialisten</a></li>
        @endif
        @if(Auth::user()->hasAccess('admin.specialisms.index'))
        <li data-name="Specialismes"><a href="{{route('admin.specialisms.index')}}"><i class="fa fa-check-square-o fa-2x" aria-hidden="true"></i>Werkgebieden</a></li>
        @endif
        @if(Auth::user()->hasAccess('admin.complaints.index'))
        <li data-name="Klachten"><a href="{{route('admin.complaints.index')}}"><i class="fa fa-universal-access fa-2x" aria-hidden="true"></i>Klachten</a></li>
        @endif
        @if(Auth::user()->hasAccess('admin.therapies.index'))
        <li data-name="Therapieen"><a href="{{route('admin.therapies.index')}}"><i class="fa fa-heartbeat fa-2x" aria-hidden="true"></i>Therapieen</a></li>
        @endif
        {{--@if(Auth::user()->hasAccess('admin.diverse.index'))--}}
        {{--<li data-name="Diversen"><a href="{{route('admin.diverse.index')}}"><i class="fa fa-file fa-2x" aria-hidden="true"></i>Diversen</a></li>--}}
        {{--@endif--}}
        @if(Auth::user()->hasAccess('admin.umgmt.index'))
        <li data-name="Gebruikers"><a href="{{route('admin.umgmt.index')}}"><i class="fa fa-users fa-2x" aria-hidden="true"></i>Gebruikers</a></li>
        @endif
        @if(Auth::user()->hasAccess('admin.stats.index'))
        <li data-name="Statistieken"><a href="{{route('admin.stats.index')}}"><i class="fa fa-bar-chart fa-2x" aria-hidden="true"></i>Statistieken</a></li>
        @endif
        @if(Auth::user()->hasAccess('admin.logs.index'))
        <li data-name="Logs"><a href="{{route('admin.logs.index')}}"><i class="fa fa-newspaper-o fa-2x" aria-hidden="true"></i> Logs</a></li>
        @endif
        @if(Auth::user()->hasAccess('admin.tasks.index'))
            <li data-name="Taken"><a href="{{route('admin.tasks.index')}}"><i class="fa fa-tasks fa-2x" aria-hidden="true"></i> Taken</a></li>
        @endif
        @if(Auth::user()->hasAccess('admin.webmaster.index'))
            <li data-name="Webmaster"><a href="{{route('admin.webmaster.index')}}"><i class="fa fa-server fa-2x" aria-hidden="true"></i>Webmaster</a></li>
        @endif
    </ul>
    <div id="content">
        <h2  class="ctitle">@yield("title")</h2>
        @if (\Session::has('error'))
            <div class="col-md-3" id="msg">
                <div class="msg msg-danger msg-danger-background text-white">
                    <span class="glyphicon glyphicon glyphicon-ok"></span>
                    {!! \Session::get('error') !!}
                    <i class="fa fa-close" style="float: right" aria-hidden="true" onclick="return $('#msg').remove()"></i>
                </div>
            </div>
        @endif
        <hr class="htitle">
        <div id="ufunctions">
         @yield('main')
        </div>
    </div>
</div>
@section('scripts')
    <script type="text/javascript" src="{{asset('js/cookie_handler.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery-ui.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/admin.js')}}"></script>
    @show
</body>
</html>
