@extends('layouts.admin')
@section('styles')
    @parent
@endsection
@section('title')
    Klachten
 @endsection
@section('main')
    @php
        $params = request()->input();
        $urls = [];
        $dict = ['id', 'name', 'short_description', 'updated_at'];
        foreach ($dict as $value) {
        $params['order'] = $value;
        $params['dir'] = $fdir[$value];
        $urls[$value] = route('admin.complaints.index', $params);
        }
    @endphp
    @if(auth()->user()->hasAccess('admin.complaints.create'))
        <div class="col-md-2">
            <form method="GET" action="{{route('admin.complaints.create')}}">
                <div class="form-group">
                    <input type="submit" class="btn btn-new form-control" value="Nieuwe klacht" />
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
            <th class="text-center" colspan="10">Klachten <small>({{$complaints->firstItem() }} - {{ $complaints->lastItem()}} van de  {{$complaints->total()}}) [Totaal: {{\App\Models\Complaint::count()}}]</small></th>
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
                <a href="{{$urls['short_description']}}">Korte Beschrijving
                    @if($fdir['short_description'] == 'desc' && $column  == 'short_description')
                        <i class="fa fa-sort-asc" aria-hidden="true"></i>
                    @elseif($fdir['short_description'] == 'asc' && $column == 'short_description')
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
        @foreach($complaints as $complaint)
            <tr>
                <td>{{$complaint->id}}</td>
                <td><a href="{{route('admin.complaints.show', $complaint->id)}}"> {{$complaint->name}} </a></td>
                <td>{{$complaint->short_description}}</td>
                <td>
                    @if(auth()->user()->hasAccess('admin.complaints.edit'))
                        <form method="GET" action="{{route('admin.complaints.edit', $complaint->id)}}">
                            <input type="submit" class="btn btn-edit" value="Bewerken" />
                        </form>
                    @else
                        Onvoldoende rechten
                    @endif
                </td>
                <td>
                    @if(auth()->user()->hasAccess('admin.complaints.destroy'))
                        <form method="POST" action="{{route('admin.complaints.destroy', $complaint->id)}}" onsubmit="return confirm('Weet je zeker dat je {{$complaint->name}} wilt verwijderen?\nDEZE BEWERKING KAN NIET TERUGGEDRAAID WORDEN')">
                            {{csrf_field()}}
                            {{method_field('delete')}}
                            <input type="submit" class="btn btn-destroy" value="Verwijderen"  />
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
        @if($complaints->total() > 10)
            @for($i = 0 ; $i < 10 - count($complaints); $i++)
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
                {{$complaints->appends($_GET)->links()}}
            </td>
        </tr>
        </tfoot>
    </table>
@endsection
@section('scripts')
    @parent
@endsection