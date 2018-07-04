@extends('base')
@section('styles')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('css/addSpecialist.css') }}"/>
@endsection

@section('main')
    <div class="col-xs-12">
        <form action="{{ route('admin.user.update', ['id' => $user->id]) }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="form_isAdmin">Admin</label>
                <input type="checkbox" name="is_admin" id="form_isAdmin" {{ $user->is_admin ? 'checked' : '' }} value="{{ old('is_admin', $user->is_admin) }}"/>
            </div>
            <div class="form-group">
                <label for="form_isActive">Actief</label>
                <input type="checkbox" name="is_active" id="form_isActive" {{ $user->is_active ? 'checked' : '' }} value="{{ old('is_active', $user->is_active) }}"/>
            </div>
            <div class="form-group @if($errors->has('first_name')) has-error @endif">
                <label for="form_firstName">Voornaam</label>
                <input class="form-control" type="text" name="first_name" id="form_firstName" value="{{ old('first_name', $user->first_name) }}"/>
                @if($errors->has('first_name')) <p class="help-block">{{ $errors->first('first_name') }}</p> @endif
            </div>
            <div class="form-group @if($errors->has('sur_name')) has-error @endif">
                <label for="form_surName">Achternaam</label>
                <input class="form-control" type="text" name="sur_name" id="form_surName" value="{{ old('sur_name', $user->sur_name) }}"/>
                @if($errors->has('sur_name')) <p class="help-block">{{ $errors->first('sur_name') }}</p> @endif
            </div>
            <div class="form-group @if($errors->has('username')) has-error @endif">
                <label for="form_username">Gebruikersnaam</label>
                <input class="form-control" type="text" name="username" id="form_username" value="{{ old('username', $user->username) }}"/>
                @if($errors->has('username')) <p class="help-block">{{ $errors->first('username') }}</p> @endif
            </div>
            <div class="form-group @if($errors->has('password')) has-error @endif">
                <label for="form_password">Wachtwoord (Laat leeg als u deze niet wilt aanpassen)</label>
                <input class="form-control" type="password" name="password" id="form_password" value="{{ old('password') }}"/>
                @if($errors->has('password')) <p class="help-block">{{ $errors->first('password') }}</p> @endif
            </div>
            <div class="form-group @if($errors->has('email')) has-error @endif">
                <label for="form_email">Email</label>
                <input class="form-control" type="email" name="email" id="form_email" value="{{ old('email', $user->email) }}"/>
                @if($errors->has('email')) <p class="help-block">{{ $errors->first('email') }}</p> @endif
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-success" value="Aanpassen!"/>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    @parent
    <script type="text/javascript">
        $('#form_isActive, #form_isAdmin').on('change', function(){
           var val = this.checked ? 1 : 0;

            $('#form_isActive').val(val);
            $('#form_isAdmin').val(val);
        });
    </script>
@endsection