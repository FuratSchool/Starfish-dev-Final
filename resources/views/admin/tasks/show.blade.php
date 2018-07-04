@extends('layouts.admin')
@section('styles')
    @parent

@endsection
@section('title')
    {{$task->title}}
@endsection
@section('main')

    <div class="col-md-12">
        @if (\Session::has('success'))
            <div class="col-md-3" id="msg">
                <div class="msg msg-success msg-success-background text-black">
                    <span class="fa fa-check-circle-o"></span>
                    {!! \Session::get('success') !!}
                    <i class="fa fa-close" style="float: right" aria-hidden="true" onclick="return $('#msg').remove()"></i>
                </div>
            </div>
        @endif
            <div class="col-md-2">
                <form method="GET" action="{{route('admin.tasks.index')}}">
                    <div class="form-group">
                        <input type="submit" class="btn btn-new form-control" value="Terug" />
                    </div>
                </form>
            </div>
        @if(!$task->trashed() and auth()->user()->hasAccess("admin.tasks.edit"))
            <div class="col-md-2">
                <form method="GET" action="{{route('admin.tasks.edit', $task)}}">
                    <div class="form-group">
                        <input type="submit" class="form-control btn btn-edit" value="Bewerken"/>
                    </div>
                </form>
            </div>
        @endif
        @if($task->status < 2  or $task->status == 4 and auth()->id() == $task->assigner_id or in_array(auth()->id(), $task->users()->get(['id'])->toArray())  or  in_array(auth()->id(), $task->groups->pluck('users')->collapse()->unique()->toArray()))
            <div class="col-md-2">
                <form method="POST" action="{{route('admin.tasks.updateStatus', $task)}}">
                    {{csrf_field()}}
                    {{method_field('patch')}}
                    <div class="form-group">
                        <input type="submit" class="form-control btn btn-edit" value="Status opwaarderen"/>
                    </div>
                </form>
            </div>
        @endif
        @if($task->status == 2 and auth()->id() == $task->assigner_id )
            <div class="col-md-2">
                <form method="POST" action="{{route('admin.tasks.finishTask', $task)}}">
                    {{csrf_field()}}
                    {{method_field('patch')}}
                    <div class="form-group">
                        <input type="submit" class="form-control btn btn-new" value="Afronden"/>
                    </div>
                </form>
            </div>
        @endif
            @if($task->status == 2 and auth()->id() == $task->assigner_id )
                <div class="col-md-2">
                    <form method="POST" action="{{route('admin.tasks.needsRevision', $task)}}">
                        {{csrf_field()}}
                        {{method_field('patch')}}
                        <div class="form-group">
                            <input type="submit" class="form-control btn btn-warning text-white" value="Revisie nodig"/>
                        </div>
                    </form>
                </div>
            @endif
        @if(!$task->trashed() and auth()->user()->hasAccess('admin.tasks.destroy') && $task->status == 3)
            <div class="col-md-2">
                <form  method="POST" action="{{route('admin.tasks.destroy', $task)}}" onsubmit="return confirm('Weet je zeker dat je {{$task->title}} wilt verwijderen?\nDEZE BEWERKING KAN NIET TERUGGEDRAAID WORDEN')">
                    {{csrf_field()}}
                    {{method_field('delete')}}
                    <div class="form-group">
                        <input  type="submit" class="form-control btn btn-destroy" value="Archiveren" />
                    </div>
                </form>
            </div>
        @endif
    </div>

    <div class="col-md-8">
        <p class="messagetext">Taak: <b>{{$task->title}}</b></p>
        <p class="messagetext">Aangemaakt door: <b>{{$task->assigner->username}}</b></p>
        <p class="messagetext">Type: <b>
                    @if($task->type == 'create')
                        Aanmaken
                    @endif
                    @if($task->type == 'edit')
                        Aanpassen
                    @endif
                    @if($task->type == 'reminder')
                        Herrinnering
                    @endif
            </b></p>
        <p class="messagetext">Status: <b>
                @if($task->status == 0)
                    <span style="padding: 5px; color: white; background-color: red;"> Niet begonnen </span>
                @endif
                @if($task->status == 1)
                        <span style="padding: 5px; color: white; background-color: orange;"> Wordt uitgevoerd </span>
                @endif
                @if($task->status == 2)
                        <span style="padding: 5px; color: white; background-color: blue;"> Uitgevoerd </span>
                @endif
                @if($task->status == 3)
                    <span style="padding: 5px; color: white; background-color: green;"> Afgerond </span>
                @endif
                @if($task->status == 4)
                    <span style="padding: 5px; color: white; background-color: purple;"> Revisie nodig </span>
                @endif

            </b></p>
        <p class="messagetext">Aangemaakt op: <b>{{$task->created_at}}</b></p>
        <p class="messagetext">Status bijgewerkt op: <b>{{$task->updated_at}}</b></p>
        <p class="messagetext">Deadline: <b>@if($task->deadline){{title_case($task->deadline->formatLocalized("%d %b %Y, %H:%I"))}}@else Geen deadline @endif</b></p>
        <hr class="infodivider">
        <p lang="nl" class="messagetext">{{$task->description}}</p>
    </div>
    <div class="col-md-3">
        <h2><b>Toewijzingen</b></h2>
        <table class="table  table-bordered table-striped table-scrollable num-cols-2">
            <thead>
            <tr>
                <th>Naam</th>
                <th>Type</th>
            </tr>
            </thead>
            <tbody>
            @if($task->users->count() != 0)
                <tr>
                    <td class="text-center" style="width: 100% !important;color:white; background-color: #2F3133"><b>Gebruikers</b></td>
                </tr>
            @endif
            @foreach($task->users as $user)
                <tr>
                    <td><b>{{$user->username}}</b></td>
                    <td>
                        @if($user->is_admin == 1)
                            Standaard
                        @elseif($user->is_admin == 2)
                            Mod
                        @elseif($user->is_admin == 3)
                            Admin
                        @elseif($user->is_admin == 4)
                            Webmaster
                        @endif
                    </td>
                </tr>
            @endforeach
            @if($task->groups->count() != 0)
                <tr>
                    <td class="text-center" style="width: 100% !important;color:white; background-color: #2F3133"><b>Groepen</b></td>
                </tr>
            @endif
            @foreach($task->groups as $group)
                <tr>
                    <td><b>{{$group->name}}</b></td>
                    <td>
                        Groep
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('scripts')
    @parent

@endsection
