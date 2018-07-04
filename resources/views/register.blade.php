@extends('layouts.master')
@section('title', 'Registreren')
@section('main')
        <div class="col-lg-8 col-lg-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{!! Breadcrumbs::Render('register')!!}</div>
                <div class="panel-body">
                    @include('layouts.errors')
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="username" class="col-md-4 control-label">Gebruikersnaam</label>
                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control" name="username"  required autofocus>
                                <p class="help-block">Minimaal 3 en maximaal 32 tekens</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email"  required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Wachtwoord</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password"  required>
                                <p class="help-block">Minimaal 8 tekens, moet minimaal 1 letter, 1 hoofdletter en 1 cijfer bevatten</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation" class="col-md-4 control-label">Bevestig wachtwoord</label>
                            <div class="col-md-6">
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation"  required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="first_name" class="col-md-4 control-label">Voor- en achternaam</label>
                            <div class="col-md-2">
                                <input id="first_name" type="text" class="form-control" name="first_name"  placeholder=" Voornaam" required>
                            </div>
                            <div class="  col-md-2">
                                <input id="sur_name" type="text" class="form-control" name="sur_name"  placeholder="Achternaam" required>
                            </div>
                        </div>
                            <button type="submit" class="btn btn-danger col-md-push-4 col-md-6">Registreren</button>
                        </div>
                        </div>
                    </form>
                </div>
            </div>

@endsection
