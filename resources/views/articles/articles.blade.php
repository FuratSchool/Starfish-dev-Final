@extends('layouts.master')

@section('styles')
    @parent
@endsection
@section('title')
    Alle Klachten
@endsection
@section('main')
    <div class="col-md-12 first-section" id="wrapper">

        <h2 class="Starfish-Logo-with-text-blue">Artikelen</h2>
        <hr>

        @if($articles->count() > 0 )
            @foreach($articles->chunk(3) as $row)
                <div class="row">
                    @foreach($row as $article)
                        <div class="col-md-4" data-href="/artikel/{{$article->name}}">
                            <div class="card">
                                <div class="row">
                                    <div class="col-md-5 ">
                                        <img alt="{{$article->name}}" class="card-img"
                                             src="{{substr($article->article_image, 6)}}"
                                             style="height: 100%">
                                    </div>
                                    <div class="col-md-7  ReceptCard" >
                                        <div class="card-body" style="text-align: center">
                                            <p class="text-center Starfish-Logo-with-text-blue">{{$article->name}}</p>
                                            <p class="text-center">{{$article->description}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endforeach
                </div>
            @endforeach


            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    {{ $articles->links() }}

                </ul>
            </nav>
        @else
            <h2 class="noresultshead text-center">Sorry, geen artikelen beschikbaar</h2>
        @endif

    </div>
@endsection
@section('scripts')
    @parent
    <script type="text/javascript" src="{{asset('js/cookie_handler.js')}}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.0/jquery.matchHeight-min.js"></script>
    <script type="text/javascript" src="{{ asset('js/search.js') }}"></script>
@endsection
