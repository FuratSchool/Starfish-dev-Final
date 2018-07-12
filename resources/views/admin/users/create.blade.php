@extends('layouts.admin')
@section('title')
    Nieuwe Gebruiker
@endsection
@section('main')
    <div class="cbox-fluid">
        <div class="btitle">Nieuwe Gebruiker</div>
        <hr class="bdivider">
        <div class="bcontent">
            <form class="form-horizontal " role="form" method="POST" action="{{ route('admin.umgmt.store') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('username') ? ' has-error has-feedback' : '' }}">
                    <label for="username" class="col-md-4 control-label">Gebruikersnaam</label>
                    <div class="col-md-6">
                        <input id="username" type="text" class="form-control" name="username"  value="{{old('username')}}" autofocus>
                        @if ($errors->has('username'))
                            <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                            <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('email') ? ' has-error has-feedback' : '' }}">
                    <label for="email" class="col-md-4 control-label">E-Mail</label>
                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email"  value="{{old('email')}}">
                        @if ($errors->has('email'))
                            <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error has-feedback' : '' }}">
                    <label for="password" class="col-md-4 control-label">Wachtwoord</label>
                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="password" >
                        @if ($errors->has('password'))
                            <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="password_confirmation" class="col-md-4 control-label">Bevestig wachtwoord</label>
                    <div class="col-md-6">
                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" >
                    </div>
                </div>
                <div class="form-group @if($errors->has('first_name') || $errors->has('sur_name')) has-error has-feedback @endif">
                    <label for="first_name" class="col-md-4 control-label">Voor-, tussenvoegsel en achternaam</label>
                    <div class="col-md-2">
                        <input id="first_name" type="text" class="form-control" name="first_name"  placeholder=" Voornaam"value="{{old('first_name')}}">
                        @if ($errors->has('first_name'))
                            <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                        @endif
                    </div>
                    <div class="col-md-2">
                        <input id="adverb" type="text" class="form-control" name="adverb"  placeholder="Tussenvoegsel" value="{{old('adverb')}}">
                        @if ($errors->has('adverb'))
                            <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                        @endif
                    </div>
                    <div class="col-md-2">
                        <input id="sur_name" type="text" class="form-control" name="sur_name"  placeholder="Achternaam" value="{{old('last_name')}}">
                        @if ($errors->has('sur_name'))
                            <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                        @endif
                    </div>
                    @if ($errors->has('first_name'))
                        <span class="help-block">
                            <strong>{{$errors->first('first_name')}}</strong>
                        </span>
                  @elseif($errors->has('adverb'))
                        <span class="help-block">
                            <strong>{{$errors->first('adverb')}}</strong>
                        </span>

                    @elseif($errors->has('sur_name'))
                        <span class="help-block">
                            <strong>{{$errors->first('sur_name')}}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('is_admin') ? 'has-error has-feedback' : '' }}">
                    <label for="is_admin" class="col-md-4 control-label">Rol</label>
                        <div class="col-md-6">
                            <select id="is_admin" class="form-control" name="is_admin">
                                <option value="1" @if(old('is_admin') == '1')selected @endif>Standaard</option>
                                <option value="2" @if(old('is_admin') == '2')selected @endif>Mod</option>
                                <option value="3" @if(old('is_admin') == '3')selected @endif>Admin</option>
                                <option value="4" @if(old('is_admin') == '4')selected @endif>Webmaster</option>
                            </select>
                            @if($errors->has('is_admin'))
                                <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                                <span class="help-block">
                                     <strong>{{$errors->first('is_admin')}}</strong>
                               </span>
                            @endif
                        </div>
                </div>
                <div class="form-group{{ $errors->has('notice') ? ' has-error has-feedback' : '' }}">
                    <label for="notice" class="col-md-4 control-label">Opmerking</label>
                    <div class="col-md-6">
                        <input id="notice" type="text" class="form-control" name="notice"  value="{{old('notice')}}" autofocus>
                        @if ($errors->has('notice'))
                            <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                            <span class="help-block">
                                        <strong>{{ $errors->first('notice') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <button type="submit" class="btn btn-new col-md-push-4 col-md-6">Registreren</button>
            </form>
        </div>
    </div>
@endsection