@extends('layouts.admin')
@section('styles')
    @parent

@endsection
@section('title')
    Nieuwe Taak
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
    <form class="form-horizontal" role="form" method="POST" action="{{route('admin.tasks.store')}}">
        <div class="col-md-6">
            {{csrf_field()}}
            <div class="form-group{{ $errors->has('title') ? ' has-error has-feedback' : '' }}">
                <label for="title" class="col-md-12">Taak </label>
                <div class="col-md-12">
                    <input id="title" type="text" class="form-control" name="title"  value="{{old('title')}}">
                    @if ($errors->has('title'))
                        <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                        <span class="help-block">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('description') ? ' has-error has-feedback' : '' }}">
                <label for="description" class="col-md-12">Beschrijving</label>
                <div class="col-md-12">
                    <textarea id="description"  class="form-control" name="description" style="resize: none" rows="20">{{old('description')}}</textarea>
                    @if ($errors->has('description'))
                        <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                        <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('type') || $errors->has('deadline') ? ' has-error has-feedback' : '' }}">
                <label for="type" class="col-md-6">Type </label>
                <label for="deadline" class="col-md-6">Deadline</label>
                <div class="col-md-6">
                    <select id="type" class="form-control" name="type">
                        <option value="create">Aanmaken</option>
                        <option value="edit">Aanpassen</option>
                        <option value="reminder">Herinnering</option>
                    </select>
                    @if ($errors->has('type'))
                        <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                        <span class="help-block">
                            <strong>{{ $errors->first('type') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-md-6">
                    <input id="deadline" type="date" class="form-control" name="deadline"  value="{{old('deadline')}}">
                @if ($errors->has('deadline'))
                        <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                        <span class="help-block">
                            <strong>{{ $errors->first('deadline') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <button type="submit" class="btn btn-new col-md-push-6 col-md-6">Aanmaken</button>
        </div>
        <div class="col-md-6">
            <h3>Toewijzen aan  (max: 5)</h3>
            <div class="form-group{{ $errors->has('asignees') ? ' has-error has-feedback' : '' }}" id="recipient_wrapper">
                <div class="col-md-12 assignee">
                    <label for="assignee_type" class="col-md-2" style="padding-left: 0 !important;">Type</label>
                    <label for="assignee_name" class="col-md-10">Naam</label>
                    <select id="assignee_type" name="assignees[0][type]" class="form-control assignee_type" style="width: 20%; display: inline-block">
                        <option value="">Kies een type</option>
                        <option value="users">Gebruikers</option>
                        <option value="groups">Groep</option>
                    </select>
                    <select id="assignee_id" name="assignees[0][id]" class="form-control assignee_id" style="width: 40%; display: inline-block">
                    </select>
                </div>
                @if ($errors->has('asignees'))
                    <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                    <span class="help-block">
                                            <strong>{{ $errors->first('asignees') }}</strong>
                                        </span>
                @endif
            </div>
            <div class="col-md-12">
                <button type="button" class="btn btn-new" id="addAssignee">Ontvanger toevoegen</button>
            </div>
        </div>
    </form>
</div>
@endsection
@section('scripts')
    @parent

@endsection
