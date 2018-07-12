@extends('layouts.admin')
@section('styles')
    @parent
@endsection
@section('title')
    Recepten
 @endsection
@section('main')
    @php
        $params = request()->input();
        $urls = [];
        $dict = ['id', 'name', 'ingredients','preperation', 'factoid', 'primary_image', 'secondary_image', 'updated_at'];
        foreach ($dict as $value) {
        $params['order'] = $value;
        $params['dir'] = $fdir[$value];
        $urls[$value] = route('admin.recipes.index', $params);
        }
    @endphp

    @if(auth()->user()->hasAccess('admin.recipes.create'))
        <div class="col-md-2">
            <form method="GET" action="{{route('admin.recipes.create')}}">
                <div class="form-group">
                    <input type="submit" class="btn btn-new form-control" value="Nieuw Recept" />
                </div>
            </form>
        </div>
    @endif

    <table class="table table-striped usertable" id="table1">
        <thead>
        <tr>
            <th class="text-center" colspan="10">Recepten
                <small>({{$recipes->firstItem() }} - {{ $recipes->lastItem()}} van de {{$recipes->total()}})
                    [Totaal: {{\App\Models\Recipe::count()}}]
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
                <a href="{{$urls['ingredients']}}">ingredients
                    @if($fdir['ingredients'] == 'desc' && $column  == 'ingredients')
                        <i class="fa fa-sort-asc" aria-hidden="true"></i>
                    @elseif($fdir['ingredients'] == 'asc' && $column == 'ingredients')
                        <i class="fa fa-sort-desc" aria-hidden="true"></i>
                    @else
                        <i class="fa fa-sort" aria-hidden="true"></i>
                    @endif
                </a>
            </th>
            <th>
                <a href="{{$urls['factoid']}}">Weetjes
                    @if($fdir['factoid'] == 'desc' && $column  == 'factoid')
                        <i class="fa fa-sort-asc" aria-hidden="true"></i>
                    @elseif($fdir['factoid'] == 'asc' && $column == 'factoid')
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
        @foreach($recipes as $recipe)
            <tr>
                <td>{{$recipe->id}}</td>
                <td><a href="{{route('admin.recipes.show', $recipe->id)}}"> {{$recipe->name}} </a></td>
                <td>{{$recipe->short_description}}</td>
                <td>
                    @if(auth()->user()->hasAccess('admin.recipes.edit'))
                        <form method="GET" action="{{route('admin.recipes.edit', $recipe->id)}}">
                            <input type="submit" class="btn btn-edit" value="Bewerken"/>
                        </form>
                    @else
                        Onvoldoende rechten
                    @endif
                </td>
                <td>
                    @if(auth()->user()->hasAccess('admin.recipes.destroy'))
                        <form method="POST" action="{{route('admin.recipes.destroy', $recipe->id)}}"
                              onsubmit="return confirm('Weet je zeker dat je {{$recipe->name}} wilt verwijderen?\nDEZE BEWERKING KAN NIET TERUGGEDRAAID WORDEN')">
                            {{csrf_field()}}
                            {{method_field('delete')}}
                            <input type="submit" class="btn btn-destroy" value="Verwijderen"/>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
        @if($recipes->total() > 10)
            @for($i = 0 ; $i < 10 - count($recipes); $i++)
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
                {{$recipes->appends($_GET)->links()}}
            </td>
        </tr>
        </tfoot>
    </table>@endsection
@section('scripts')
    @parent
@endsection