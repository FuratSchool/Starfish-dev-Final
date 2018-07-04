@extends('frame')

@section('styles')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('css/core.css') }}"/>
@endsection

@section('body')
    <div class="background"></div>
    <header>
        <div class="hidden-xs"><!-- Desktop friendly -->
            <a href="@yield('home_url', route('landing'))"><img class="site-logo" src="{{ asset('/images/logo.png') }}"/></a>
            <div class="container site-nav">
                <nav class="col-xs-11 col-xs-offset-1 col-md-offset-1 col-md-11">
                    <a href="#">Klacht</a>
                    <a href="{{ route('listSpecialists') }}">Specialisten</a> <!-- Add route after specialists is created -->
                    <a href="#">Contact</a>
                    @if(Auth::check())
                        <span style="color:  white; z-index: 5"> Hoi {{auth()->user()->username}} </span>
                    @endif
                </nav>
            </div>
        </div>
        <div class="visible-xs"> <!-- Mobile friendly -->
            <nav class="navbar navbar-default">
                <a class="navbar-brand" href="/"><img class="site-logo" src="{{ asset('/images/logo.png') }}"/></a>
                <div class="pull-right">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-menu" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
            </nav>
        </div>
    </header>
    <main class="row">
        <div class="background-overlay"></div>
        <div class="row">
            <div class="col-xs-12">
                <ol class="breadcrumb">
                </ol>
            </div>
        </div>
        @yield('main')
    </main>
    <div class="footer-spacer">&nbsp;</div>
@endsection