@extends('layouts.admin')
@section('styles')
    @parent
@endsection
@section('title')
    Groep: {{$group->name}}
@endsection
@section('main')
    <div class="col-md-12">
        <div class="col-md-2">
            <form method="GET" action="{{route('admin.groups.index')}}">
                <div class="form-group">
                    <input type="submit" class="btn btn-new form-control" value="Terug" />
                </div>
            </form>
        </div>
        @php
            $params = [
              'type' => "groups",
              'id' => "{$group->id}"
              ];
              $route = route('admin.messages.create', $params);
        @endphp
        <div class="col-md-2">
            <form method="GET" action="{{$route}}">
                <div class="form-group">
                    <input type="submit" class="btn btn-new form-control" value="Berciht aan groep" />
                </div>
            </form>
        </div>
        @if(auth()->user()->hasAccess("admin.groups.edit"))
            <div class="col-md-2">
                <form method="GET" action="{{route('admin.groups.edit', $group)}}">
                    <div class="form-group">
                        <input type="submit" class="form-control btn btn-edit" value="Bewerken"/>
                    </div>
                </form>
            </div>
        @endif
        @if(auth()->user()->hasAccess('admin.groups.destroy'))
            <div class="col-md-2">
                <form  method="POST" action="{{route('admin.groups.destroy', $group)}}" onsubmit="return confirm('Weet je zeker dat je {{$group->name}} wilt verwijderen?\nDEZE BEWERKING KAN NIET TERUGGEDRAAID WORDEN')">
                    {{csrf_field()}}
                    {{method_field('delete')}}
                    <div class="form-group">
                        <input  type="submit" class="form-control btn btn-destroy" value="Verwijderen" />
                    </div>
                </form>
            </div>
        @endif
    </div>
    <div class="col-md-12">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"  class="active"><a href="#members" aria-controls="members" role="tab" data-toggle="tab">Leden</a></li>
            <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Berichten</a></li>
            <li role="presentation"><a href="#tasks" aria-controls="tasks" role="tab" data-toggle="tab">Taken</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="members">
                <table class="table table-striped table-scrollable num-cols-4">
                    <thead>
                    <tr>
                        <th>Gebruikersnaam</th>
                        <th>Voornaam</th>
                        <th>Achternaam</th>
                        <th>Rol</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($group->users as $member)
                        <tr>
                            @php
                                $params = [
                                  'type' => "users",
                                  'id' => "{$member->id}"
                                  ];
                                  $route = route('admin.messages.create', $params);
                            @endphp
                            <td><a href="{{$route}}" title="Bericht aan {{$member->username}}"> {{$member->username}}</a></td>
                            <td>{{$member->first_name}}</td>
                            <td>{{$member->sur_name}}</td>
                            <td>
                                @if($member->is_admin == 1)
                                    Standaard
                                @elseif($member->is_admin == 2)
                                    Mod
                                @elseif($member->is_admin == 3)
                                    Admin
                                @elseif($member->is_admin == 4)
                                    Webmaster
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div role="tabpanel" class="tab-pane" id="messages">
                <table class="table table-striped table-scrollable num-cols-4">
                    <thead>
                        <tr>
                            <th>Van</th>
                            <th>Onderwerp</th>
                            <th>Bericht</th>
                            <th>Ontvangen op</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($messages as $message)
                        <tr>
                            <td>{{$message->sender->username}}</td>
                            <td>{{Crypt::decryptString($message->subject)}}</td>
                            <td>
                                @if(strlen(Crypt::decryptString($message->body)) > 50)
                                    {{substr(Crypt::decryptString($message->body), 0, 50)}}...
                                @else
                                    {{Crypt::decryptString($message->body)}}
                                @endif
                            </td>
                            <td>{{title_case($message->created_at->formatLocalized("%d %b %Y, %H:%I"))}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="tasks">
                <table class="table table-striped table-scrollable num-cols-6">
                    <thead>
                    <tr>
                        <th>Taak</th>
                        <th>Omschrijving</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Aangemaakt op</th>
                        <th>Deadline</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tasks as $task)
                        <tr class="clickable-row" data-href="{{route('admin.tasks.show', $task)}}">
                            <td>{{$task->title}}</td>
                            <td>{{$task->description}}</td>
                            <td>
                                @if($task->type == 'create')
                                    Aanmaken
                                @endif
                                @if($task->type == 'edit')
                                    Aanpassen
                                @endif
                                @if($task->type == 'reminder')
                                    Herrinnering
                                @endif
                            </td>
                            <td>
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
                            </td>
                            <td>{{title_case($task->created_at->formatLocalized("%d %b %Y, %H:%I"))}}</td>
                            <td>{{title_case($task->deadline->formatLocalized("%d %b %Y, %H:%I"))}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent

@endsection
