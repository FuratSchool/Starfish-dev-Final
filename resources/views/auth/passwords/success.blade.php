@extends('layouts.master')
@section('styles')
    @parent
@endsection
@section('title')
    Wachtwoord gewijzigd
@endsection
@section('main')
    <div class="col-lg-offset-3 col-lg-6 ">
        <div class="panel panel-default">
            <div class="panel-heading">Wachtwoord gewijzigd</div>
            <div class="panel-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <h2>Wachtwoord gewijzigd </h2>
                <p>
                   Uw wachtwoord is succescol gewijzigd, u kunt nu weer inloggen via onderstaande knop
                </p>
                <a href="{{route('login')}}" class="btn btn-lg btn-primary">Naar inlog pagina</a>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
@endsection