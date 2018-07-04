@extends('layouts.master')
@section('styles')
    @parent
@endsection
@section('title')
    Login
@endsection
@section('main')

        <div class="col-lg-offset-3 col-lg-6">
            <div class="panel panel-default">
                <div class="panel-header"> {!! Breadcrumbs::render('login') !!}</div>
                <div class="panel-body">
                    @if (\Session::has('message'))
                        <div class="msg msg-success msg-success-text"><i class="fa fa-check" aria-hidden="true"></i>{!! \Session::get('message') !!}</div>
                    @endif
                        @if (\Session::has('error'))
                            <div class="msg msg-danger msg-danger-text"><i class="fa fa-times" aria-hidden="true"></i>{!! \Session::get('error') !!}</div>
                        @endif
                    <form class="form-horizontal" role="form" method="POST" action="{{route('login')}}">
                        {{ csrf_field() }}
                        <div class="form-group {{ $errors->has('username') ? ' has-error' : '' }}">
                            <label for="username" class="col-md-4 control-label">Gebruikersnaam</label>
                            <div class="col-lg-6">
                                {{ csrf_field()  }}
                                <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus>
                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Wachtwoord</label>

                            <div class="col-lg-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                                <button type="submit" class="btn btn-lg btn-success col-md-push-4 col-md-6">Login</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
