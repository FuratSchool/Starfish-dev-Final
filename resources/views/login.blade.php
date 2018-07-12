@extends('layouts.master')
@section('styles')
    @parent
@endsection
@section('title')
    Login
@endsection
@section('main')

    <div class="first-section">
        <div class="container just">
            <h1 class="Roboto-light">Login</h1>
            <hr>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        @if (\Session::has('message'))
                            <div class="msg msg-success msg-success-text"><i class="fa fa-check"
                                                                             aria-hidden="true"></i>{!! \Session::get('message') !!}
                            </div>
                        @endif
                        @if (\Session::has('error'))
                            <div class="msg msg-danger msg-danger-text"><i class="fa fa-times"
                                                                           aria-hidden="true"></i>{!! \Session::get('error') !!}
                            </div>
                        @endif
                        <form class="form-horizontal" role="form" method="POST" action="{{route('login')}}">
                            {{ csrf_field() }}
                            <div class="form-group {{ $errors->has('username') ? ' has-error' : '' }}">
                                <label for="username" class="col-md-4 control-label">Gebruikersnaam</label>
                                <div class="col-lg-12">
                                    {{ csrf_field()  }}
                                    <input id="username" type="text" class="form-control" name="username"
                                           value="{{ old('username') }}" required autofocus>
                                    @if ($errors->has('username'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Wachtwoord</label>

                                <div class="col-lg-12">
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group">
                                <button type="submit" class="btn btn-lg btn-success col-md-12">Login</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
