@extends('layouts.admin')
@section('title')
    {{$user->username}} ({{$user->id}})
@endsection
@section('main')
    @php
        $time =  \Carbon\Carbon::now()->diffInMinutes(auth()->user()->last_login);
        if($time < 60) {
        if($time == 1) {
               $timeonline = "1 minuut";
          } elseif($time == 0) {
                $timeonline = "Zojuist ingelogd";
          } else {
                $timeonline = $time." minuten";
          }
        } elseif($time % 60 == 0) {
        $timeonline = floor($time/60)." uur";
        }  else {
        $timeonline = floor($time/60)." uur en ".($time%60)." minuten";
        }
    @endphp
    <div class="col-md-6">
        @if (\Session::has('success'))
            <div class="msg msg-success msg-success-background">
                    <span class="glyphicon glyphicon glyphicon-ok"></span> {!! \Session::get('success') !!}<i class="fa fa-close" style="float: right" aria-hidden="true" onclick="return $('#msg').remove()"></i>
            </div>
        @endif
    </div>
    <div class="col-md-6"></div>
<div class="cbox-fluid">
    <div class="btitle">Gegevens</div>
    <hr class="bdivider">
    <div class="bcontent">
        <dl>
        <dt>Naam:</dt> <dd>{{$user->first_name." ".$user->sur_name}}</dd>
        <dt>E-Mail: </dt><dd>{{$user->email}}</dd>
        <dt>Status: </dt><dd>{{$user->is_active ? "Actief" : "Non-Actief"}}</dd>
        <dt>Rol:  </dt>
            <dd>
                @if($user->is_admin == 1)
                    Standaard
                @elseif($user->is_admin == 2)
                    Mod
                @elseif($user->is_admin == 3)
                    Admin
                @elseif($user->is_admin == 4)
                    Webmaster
                @endif
            </dd>
        </dl>
        <dl>
        <dt>Laatste login: </dt><dd>{{$user->last_login ? $user->last_login->diffForHumans() : "Niet bekend"}}</dd>
        <dt>Online: </dt><dd>{!! $user->is_online ? "<i class='fa fa-circle' style='color:lightgreen' title='online'></i>" : "<i class='fa fa-circle' style='color:red' title='offline'></i>" !!}</dd>
            @if($user->is_online && auth()->user()->is_admin > 2)
                <dt>Tijd online: </dt><dd>{{$timeonline}}</dd>
            @else
                <dt></dt>
            @endif
            <dt>Opmerking: </dt><dd>{{$user->notice}}</dd>
        </dl>
        @php
            $params = [
            'type' => 'users',
            'id' => "{$user->id}"
            ];
            $route = route('admin.messages.create', $params);
        @endphp
        <form class="col-md-12" method="GET" action="{{$route}}">
            <input type="submit" class="btn btn-edit form-control" value="Bericht versturen" />
        </form>
        @if( auth()->user()->hasAccess('admin.umgmt.edit') || $user->id == auth()->user()->id)
            <div class="text-center">
                <form class="col-md-12" method="GET" action="{{route('admin.umgmt.edit', $user->id)}}">
                    <div class="form-group text-center">
                    <input type="submit"class="form-control btn btn-edit" value="Bewerken"/>
                    </div>
                </form>
            @if(!$user->trashed() && Auth::user() != $user && Auth::user()->hasAccess('admin.umgmt.destroy') && $user->is_admin < 4)
                <form class="col-md-12" method="POST" action="{{route('admin.umgmt.destroy', $user->id)}}" onsubmit="return confirm('Weet je zeker dat je {{$user->username}} wilt verwijderen?\nDEZE BEWERKING KAN NIET TERUGGEDRAAID WORDEN')">
                    {{csrf_field()}}
                    {{method_field('delete')}}
                    <div class="form-group text-center">
                    <input  type="submit" class="form-control btn btn-destroy" value="Verwijderen" />
                    </div>
                </form>
                @endif
                @if($user->trashed())
                    @if(auth()->user()->hasAccess('admin.umgmt.restore'))
                        <form class="col-md-12" method="POST" action="{{route('admin.umgmt.restore', $user->id)}}">
                            {{method_field('patch')}}
                            {{csrf_field()}}
                            <div class="form-group text-center">
                               <input type="submit"class="form-control btn btn-new" value="Herstellen" />
                            </div>
                        </form>
                    @endif
                    @if(auth()->user()->hasAccess('admin.umgmt.forget'))
                            <form class="col-md-12" method="POST" action="{{route('admin.umgmt.forget', $user->id)}}" onsubmit="return confirm('Weet je zeker dat je {{$user->username}} wilt vergeten?\nDEZE BEWERKING KAN NIET TERUGGEDRAAID WORDEN')">
                                {{csrf_field()}}
                                {{method_field('delete')}}
                                <div class="form-group text-center">
                                    <input  type="submit"class="form-control btn btn-destroy" value="Vergeten" />
                                </div>
                            </form>
                        @endif
                @endif
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
            </div>
        @endif
        @if(auth()->user()->hasAccess('admin.umgmt.access'))
            <div class="col-md-12">
                <div class="btitle">Toegang</div>
                <hr class="bdivider">
                <div class="text-center">
                    <form class="col-md-12" method="GET" action="{{route('admin.umgmt.access', $user->id)}}">
                        <div class="form-group text-center">
                            <input type="submit"class="form-control btn btn-edit" value="Toegang Beheren"/>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
@if(auth()->user()->hasAccess('admin.logs.index'))
<div class="cbox-fluid">
    <div class="btitle">Activiteit</div>
    <hr class="bdivider">
    <div class="bcontent">
        <table class="table table-striped" id="log">
            <thead>
                 <tr>
                     <th>Beschrijving</th>
                     <th>Datum</th>
                     <th>Tijd</th>
                 </tr>
            </thead>
            <tbody>
                 @foreach($userlog as $activity)
                     <tr>
                         <td>{{$activity->description}}</td>
                         <td>{{$activity->created_at->format('d-m-Y')}}</td>
                         <td>{{$activity->created_at->format('H:i')}}</td>
                     </tr>
                 @endforeach
               @for($i = 0 ; $i < 10 - count($userlog); $i++)
                   <tr>
                       <td>&nbsp;</td>
                       <td></td>
                       <td></td>
                       <td></td>
                   </tr>
               @endfor
            </tbody>
                 <tfoot>
                     <tr>
                         <td colspan="4">
                             {{$userlog->links() }}
                         </td>
                     </tr>
                 </tfoot>
        </table>
    </div>
</div>
@endif
@endsection