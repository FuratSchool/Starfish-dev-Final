@extends('layouts.admin')
@section('styles')
    @parent
@endsection
@section('title')
    Instellingen voor {{Auth()->user()->username}}
    @endsection
@section('main')
    <div class="cbox-fluid">
        <div class="btitle">Wachtwoord wijzigen</div>
        <hr class="bdivider">
        <div class="bcontent">
            @if (\Session::has('error'))
                <div class="msg msg-danger"> <span class="glyphicon glyphicon glyphicon-remove"></span> {!! \Session::get('error') !!}</div>
            @endif
                <form method="POST" action="#">
                    <input type="hidden" name="_method" value="PATCH">
                    {!! csrf_field() !!}
                    <div class="form-group {{ $errors->has('oldPassword') ? ' has-error' : '' }}">
                        <label for="oldPassword">Huidige wachtwoord</label>
                        <input type="password" class="form-control" id="oldPassword" name="oldPassword" value="{{old("oldPassword")}}">
                        @if ($errors->has('oldPassword'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('oldPassword') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('newPassword') ? ' has-error' : '' }}">
                        <label for="newPassword">Nieuw wachtwoord</label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword">
                        @if ($errors->has('newPassword'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('newPassword') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('newPassword_confirmation') ? ' has-error' : '' }}">
                        <label for="newPassword_confirmation">Bevestig nieuw wachtwoord</label>
                        <input type="password" class="form-control" id="newPassword_confirmation" name="newPassword_confirmation">
                        @if ($errors->has('newPassword_confirmation'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('newPassword_confirmation') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn  btn-confirm pull-right">Wijzigen</button>
                    </div>
                </form>
        </div>
    </div>
@endsection
