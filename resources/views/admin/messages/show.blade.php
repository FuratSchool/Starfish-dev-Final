@extends('layouts.admin')
@section('styles')
    @parent

@endsection
@section('title')
    @php use Illuminate\Support\Facades\Crypt @endphp
    {{Crypt::decryptString($message->subject)}}
@endsection
@section('main')
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
        <div class="col-md-2">
            @php
                    $subject = Crypt::decryptString($message->subject);
                    $params = [
                    'subject' => "RE: {$subject}",
                    'type' => "users",
                    'id' => "{$message->sender_id}"
                    ];
                    $route = route('admin.messages.create', $params);
            @endphp
            <form method="GET" action="{{$route}}">
                <input type="submit" class="btn btn-edit form-control" value="Reageren" />
            </form>
        </div>
    </div>
    <div class="col-md-8">
        <p class="messagetext">Van: <b>{{$message->sender->username}}</b></p>
        <p class="messagetext">Onderwerp: <b>{{Crypt::decryptString($message->subject)}}</b></p>
        <p class="messagetext">Datum: <b>{{title_case($message->created_at->formatLocalized("%d %b %Y, %H:%I"))}}</b></p>
        <hr class="infodivider">
        <p class="messagetext">{{Crypt::decryptString($message->body)}}</p>
    </div>
    <div class="col-md-3">
        <h2><b>Ontvangers</b></h2>
        <table class="table  table-bordered table-striped table-scrollable num-cols-2">
            <thead>
            <tr>
                <th>Naam</th>
                <th>Type</th>
            </tr>
            </thead>
            <tbody>
            @if($message->users->count() != 0)
            <tr>
                <td class="text-center" style="width: 100% !important;"><b>Gebruikers</b></td>
            </tr>
            @endif
            @foreach($message->users as $user)
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
            @if($message->groups->count() != 0)
            <tr>
                <td class="text-center" style="width: 100% !important;"><b>Groepen</b></td>
            </tr>
            @endif
            @foreach($message->groups as $group)
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
