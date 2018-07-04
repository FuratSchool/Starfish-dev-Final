@extends('layouts.admin')
@section('styles')
    @parent

@endsection
@section('title')
    Taken
@endsection
@section('main')
    @php
        \Carbon\Carbon::setLocale('nl');
    @endphp
    <div class="col-md-2">
        <form method="GET" action="{{route('admin.tasks.create')}}">
            <div class="form-group">
                <input type="submit" class="btn btn-new form-control" value="Nieuwe Taak" />
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
            <li role="presentation" class="active"><a href="#tasks" aria-controls="tasks" role="tab" data-toggle="tab">Alle taken</a></li>
            <li role="presentation"><a href="#personal" aria-controls="personal" role="tab" data-toggle="tab">Jouw taken (persoonlijk)</a></li>
            <li role="presentation"><a href="#groups" aria-controls="groups" role="tab" data-toggle="tab">Jouw taken (groepen)</a></li>
            @if(auth()->user()->hasAccess('admin.tasks.destroy'))
                <li role="presentation"><a href="#archived" aria-controls="groups" role="tab" data-toggle="tab">Gearchiveerd</a></li>
            @endif
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tasks">
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
            <div role="tabpanel" class="tab-pane" id="personal">
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
                    @foreach($usertasks as $task)
                        <tr class="clickable-row" data-href="{{route('admin.tasks.show', $task)}}">
                            <td>{{$task->title}}</td>
                            <td>{{{ substr($task->description, 0, 30) }}}</td>
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
                            </td>
                            <td>{{title_case($task->created_at->formatLocalized("%d %b %Y, %H:%I"))}}</td>
                            <td>@if($task->deadline){{title_case($task->deadline->formatLocalized("%d %b %Y, %H:%I"))}}@else Geen deadline @endif</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="groups">
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
                            <td>{{{ substr($task->description, 0, 30) }}}</td>
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
                            </td>
                            <td>{{title_case($task->created_at->formatLocalized("%d %b %Y, %H:%I"))}}</td>
                            <td>@if($task->deadline){{title_case($task->deadline->formatLocalized("%d %b %Y, %H:%I"))}}@else Geen deadline @endif</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @if(auth()->user()->hasAccess('admin.tasks.destroy'))
            <div role="tabpanel" class="tab-pane" id="archived">
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
                    @foreach($archivedtasks as $task)
                        <tr class="clickable-row" data-href="{{route('admin.tasks.show', $task)}}">
                            <td>{{$task->title}}</td>
                            <td>{{{ substr($task->description, 0, 30) }}}</td>
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
                            </td>
                            <td>{{title_case($task->created_at->formatLocalized("%d %b %Y, %H:%I"))}}</td>
                            <td>@if($task->deadline){{title_case($task->deadline->formatLocalized("%d %b %Y, %H:%I"))}}@else Geen deadline @endif</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
            @endif
            </div>
        </div>
@endsection

@section('scripts')
    @parent

@endsection
