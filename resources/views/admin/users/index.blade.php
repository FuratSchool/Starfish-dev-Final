@extends('layouts.admin')
@section('title')
    Lijst van gebruikers
@endsection
@section('main')
    @php
        $params = request()->input();
        $urls = [];
        $dict = ['id', 'username', 'first_name', 'sur_name', 'email', 'status', 'LOA', 'updated_at'];
        foreach ($dict as $value) {
        $params['order'] = $value;
        $params['dir'] = $fdir[$value];
        $urls[$value] = route('admin.umgmt.index', $params);
        }
    @endphp
    @if(auth()->user()->hasAccess('admin.umgmt.create'))
        <div class="col-md-2">
            <form method="GET" action="{{route('admin.umgmt.create')}}">
                <div class="form-group">
                  <input type="submit"class="btn btn-new form-control" value="Nieuwe gebruiker" />
                </div>
            </form>
        </div>
    @endif
    <div id="sform">
        <form method="GET" action="" class="form-inline">
           <div class="form-group">
               <label for="filter_type">Zoek op: </label>
               <select class="form-control" name="filter_type" id="filter_type">
                   <option value='init' id="init">{{request()->filter_type ? "Verwijder Filters" : 'Kies kolom'}}</option>
                   <option value="username">Gebruikersnaam</option>
                   <option value="first_name">Voornaam</option>
                   <option value="sur_name">Achternaam</option>
                   <option value="email">E-Mail</option>
                   <option value="status">Status</option>
                   <option value="LOA">Rol</option>
                   <option value="online">Online</option>
               </select>
           </div>
            <div class="form-group" id="sq"></div>
            <div class="form-group">
                <input type="submit" class="btn btn-edit form-control" value="Zoeken" />
            </div>
        </form>
    </div>
    @if (\Session::has('success'))
        <div class="col-md-3" id="msg">
            <div class="msg msg-success msg-success-background text-black">
                <span class="glyphicon glyphicon glyphicon-ok"></span>
                {!! \Session::get('success') !!}
                <i class="fa fa-close" style="float: right" aria-hidden="true" onclick="return $('#msg').remove()"></i>
            </div>
        </div>
    @endif
    <table class="table table-striped usertable" id="table1">
        <thead>
            <tr>
                <th class="text-center" colspan="10">Gebruikers [{{$users->firstItem() }} - {{ $users->lastItem()}} van de  {{$users->total()}}] [Totaal: {{\App\Models\User::count()}}]</th>
            </tr>
            <tr>
                <th>
                    <a href="{{$urls['id']}}">ID
                        @if($fdir['id'] == 'desc' && $column  == 'id' && isset($_GET['order']) && $_GET['order'] == 'id')
                            <i class="fa fa-sort-asc" aria-hidden="true"></i>
                        @elseif($fdir['id'] == 'asc' && $column == 'id' && $_GET['order'] == 'id')
                            <i class="fa fa-sort-desc" aria-hidden="true"></i>
                        @else
                            <i class="fa fa-sort" aria-hidden="true"></i>
                        @endif
                    </a>
                </th>
                <th>
                    <a href="{{$urls['username']}}">Gebruikersnaam
                        @if($fdir['username'] == 'desc' && $column  == 'username')
                            <i class="fa fa-sort-asc" aria-hidden="true"></i>
                        @elseif($fdir['username'] == 'asc' && $column == 'username')
                            <i class="fa fa-sort-desc" aria-hidden="true"></i>
                        @else
                            <i class="fa fa-sort" aria-hidden="true"></i>
                        @endif
                    </a>
                </th>
                <th>
                    <a href="{{$urls['first_name']}}">Voornaam
                        @if($fdir['first_name'] == 'desc' && $column == 'first_name')
                            <i class="fa fa-sort-asc" aria-hidden="true"></i>
                        @elseif($fdir['first_name'] == 'asc' && $column == 'first_name')
                            <i class="fa fa-sort-desc" aria-hidden="true"></i>
                        @else
                            <i class="fa fa-sort" aria-hidden="true"></i>
                        @endif
                    </a>
                </th>
                <th>
                    <a href="{{$urls['sur_name']}}">Achternaam
                        @if($fdir['sur_name'] == 'desc' && $column == 'sur_name')
                            <i class="fa fa-sort-asc" aria-hidden="true"></i>
                        @elseif($fdir['sur_name'] == 'asc' && $column == 'sur_name')
                            <i class="fa fa-sort-desc" aria-hidden="true"></i>
                        @else
                            <i class="fa fa-sort" aria-hidden="true"></i>
                        @endif
                    </a>
                </th>
                <th>
                    <a href="{{$urls['email']}}">E-mail
                        @if($fdir['email'] == 'desc' && $column == 'email')
                            <i class="fa fa-sort-asc" aria-hidden="true"></i>
                        @elseif($fdir['email'] == 'asc' && $column == 'email')
                            <i class="fa fa-sort-desc" aria-hidden="true"></i>
                        @else
                            <i class="fa fa-sort" aria-hidden="true"></i>
                        @endif
                    </a>
                </th>
                <th>
                    <a href="{{$urls['status']}}">Status
                        @if($fdir['status'] == 'desc' && $column  == 'status')
                            <i class="fa fa-sort-asc" aria-hidden="true"></i>
                        @elseif($fdir['status'] == 'asc' && $column == 'status')
                            <i class="fa fa-sort-desc" aria-hidden="true"></i>
                        @else
                            <i class="fa fa-sort" aria-hidden="true"></i>
                        @endif
                    </a>
                </th>
                <th>
                    <a href="{{$urls['LOA']}}">Rol
                        @if($fdir['LOA'] == 'desc' && $column == 'LOA')
                            <i class="fa fa-sort-asc" aria-hidden="true"></i>
                        @elseif($fdir['LOA'] == 'asc' && $column == 'LOA')
                            <i class="fa fa-sort-desc" aria-hidden="true"></i>
                        @else
                            <i class="fa fa-sort" aria-hidden="true"></i>
                        @endif
                    </a>
                </th>
                <th>
                    <a href="?order=updated_at&dir={{$fdir['updated_at']}}">Laatste login
                        @if($fdir['updated_at'] == 'desc' && $column  == 'updated_at')
                            <i class="fa fa-sort-asc" aria-hidden="true"></i>
                        @elseif($fdir['updated_at'] == 'asc' && $column == 'updated_at')
                            <i class="fa fa-sort-desc" aria-hidden="true"></i>
                        @else
                            <i class="fa fa-sort" aria-hidden="true"></i>
                        @endif
                    </a>
                </th>
                <th>Bewerken</th>
                <th>Verwijderen</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td><a href="{{route('admin.umgmt.show', $user->id)}}"> {{$user->username}}  {!! $user->is_online ? "<i class='fa fa-circle' style='color:lightgreen; float:right' title='online'></i>" : "<i class='fa fa-circle' style='color:red;float:right' title='offline'></i>" !!}</a></td>
                <td>{{$user->first_name}}</td>
                <td>{{$user->sur_name}}</td>
                <td>{{$user->email}}</td>
                <td>
                    @if($user->status == 1)
                        Geactiveerd
                    @else
                        Niet geactiveerd
                        <i class="fa fa-info-circle" aria-hidden="true" title= "De admin heeft dit account nog niet geactiveerd"></i>
                    @endif
                </td>
                <td>
                    @if($user->LOA == 1)
                            Standaard
                    @elseif($user->LOA == 2)
                            Mod
                    @elseif($user->LOA == 3)
                            Admin
                    @elseif($user->LOA == 4)
                            Webmaster
                    @endif
                </td>
                <td>{{$user->last_login ? $user->last_login->diffForHumans() : "Niet bekend"}}</td>
                <td>
                    @if(auth()->user()->hasAccess('admin.umgmt.edit'))
                        <form method="GET" action="{{route('admin.umgmt.edit', $user->id)}}">
                            <input type="submit"class="btn btn-edit" value="Bewerken" />
                        </form>
                    @else
                        Onvoldoende rechten
                    @endif
                </td>
                <td>
                    @if(auth()->user()->hasAccess('admin.umgmt.destroy') && $user->LOA < 4)
                        <form method="POST" action="{{route('admin.umgmt.destroy', $user->id)}}" onsubmit="return confirm('Weet je zeker dat je {{$user->username}} wilt verwijderen?\nDEZE BEWERKING KAN NIET TERUGGEDRAAID WORDEN')">
                            {{csrf_field()}}
                            {{method_field('delete')}}
                            <input type="submit"class="btn btn-destroy" value="Verwijderen"  />
                        </form>
                    @elseif($user->id == auth()->user()->id)
                       Ongeldige bewerking
                        <i class="fa fa-info-circle" aria-hidden="true" title= "Je mag jezelf niet verwijderen"></i>
                    @else
                        Onvoldoende rechten
                        @if($user->LOA == 4)
                            <i class="fa fa-info-circle" aria-hidden="true" title= "Je mag geen webmasters verwijderen"></i>
                        @endif
                    @endif
                </td>
            </tr>
        @endforeach
        @if($users->total() > 10)
            @for($i = 0 ; $i < 10 - count($users); $i++)
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endfor
        @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="10">
                    {{$users->appends($_GET)->links()}}
                </td>
            </tr>
        </tfoot>
    </table>
    @if(auth()->user()->hasAccess('admin.umgmt.destroy') && auth()->user()->hasAccess('admin.umgmt.restore'))
        <table class="table" id="table2toggle">
            <thead>
                <tr>
                    <th class="text-center toggletable2" colspan="10">Verwijderde gebruikers <i class="fa fa-caret-down" aria-hidden="true"></i> </th>
                </tr>
            </thead>
        </table>
        <div class="col-md-12" id="table2wrapper">
            <table class="table table-striped usertable" id="table2">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Gebruikersnaam</th>
                    <th>Voornaam</th>
                    <th>Achternaam</th>
                    <th>E-mail</th>
                    <th>Status</th>
                    <th>Rol</th>
                    <th>Verwijderd door</th>
                    <th>Verwijderd op</th>
                    <th>Herstellen</th>
                    <th>Vergeten</th>
                </tr>
                </thead>
                <tbody>
                @foreach($deletedUsers as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td><a href="{{route('admin.umgmt.show', $user->id)}}"> {{$user->username}} </a></td>
                        <td>{{$user->first_name}}</td>
                        <td>{{$user->sur_name}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                            @if($user->trashed())
                                Verwijderd
                            @elseif($user->status == 1 and !$user->trashed())
                                Geactiveerd
                            @else
                                Niet geactiveerd
                                <i class="fa fa-info-circle" aria-hidden="true" title= "De admin heeft dit account nog niet geactiveerd"></i>
                            @endif
                        </td>
                        <td>
                            @if($user->LOA == 1)
                                Standaard
                            @elseif($user->LOA == 2)
                                Mod
                            @elseif($user->LOA == 3)
                                Admin
                            @elseif($user->LOA == 4)
                                Webmaster
                            @endif
                        </td>
                        <td>
                            @php
                                $logentry = \Spatie\Activitylog\Models\Activity::where('created_at', $user->deleted_at)->first();
                                $causer = $logentry->causer;
                            @endphp
                                {{$causer->username}}
                        </td>
                        @php setlocale(LC_TIME, 'Dutch'); @endphp
                        <td>{{$user->deleted_at ? $user->deleted_at->formatLocalized('%d %B %Y') : "Niet bekend"}}</td>
                        <td>
                            @if(auth()->user()->hasAccess('admin.umgmt.restore'))
                                <form method="POST" action="{{route('admin.umgmt.restore', $user->id)}}">
                                    {{method_field('patch')}}
                                    {{csrf_field()}}
                                    <input type="submit"class="btn btn-new" value="Herstellen" />
                                </form>
                            @else
                                Onvoldoende rechten
                            @endif
                        </td>
                        <td>
                            @if(auth()->user()->hasAccess('admin.umgmt.forget'))
                                <form method="POST" action="{{route('admin.umgmt.forget', $user->id)}}" onsubmit="return confirm('Weet je zeker dat je {{$user->username}} wilt vergeten?\nDEZE BEWERKING KAN NIET TERUGGEDRAAID WORDEN')">
                                    {{csrf_field()}}
                                    {{method_field('delete')}}
                                    <input type="submit"class="btn btn-destroy" value="Vergeten"  />
                                </form>
                                @endif
                        </td>
                    </tr>
                @endforeach
                @if($deletedUsers->total() > 10)
                    @for($i = 0 ; $i < 10 - count($deletedUsers); $i++)
                        <tr>
                            <td>&nbsp;</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endfor
                @endif
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="10">
                        {{$deletedUsers->appends($_GET)->links()}}
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    @endif
@endsection
