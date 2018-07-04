@extends('layouts.admin')
@section('styles')
    @parent
@endsection
@section('title')
    Specialisten
 @endsection
@section('main')
    @php(
    $speclist = \App\Models\Specialist::all()
    )
    <script>
        var sOccupation =  '<select class="form-control" name="q" id="q">' +
            @foreach ($speclist->unique('occupation')->values()->sortBy('occupation')->all() as $specialist)
                @if(strlen($specialist->occupation) > 20)
                    '<option value="{{$specialist->occupation}}" title="{{$specialist->occupation}}">{{substr($specialist->occupation, 0, 15)}}...</option>'+
                @else
                    '<option value="{{$specialist->occupation}}">{{$specialist->occupation}}</option>'+
                @endif
            @endforeach
            '</select>';

        var sCity =  '<select class="form-control" name="q" id="q">' +
                @foreach ($speclist->unique('city')->values()->sortBy('city')->all() as $specialist)
                    '<option value="{{$specialist->city}}" >{{$specialist->city}}</option>'+
                @endforeach
                    '</select>';
    </script>
    @php
        $params = request()->input();
        $urls = [];
        $dict = ['id', 'name', 'occupation', 'city', 'is_anonymous', 'email', 'updated_at'];
        foreach ($dict as $value) {
        $params['order'] = $value;
        $params['dir'] = $fdir[$value];
        $urls[$value] = route('admin.specialists.index', $params);
        }
    @endphp
    @if(auth()->user()->hasAccess('admin.specialists.create'))
        <div class="col-md-2">
            <form method="GET" action="{{route('admin.specialists.create')}}">
                <div class="form-group">
                    <input type="submit" class="btn btn-new form-control" value="Nieuwe specialist" />
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
                        <option value="name">Naam</option>
                        <option value="occupation">Beroep</option>
                        <option value="city">Plaats</option>
                        <option value="is_anonymous">Betaald</option>
                        <option value="email">E-Mail</option>
                    </select>
                </div>
                <div class="form-group" id="sq"></div>
                <div class="form-group">
                    <input type="submit" class="btn btn-edit form-control" value="Zoeken" />
                </div>
            </form>
        </div>
    @if (\Session::has('success'))
        <div class="col-md-4" id="msg">
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
            <th class="text-center" colspan="10">Specialisten <small>({{$specialists->firstItem() }} - {{ $specialists->lastItem()}} van de  {{$specialists->total()}}) [Totaal: {{\App\Models\Specialist::count()}}]</small></th>
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
                <a href="{{$urls['name']}}">Naam
                    @if($fdir['name'] == 'desc' && $column  == 'name')
                        <i class="fa fa-sort-asc" aria-hidden="true"></i>
                    @elseif($fdir['name'] == 'asc' && $column == 'name')
                        <i class="fa fa-sort-desc" aria-hidden="true"></i>
                    @else
                        <i class="fa fa-sort" aria-hidden="true"></i>
                    @endif
                </a>
            </th>
            <th>
                <a href="{{$urls['occupation']}}">Beroep
                    @if($fdir['occupation'] == 'desc' && $column == 'occupation')
                        <i class="fa fa-sort-asc" aria-hidden="true"></i>
                    @elseif($fdir['occupation'] == 'asc' && $column == 'occupation')
                        <i class="fa fa-sort-desc" aria-hidden="true"></i>
                    @else
                        <i class="fa fa-sort" aria-hidden="true"></i>
                    @endif
                </a>
            </th>
            <th>
                <a href="{{$urls['city']}}">Plaats
                    @if($fdir['city'] == 'desc' && $column == 'city')
                        <i class="fa fa-sort-asc" aria-hidden="true"></i>
                    @elseif($fdir['city'] == 'asc' && $column == 'city')
                        <i class="fa fa-sort-desc" aria-hidden="true"></i>
                    @else
                        <i class="fa fa-sort" aria-hidden="true"></i>
                    @endif
                </a>
            </th>
            <th>
                <a href="{{$urls['is_anonymous']}}">Betaald
                    @if($fdir['is_anonymous'] == 'desc' && $column == 'is_anonymous')
                        <i class="fa fa-sort-asc" aria-hidden="true"></i>
                    @elseif($fdir['is_anonymous'] == 'asc' && $column == 'is_anonymous')
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
            <th>Bewerken</th>
            <th>Verwijderen</th>
        </tr>
        </thead>
        <tbody>
        @foreach($specialists as $specialist)
            <tr>
                <td>{{$specialist->id}}</td>
                <td><a href="{{route('admin.specialists.show', $specialist->id)}}"> {{$specialist->name}} </a></td>
                <td style=>{!! strlen($specialist->occupation) < 28 ? $specialist->occupation : "<span title='".$specialist->occupation."''>".substr($specialist->occupation, 0 , 20)."...</span>"!!}</td>
                <td>{{$specialist->city}}</td>
                <td>{{!$specialist->is_anonymous ? "Ja" : "Nee"}}</td>
                <td>{{$specialist->email}}</td>
                <td>
                    @if(auth()->user()->hasAccess('admin.specialists.edit'))
                        <form method="GET" action="{{route('admin.specialists.edit', $specialist->id)}}">
                            <input type="submit" class="btn btn-edit" value="Bewerken" />
                        </form>
                    @else
                        Onvoldoende rechten
                    @endif
                </td>
                <td>
                    @if(auth()->user()->hasAccess('admin.specialists.destroy'))
                        <form method="POST" action="{{route('admin.specialists.destroy', $specialist->id)}}" onsubmit="return confirm('Weet je zeker dat je {{$specialist->username}} wilt verwijderen?\nDEZE BEWERKING KAN NIET TERUGGEDRAAID WORDEN')">
                            {{csrf_field()}}
                            {{method_field('delete')}}
                            <input type="submit" class="btn btn-destroy" value="Verwijderen"  />
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
        @if($specialists->total() > 10)
            @for($i = 0 ; $i < 10 - count($specialists); $i++)
                <tr>
                    <td>&nbsp;</td>
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
                {{$specialists->appends($_GET)->links()}}
            </td>
        </tr>
        </tfoot>
    </table>
    @if(auth()->user()->hasAccess('admin.specialists.destroy') && auth()->user()->hasAccess('admin.specialists.restore'))
        <table class="table" id="table2toggle">
            <thead>
            <tr>
                <th class="text-center toggletable2" colspan="10">Verwijderde specialisten [{{$deletedSpecialists->total()}}] [{{10 - count($deletedSpecialists)}}]<i class="fa fa-caret-down" aria-hidden="true"></i> </th>
            </tr>
            </thead>
        </table>
        <div class="col-md-12" id="table2wrapper">
            <table class="table table-striped usertable" id="table2">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Naam</th>
                    <th>Adres</th>
                    <th>Stad</th>
                    <th>Postcode</th>
                    <th>Verwijderd door</th>
                    <th>Verwijderd op</th>
                    <th>Herstellen</th>
                    <th>Vergeten</th>
                </tr>
                </thead>
                <tbody>
                @foreach($deletedSpecialists as $specialist)
                    <tr>
                        <td>{{$specialist->id}}</td>
                        <td><a href="{{route('admin.specialists.show', $specialist->id)}}"> {{$specialist->name}} </a></td>
                        <td>{{$specialist->address}}</td>
                        <td>{{$specialist->city}}</td>
                        <td>{{$specialist->zip}}</td>
                        <td>
                            @php
                                $logentry = \Spatie\Activitylog\Models\Activity::where('subject_type', "specialists")->where("subject_id", "{$specialist->id}")->first();
                                $causer = $logentry->causer;
                            @endphp
                            {{$causer->username}}
                        </td>
                        @php setlocale(LC_TIME, 'Dutch'); @endphp
                        <td>{{$specialist->deleted_at ? $specialist->deleted_at->formatLocalized('%d %B %Y') : "Niet bekend"}}</td>
                        <td>
                            @if(auth()->user()->hasAccess('admin.specialists.restore'))
                                <form method="POST" action="{{route('admin.specialists.restore', $specialist->id)}}">
                                    {{method_field('patch')}}
                                    {{csrf_field()}}
                                    <input type="submit" class="btn btn-new" value="Herstellen" />
                                </form>
                            @else
                                Onvoldoende rechten
                            @endif
                        </td>
                        <td>
                            @if(auth()->user()->hasAccess('admin.specialists.forget'))
                                <form method="POST" action="{{route('admin.specialists.forget', $specialist->id)}}" onsubmit="return confirm('Weet je zeker dat je {{$specialist->name}} wilt vergeten?\nDEZE BEWERKING KAN NIET TERUGGEDRAAID WORDEN')">
                                    {{csrf_field()}}
                                    {{method_field('delete')}}
                                    <input type="submit" class="btn btn-destroy" value="Vergeten"  />
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                @if($deletedSpecialists->total() > 10)
                    @for($i = 0 ; $i < 10 - count($deletedSpecialists); $i++)
                        <tr>
                            <td>&nbsp;</td>
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
                        {{$deletedSpecialists->appends($_GET)->links()}}
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    @endif

@endsection
@section('scripts')
    @parent
@endsection