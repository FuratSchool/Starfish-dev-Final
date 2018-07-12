@extends('layouts.admin')
@section('title')
    {{$user->username}} bewerken
@endsection
@section(' styles')
    @parent
@endsection
@section('main')
    <div class="cbox-fluid">
        <div class="btitle">Gebruiker bewerken</div>
        <hr class="bdivider">
        <div class="bcontent">
            <a class="text-white" href="{{route('admin.umgmt.show', $user->id)}}"> << Terug naar profiel</a>
            @if ($errors->has('error'))
                <div class="msg msg-danger msg-danger-text" id="msg">
                    <span class="glyphicon glyphicon glyphicon-remove"></span>
                    {!! $errors->first('error') !!}
                    <i class="fa fa-close" style="float: right" aria-hidden="true" onclick="return $('#msg').remove()"></i>
                </div>
            @endif
            <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.umgmt.update', $user->id) }}">
                {{method_field('patch')}}
                {{ csrf_field() }}
                <div class="form-group @if($errors->has('first_name') || $errors->has('sur_name')) has-error has-feedback @endif">
                    <label for="first_name" class="col-md-4 control-label">Voor- en Tussenvoegsel en achternaam</label>
                    <div class="col-md-2">
                        <input id="first_name" type="text" class="form-control" name="first_name"  placeholder=" Voornaam"value="{{$user->first_name}}">
                        @if ($errors->has('first_name'))
                            <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                        @endif
                    </div>
                    <div class="col-md-2">
                        <input id="adverb" type="text" class="form-control" name="adverb"  placeholder="Tussenvoegsel" value="{{$user->adverb}}">
                        @if ($errors->has('adverb'))
                            <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                        @endif
                    </div>
                    <div class="col-md-2">
                        <input id="sur_name" type="text" class="form-control" name="sur_name"  placeholder="Achternaam" value="{{$user->sur_name}}">
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
                @if(auth()->user()->is_admin > 3)
                <div class="form-group{{ $errors->has('is_admin') ? 'has-error has-feedback' : '' }}">
                    <label for="is_admin" class="col-md-4 control-label">Rol</label>
                    <div class="col-md-6">
                        <select id="is_admin" class="form-control" name="is_admin">
                            <option value="1" @if($user->is_admin == '1') selected @endif>Standaard</option>
                            <option value="2" @if($user->is_admin == '2') selected @endif>Mod</option>
                            <option value="3" @if($user->is_admin == '3') selected @endif>Admin</option>
                            <option value="4" @if($user->is_admin == '4') selected @endif>Webmaster</option>
                        </select>
                        @if($errors->has('is_admin'))
                            <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                            <span class="help-block">
                                     <strong>{{$errors->first('is_admin')}}</strong>
                               </span>
                        @endif
                    </div>
                </div>
                @endif
                <div class="form-group{{ $errors->has('notice') ? ' has-error has-feedback' : '' }}">
                    <label for="notice" class="col-md-4 control-label">Opmerking</label>
                    <div class="col-md-6">
                        <input id="notice" type="text" class="form-control" name="notice"  value="{{$user->notice}}">
                        @if ($errors->has('notice'))
                            <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                            <span class="help-block">
                                        <strong>{{ $errors->first('notice') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <button type="submit" class="btn btn-new col-md-push-4 col-md-6">Bewerken</button>
            </form>
                @if(Auth::user()->hasAccess('admin.umgmt.activate') && !$user->is_active)
                    <form class="col-md-12" method="POST" action="{{route('admin.umgmt.activate', $user->id)}}">
                        {{csrf_field()}}
                        {{method_field('patch')}}
                        <div class="form-group text-center">
                            <input type="submit"class="form-control btn btn-new" value="Activeren"/>
                        </div>
                    </form>
                @endif
                @if(Auth::user()->hasAccess('admin.umgmt.deactivate') && $user->is_active)
                    <form class="col-md-12" method="POST" action="{{route('admin.umgmt.deactivate', $user->id)}}">
                        {{csrf_field()}}
                        {{method_field('patch')}}
                        <div class="form-group text-center">
                            <input type="submit"class="form-control btn btn-destroy" value="Deactiveren"/>
                        </div>
                    </form>
                @endif
                @if(auth()->user()->hasAccess('admin.umgmt.access'))
                    <form class="col-md-12" method="GET" action="{{route('admin.umgmt.access', $user->id)}}">
                        <div class="form-group text-center">
                            <input type="submit"class="form-control btn btn-edit" value="Toegang Beheren"/>
                        </div>
                    </form>
                @endif
        </div>
    </div>
    <div class="panel panel-danger">
        <div class="panel-heading"><strong>Let op: </strong></div>
        <div class="panel-body">
            <h3> Sommige velden kunnen niet worden aangepast: </h3>
            <br>
            <ul>
                <li>Gebruikersnaam</li>
                <li>E-Mail</li>
                <li>Wachtwoord</li>
            </ul>
            <br>
            <h4>Het wachtwoord kan worden aangepast via de
                {!! auth()->user() == $user ? '<a class="alert-link" href="'.route('admin.usettings').'""> instellingen </a>' :  'instellingen' !!}
            </h4>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
@endsection