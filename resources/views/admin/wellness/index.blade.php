@extends('layouts.admin')
@section('styles')
    @parent
@endsection
@section('title')
    Wellness
 @endsection
@section('main')
    @php
        $params = request()->input();
        $urls = [];
        $dict = ['id', 'name', 'short_description', 'updated_at'];
        foreach ($dict as $value) {
        $params['order'] = $value;
        $params['dir'] = $fdir[$value];
        $urls[$value] = route('admin.wellness.index', $params);
        }
    @endphp

    @if(auth()->user()->hasAccess('admin.wellness.create'))
        <div class="col-md-2">
            <form method="GET" action="{{route('admin.wellness.create')}}">
                <div class="form-group">
                    <input type="submit" class="btn btn-new form-control" value="Nieuw wellness" />
                </div>
            </form>
        </div>
    @endif

    <table class="table table-striped usertable" id="table1">
        <thead>
        <tr>
            <th class="text-center" colspan="10">Wellness
                <small>({{$wellness->firstItem() }} - {{ $wellness->lastItem()}} van de {{$wellness->total()}})
                    [Totaal: {{\App\Models\Wellness::count()}}]
                </small>
            </th>
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
        @foreach($wellness as $wellnesses)
            <tr>
                <td>{{$wellnesses->id}}</td>
                <td><a href="{{route('admin.wellness.show', $wellnesses->id)}}"> {{$wellnesses->name}} </a></td>
                <td>{{$wellnesses->short_description}}</td>
                <td>
                    @if(auth()->user()->hasAccess('admin.wellness.edit'))
                        <form method="GET" action="{{route('admin.wellness.edit', $wellnesses->id)}}">
                            <input type="submit" class="btn btn-edit" value="Bewerken"/>
                        </form>
                    @else
                        Onvoldoende rechten
                    @endif
                </td>
                <td>
                    @if(auth()->user()->hasAccess('admin.wellness.destroy'))
                        <form method="POST" action="{{route('admin.wellness.destroy', $wellnesses->id)}}"
                              onsubmit="return confirm('Weet je zeker dat je {{$wellnesses->name}} wilt verwijderen?\nDEZE BEWERKING KAN NIET TERUGGEDRAAID WORDEN')">
                            {{csrf_field()}}
                            {{method_field('delete')}}
                            <input type="submit" class="btn btn-destroy" value="Verwijderen"/>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
        @if($wellness->total() > 10)
            @for($i = 0 ; $i < 10 - count($wellness); $i++)
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
                {{$wellness->appends($_GET)->links()}}
            </td>
        </tr>
        </tfoot>
    </table>@endsection
@section('scripts')
    @parent
@endsection