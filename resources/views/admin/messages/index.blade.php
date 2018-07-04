@extends('layouts.admin')
@section('styles')
    @parent
@endsection
@section('title')
    Inbox
 @endsection
@section('main')
    @php
        \Carbon\Carbon::setLocale('nl');
        use Illuminate\Support\Facades\Crypt
    @endphp
    <div class="col-md-2">
        <form method="GET" action="{{route('admin.messages.create')}}">
            <div class="form-group">
                <input type="submit" class="btn btn-new form-control" value="Nieuw bericht" />
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
    @if (\Session::has('success'))
        <div class="col-md-3" id="msg">
            <div class="msg msg-success msg-success-background text-black">
                <span class="fa fa-check-circle-o"></span>
                {!! \Session::get('success') !!}
                <i class="fa fa-close" style="float: right" aria-hidden="true" onclick="return $('#msg').remove()"></i>
            </div>
        </div>
    @endif
    <div class="col-md-12">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#personal" aria-controls="personal" role="tab" data-toggle="tab">Ontvangen (Persoonlijk)</a></li>
            <li role="presentation"><a href="#groups" aria-controls="groups" role="tab" data-toggle="tab">Ontvangen (Groepen)</a></li>
            <li role="presentation"><a href="#sent" aria-controls="sent" role="tab" data-toggle="tab">Verzonden</a></li>
            <li role="presentation"><a href="#tasks" aria-controls="tasks" role="tab" data-toggle="tab">Taken (Persoonlijk)</a></li>
            <li role="presentation"><a href="#tasks" aria-controls="tasks" role="tab" data-toggle="tab">Taken (Groepen)</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="personal">
                <table class="table table-striped table-scrollable num-cols-6">
                    <thead>
                        <tr>
                            <th>Van</th>
                            <th>Onderwerp</th>
                            <th>Bericht</th>
                            <th>Ontvangen op</th>
                            <th>Reageren</th>
                            <th>Archiveren</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usermessages as $message)
                                <tr class="clickable-row" data-href="{{route('admin.messages.show', $message)}}">
                                    @php
                                        $params = [
                                          'type' => "users",
                                          'id' => "{$message->sender_id}"
                                          ];
                                          $route = route('admin.messages.create', $params);
                                    @endphp
                                    <td><a href="{{$route}}" title="Bericht aan {{$message->sender->username}}"> {{$message->sender->username}}</a></td>
                                    <td>{{Crypt::decryptString($message->subject)}}</td>
                                    <td>
                                        @if(strlen(Crypt::decryptString($message->body)) > 50)
                                            {{substr(Crypt::decryptString($message->body), 0, 50)}}...
                                        @else
                                            {{Crypt::decryptString($message->body)}}
                                        @endif
                                    </td>
                                    <td>{{title_case($message->created_at->formatLocalized("%d %b %Y, %H:%I"))}}</td>
                                    <td>
                                        @php
                                            $subject = Crypt::decryptString($message->subject);
                                            $params = [
                                            'subject' => Crypt::encryptString("RE: {$subject}"),
                                            'type' => "users",
                                            'id' => "{$message->sender_id}"
                                            ];
                                            $route = route('admin.messages.create', $params);
                                        @endphp
                                        <form method="GET" action="{{$route}}">
                                            <input type="submit" class="btn btn-edit" value="Reageren" />
                                        </form>
                                    </td>
                                    <td>
                                        <form method="POST" action="{{route('admin.messages.archive', $message)}}">
                                            {{csrf_field()}}
                                            {{method_field('patch')}}
                                            <input type="submit" class="btn btn-destroy" value="Archiveren"  />
                                        </form>
                                    </td>
                                </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="groups">
                <table class="table table-striped table-scrollable num-cols-5">
                    <thead>
                    <tr>
                        <th>Van</th>
                        <th>Onderwerp</th>
                        <th>Aan</th>
                        <th>Ontvangen op</th>
                        <th>Reageren</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($groupmessages as $message)
                        @php
                            $group = \App\Models\Group::find($message->pivot->messageable_id)
                        @endphp
                        <tr class="clickable-row" data-href="{{route('admin.messages.show', $message)}}">
                            @php
                                $params = [
                                  'type' => "users",
                                  'id' => "{$message->sender_id}"
                                  ];
                                  $route = route('admin.messages.create', $params);
                            @endphp
                            <td><a href="{{$route}}" title="Bericht aan {{$message->sender->username}}"> {{$message->sender->username}}</a></td>
                            <td>{{Crypt::decryptString($message->subject)}}</td>
                            @php
                                $params = [
                                  'type' => "groups",
                                  'id' => "{$group->id}"
                                  ];
                                  $route = route('admin.messages.create', $params);
                            @endphp
                            <td><a href="{{$route}}" title="Bericht aan {{$group->name}}"> {{$group->name}}</a></td>
                            <td>{{title_case($message->created_at->formatLocalized("%d %b %Y, %H:%I"))}}</td>
                            <td>
                                @php
                                    $subject = Crypt::decryptString($message->subject);
                                    $params = [
                                    'subject' => Crypt::encryptString("RE: {$subject}"),
                                    'type' => "users",
                                    'id' => "{$message->sender_id}"
                                    ];
                                    $route = route('admin.messages.create', $params);
                                @endphp
                                <form method="GET" action="{{$route}}">
                                    <input type="submit" class="btn btn-edit" value="Reageren" />
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="sent">
                <table class="table table-striped table-scrollable num-cols-4">
                    <thead>
                    <tr>
                        <th>Aan</th>
                        <th>Onderwerp</th>
                        <th>Verstuurd op</th>
                        <th>Verwijderen</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sentmessages as $message)
                        <tr @if(!$message->trashed())class="clickable-row" data-href="{{route('admin.messages.show', $message)}}" @endif>
                            <td>{{$message->users->count()}} gebruiker en {{$message->groups->count()}} groepen</td>
                            <td>{{Crypt::decryptString($message->subject)}}</td>
                            <td>{{title_case($message->created_at->formatLocalized("%d %b %Y, %H:%I"))}}</td>
                            <td>
                                @if(!$message->trashed())
                                        <form method="POST" action="{{route('admin.messages.destroy', $message)}}">
                                            {{csrf_field()}}
                                            {{method_field('delete')}}
                                            <input type="submit" class="btn btn-destroy" value="Verwijderen"  />
                                        </form>
                                    @else
                                    <form method="POST" action="{{route('admin.messages.restore', $message)}}">
                                        {{csrf_field()}}
                                        {{method_field('patch')}}
                                        <input type="submit" class="btn btn-new" value="Herstellen"  />
                                    </form>
                                    @endif
                            </td>
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
                            <td>@if($task->deadline){{title_case($task->deadline->formatLocalized("%d %b %Y, %H:%I"))}}@else Geen deadline @endif</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="grouptasks">
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
                    @foreach($grouptasks as $task)
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
                            <td>@if($task->deadline){{title_case($task->deadline->formatLocalized("%d %b %Y, %H:%I"))}}@else Geen deadline @endif</td>
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

