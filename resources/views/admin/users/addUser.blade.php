@extends('base')


@section('styles')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('css/addSpecialist.css') }}"/>
@endsection

@section('main')
<div class="col-xs-12">
        <form action="{{ route('admin.user.add') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="form_isAdmin">Admin</label>
                <input type="checkbox" name="is_admin" id="form_isAdmin"  value="{{ old('is_admin', '1') }}"/>
            </div>
            <div class="form-group">
                <label for="form_isActive">Actief</label>
                <input type="checkbox" name="is_active" id="form_isActive" checked value="{{ old('is_active', '1') }}"/>
            </div>
            <div class="form-group @if($errors->has('first_name')) has-error @endif">
                <label for="form_firstName">Voornaam</label>
                <input class="form-control" type="text" name="first_name" id="form_firstName" value="{{ old('first_name') }}"/>
                @if($errors->has('first_name')) <p class="help-block">{{ $errors->first('first_name') }}</p> @endif
            </div>
            <div class="form-group @if($errors->has('sur_name')) has-error @endif">
                <label for="form_surName">Achternaam</label>
                <input class="form-control" type="text" name="sur_name" id="form_surName" value="{{ old('sur_name') }}"/>
                @if($errors->has('sur_name')) <p class="help-block">{{ $errors->first('sur_name') }}</p> @endif
            </div>
            <div class="form-group @if($errors->has('username')) has-error @endif">
                <label for="form_username">Gebruikersnaam</label>
                <input class="form-control" type="text" name="username" id="form_username" value="{{ old('username') }}"/>
                @if($errors->has('username')) <p class="help-block">{{ $errors->first('username') }}</p> @endif
            </div>
            <div class="form-group @if($errors->has('password')) has-error @endif">
                <label for="form_password">Wachtwoord</label>
                <input class="form-control" type="password" name="password" id="form_password" value="{{ old('password') }}"/>
                @if($errors->has('password')) <p class="help-block">{{ $errors->first('password') }}</p> @endif
            </div>
            <div class="form-group @if($errors->has('email')) has-error @endif">
                <label for="form_email">Email</label>
                <input class="form-control" type="email" name="email" id="form_email" value="{{ old('email') }}"/>
                @if($errors->has('email')) <p class="help-block">{{ $errors->first('email') }}</p> @endif
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-success" value="Opslaan!"/>
            </div>
        </form>
    </div>
@endsection