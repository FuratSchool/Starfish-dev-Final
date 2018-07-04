@extends('layouts.admin')
@section('styles')
    @parent

@endsection
@section('title')
    Nieuw Bericht
@endsection
@section('main')

    <script type="text/javascript">
        var sUser =  '@foreach($users as $user) <option value="{{$user->id}}">{{$user->username}} </option>@endforeach';
        var sGroup = '@foreach($groups as $group) <option value="{{$group->id}}">{{$group->name}} </option>@endforeach';
    </script>
    <div class="col-md-12">
        <div class="col-md-2">
            <form method="GET" action="{{route('admin.messages.index')}}">
                <div class="form-group">
                    <input type="submit" class="btn btn-new form-control" value="Terug naar berichten" />
                </div>
            </form>
        </div>
        <div class="col-md-2">
            <form method="GET" action="{{route('admin.groups.index')}}">
                <div class="form-group">
                    <input type="submit" class="btn btn-new form-control" value="Groepen" />
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-12">
            <form class="form-horizontal" role="form" method="POST" action="{{route('admin.messages.store')}}">
                <div class="col-md-6">
                    {{csrf_field()}}
                    <div class="form-group{{ $errors->has('subject') ? ' has-error has-feedback' : '' }}">
                        <label for="subject" class="col-md-12">Onderwerp </label>
                        <div class="col-md-12">
                            <input id="subject" type="text" class="form-control" name="subject"  value="@if($subject != ""){{$subject}}@else{{old('subject')}}@endif" autofocus    @if($subject != "") disabled @endif>
                            @if ($errors->has('subject'))
                                <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                                    <span class="help-block">
                                            <strong>{{ $errors->first('subject') }}</strong>
                                        </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('body') ? ' has-error has-feedback' : '' }}">
                        <label for="body" class="col-md-12">Bericht</label>
                        <div class="col-md-12">
                            <textarea id="body"  class="form-control" name="body" style="resize: none" rows="20">{{old('body')}}</textarea>
                            @if ($errors->has('body'))
                                <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                                <span class="help-block">
                                    <strong>{{ $errors->first('body') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <button type="submit" class="btn btn-new col-md-push-6 col-md-6">Versturen</button>
                </div>
                <div class="col-md-6">
                    <h3>Ontvangers (max: 5)</h3>
                    <div class="form-group{{ $errors->has('recipients') ? ' has-error has-feedback' : '' }}" id="recipient_wrapper">
                        <div class="col-md-12 recipient">
                            <label for="recipient_type" class="col-md-2" style="padding-left: 0 !important;">Type</label>
                            <label for="recipient_name" class="col-md-10">Naam</label>
                            <select id="recipient_type" name="recipients[0][type]" class="form-control recipient_type" style="width: 20%; display: inline-block" @if(!empty($type)) disabled @endif>
                                <option value="">Kies een type</option>
                                <option value="users" @if($type == 'users') selected @endif>Gebruikers</option>
                                <option value="groups" @if($type == 'groups') selected @endif>Groep</option>
                            </select>
                           <select id="recipient_name" name="recipients[0][name]" class="form-control recipient_name" style="width: 40%; display: inline-block" @if(!empty($id)) disabled @endif>
                               @if($type == 'users')
                                   @foreach($users as $user)
                                       <option value="{{$user->id}}" @if($id == $user->id) selected @endif>{{$user->username}} </option>
                                   @endforeach
                               @endif
                                   @if($type == 'groups')
                                       @foreach($groups as $group)
                                           <option value="{{$group->id}}" @if($id == $group->id) selected @endif>{{$group->name}} </option>
                                       @endforeach
                                   @endif
                           </select>
                        </div>
                        @if ($errors->has('recipients'))
                            <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                            <span class="help-block">
                                            <strong>{{ $errors->first('recipients') }}</strong>
                                        </span>
                        @endif
                    </div>
                    <div class="col-md-12">
                        <button type="button" class="btn btn-new" id="addRecipient">Ontvanger toevoegen</button>
                    </div>
                </div>
            </form>
    </div>
@endsection
@section('scripts')
    @parent

@endsection
