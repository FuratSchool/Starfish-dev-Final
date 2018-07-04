@extends('layouts.admin')
@section('styles')
    @parent

@endsection
@section('title')
    Logboeken
@endsection
@section('main')
    <div class="col-md-12">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#auth" aria-controls="auth" role="tab" data-toggle="tab">Authorisatie</a></li>
            <li role="presentation"><a href="#users" aria-controls="users" role="tab" data-toggle="tab">Gebruikers</a></li>
            <li role="presentation"><a href="#groups" aria-controls="groups" role="tab" data-toggle="tab">Groepen</a></li>
            <li role="presentation"><a href="#tasks" aria-controls="tasks" role="tab" data-toggle="tab">Taken</a></li>
            <li role="presentation"><a href="#specialists" aria-controls="specialists" role="tab" data-toggle="tab">Specialisten</a></li>
            <li role="presentation"><a href="#specialisms" aria-controls="specialisms" role="tab" data-toggle="tab">Werkgebieden</a></li>
            <li role="presentation"><a href="#therapies" aria-controls="therapies" role="tab" data-toggle="tab">Therapieen</a></li>
            <li role="presentation"><a href="#complaints" aria-controls="complaints" role="tab" data-toggle="tab">Klachten</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="auth">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Gebruiker</th>
                        <th colspan="3">Beschrijving</th>
                        <th>Datum</th>
                        <th>tijd</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($authlog as $activity)
                        <tr>
                            <td><a href="{{route("admin.umgmt.show", $activity->causer)}}">{{$activity->causer->username}}</a></td>
                            <td colspan="3">{{$activity->description}}</td>
                            <td>{{$activity->created_at->format('d-m-Y')}}</td>
                            <td>{{$activity->created_at->format('H:i')}}</td>
                        </tr>
                    @endforeach
                    @if($authlog->total() > 10)
                        @for($i = 0 ; $i < 10 - count($authlog); $i++)
                            <tr>
                                <td colspan="6">&nbsp;</td>
                            </tr>
                        @endfor
                    @endif
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="6">
                            {{$authlog->appends($_GET)->links()}}
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="users">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Gebruiker</th>
                        <th colspan="3">Beschrijving</th>
                        <th>Door</th>
                        <th>Datum</th>
                        <th>tijd</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($userlog as $activity)
                        <tr>
                            <td><a href="{{route("admin.umgmt.show", $activity->subject)}}">{{$activity->subject->username}}</a></td>
                            <td colspan="3">{{$activity->description}}</td>
                            <td><a href="{{route("admin.umgmt.show", $activity->causer)}}">{{$activity->causer->username}}</a></td>
                            <td>{{$activity->created_at->format('d-m-Y')}}</td>
                            <td>{{$activity->created_at->format('H:i')}}</td>
                        </tr>
                    @endforeach
                    @if($userlog->total() > 10)
                        @for($i = 0 ; $i < 10 - count($userlog); $i++)
                            <tr>
                                <td colspan="7">&nbsp;</td>
                            </tr>
                        @endfor
                    @endif
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="7">
                            {{$userlog->appends($_GET)->links()}}
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="groups">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Groep</th>
                        <th colspan="3">Beschrijving</th>
                        <th>Door</th>
                        <th>Datum</th>
                        <th>tijd</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($grouplog as $activity)
                        <tr>
                            <td><a href="{{route("admin.groups.show", $activity->subject)}}">{{$activity->subject->name}}</a></td>
                            <td colspan="3">{{$activity->description}}</td>
                            <td><a href="{{route("admin.umgmt.show", $activity->causer)}}">{{$activity->causer->username}}</a></td>
                            <td>{{$activity->created_at->format('d-m-Y')}}</td>
                            <td>{{$activity->created_at->format('H:i')}}</td>
                        </tr>
                    @endforeach
                    @if($grouplog->total() > 10)
                        @for($i = 0 ; $i < 10 - count($grouplog); $i++)
                            <tr>
                                <td colspan="7">&nbsp;</td>
                            </tr>
                        @endfor
                    @endif
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="7">
                            {{$grouplog->appends($_GET)->links()}}
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="tasks">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Taak</th>
                        <th colspan="3">Beschrijving</th>
                        <th>Door</th>
                        <th>Datum</th>
                        <th>tijd</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tasklog as $activity)
                        <tr>
                            <td><a href="{{route("admin.tasks.show", $activity->subject)}}">{{$activity->subject->title}}</a></td>
                            <td colspan="3">{{$activity->description}}</td>
                            <td><a href="{{route("admin.umgmt.show", $activity->causer)}}">{{$activity->causer->username}}</a></td>
                            <td>{{$activity->created_at->format('d-m-Y')}}</td>
                            <td>{{$activity->created_at->format('H:i')}}</td>
                        </tr>
                    @endforeach
                    @if($tasklog->total() > 10)
                        @for($i = 0 ; $i < 10 - count($tasklog); $i++)
                            <tr>
                                <td colspan="7">&nbsp;</td>
                            </tr>
                        @endfor
                    @endif
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="7">
                            {{$tasklog->appends($_GET)->links()}}
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="specialists">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Specialist</th>
                        <th colspan="3">Beschrijving</th>
                        <th>Door</th>
                        <th>Datum</th>
                        <th>tijd</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($specialistlog as $activity)
                        <tr>
                            <td><a href="{{route("admin.specialists.show", $activity->subject)}}">{{$activity->subject->name}}</a></td>
                            <td colspan="3">{{$activity->description}}</td>
                            <td><a href="{{route("admin.umgmt.show", $activity->causer)}}">{{$activity->causer->username}}</a></td>
                            <td>{{$activity->created_at->format('d-m-Y')}}</td>
                            <td>{{$activity->created_at->format('H:i')}}</td>
                        </tr>
                    @endforeach
                    @if($specialistlog->total() > 10)
                        @for($i = 0 ; $i < 10 - count($specialistlog); $i++)
                            <tr>
                                <td colspan="7">&nbsp;</td>
                            </tr>
                        @endfor
                    @endif
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="7">
                            {{$specialistlog->appends($_GET)->links()}}
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="specialisms">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Werkgebied</th>
                        <th colspan="3">Beschrijving</th>
                        <th>Door</th>
                        <th>Datum</th>
                        <th>tijd</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($specialismlog as $activity)
                        <tr>
                            <td><a href="{{route("admin.specialisms.show", $activity->subject)}}">{{$activity->subject->name}}</a></td>
                            <td colspan="3">{{$activity->description}}</td>
                            <td><a href="{{route("admin.umgmt.show", $activity->causer)}}">{{$activity->causer->username}}</a></td>
                            <td>{{$activity->created_at->format('d-m-Y')}}</td>
                            <td>{{$activity->created_at->format('H:i')}}</td>
                        </tr>
                    @endforeach
                    @if($specialismlog->total() > 10)
                        @for($i = 0 ; $i < 10 - count($specialismlog); $i++)
                            <tr>
                                <td colspan="7">&nbsp;</td>
                            </tr>
                        @endfor
                    @endif
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="7">
                            {{$specialismlog->appends($_GET)->links()}}
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="therapies">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Therapie</th>
                        <th colspan="3">Beschrijving</th>
                        <th>Door</th>
                        <th>Datum</th>
                        <th>tijd</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($therapylog as $activity)
                        <tr>
                            <td><a href="{{route("admin.therapies.show", $activity->subject)}}">{{$activity->subject->name}}</a></td>
                            <td colspan="3">{{$activity->description}}</td>
                            <td><a href="{{route("admin.umgmt.show", $activity->causer)}}">{{$activity->causer->username}}</a></td>
                            <td>{{$activity->created_at->format('d-m-Y')}}</td>
                            <td>{{$activity->created_at->format('H:i')}}</td>
                        </tr>
                    @endforeach
                    @if($therapylog->total() > 10)
                        @for($i = 0 ; $i < 10 - count($therapylog); $i++)
                            <tr>
                                <td colspan="7">&nbsp;</td>
                            </tr>
                        @endfor
                    @endif
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="7">
                            {{$therapylog->appends($_GET)->links()}}
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="complaints">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Klacht</th>
                        <th colspan="3">Beschrijving</th>
                        <th>Door</th>
                        <th>Datum</th>
                        <th>tijd</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($complaintlog as $activity)
                        <tr>
                            <td><a href="{{route("admin.complaints.show", $activity->subject)}}">{{$activity->subject->name}}</a></td>
                            <td colspan="3">{{$activity->description}}</td>
                            <td><a href="{{route("admin.umgmt.show", $activity->causer)}}">{{$activity->causer->username}}</a></td>
                            <td>{{$activity->created_at->format('d-m-Y')}}</td>
                            <td>{{$activity->created_at->format('H:i')}}</td>
                        </tr>
                    @endforeach
                    @if($complaintlog->total() > 10)
                        @for($i = 0 ; $i < 10 - count($complaintlog); $i++)
                            <tr>
                                <td colspan="7">&nbsp;</td>
                            </tr>
                        @endfor
                    @endif
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="7">
                            {{$complaintlog->appends($_GET)->links()}}
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    @parent

@endsection
