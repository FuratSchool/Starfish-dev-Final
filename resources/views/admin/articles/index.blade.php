@extends('layouts.admin')
@section('styles')
    @parent
@endsection
@section('title')
    Artikelen
@endsection
@section('main')
    @php
        $params = request()->input();
        $urls = [];
        $dict = ['id', 'name', 'short_description', 'updated_at'];
        foreach ($dict as $value) {
        $params['order'] = $value;
        $params['dir'] = $fdir[$value];
        $urls[$value] = route('admin.articles.index', $params);
        }
    @endphp

    @if(auth()->user()->hasAccess('admin.articles.create'))
        <div class="col-md-2">
            <form method="GET" action="{{route('admin.articles.create')}}">
                <div class="form-group">
                    <input type="submit" class="btn btn-new form-control" value="Nieuwe klacht" />
                </div>
            </form>
        </div>
    @endif

    <table class="table table-striped usertable" id="table1">
        <thead>
        <tr>
            <th class="text-center" colspan="10">Artikelen
                <small>({{$articles->firstItem() }} - {{ $articles->lastItem()}} van de {{$articles->total()}})
                    [Totaal: {{\App\Models\Article::count()}}]
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
        @foreach($articles as $article)
            <tr>
                <td>{{$article->id}}</td>
                <td><a href="{{route('admin.articles.show', $article->id)}}"> {{$article->name}} </a></td>
                <td>{{$article->short_description}}</td>
                <td>
                    @if(auth()->user()->hasAccess('admin.articles.edit'))
                        <form method="GET" action="{{route('admin.articles.edit', $article->id)}}">
                            <input type="submit" class="btn btn-edit" value="Bewerken"/>
                        </form>
                    @else
                        Onvoldoende rechten
                    @endif
                </td>
                <td>
                    @if(auth()->user()->hasAccess('admin.articles.destroy'))
                        <form method="POST" action="{{route('admin.articles.destroy', $article->id)}}"
                              onsubmit="return confirm('Weet je zeker dat je {{$article->name}} wilt verwijderen?\nDEZE BEWERKING KAN NIET TERUGGEDRAAID WORDEN')">
                            {{csrf_field()}}
                            {{method_field('delete')}}
                            <input type="submit" class="btn btn-destroy" value="Verwijderen"/>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
        @if($articles->total() > 10)
            @for($i = 0 ; $i < 10 - count($articles); $i++)
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
                {{$articles->appends($_GET)->links()}}
            </td>
        </tr>
        </tfoot>
    </table>

@endsection
@section('scripts')
    @parent
@endsection