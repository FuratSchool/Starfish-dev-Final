@extends('layouts.base')

@section('styles')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('css/landing.css') }}"/>
@endsection

@section('main')
    <div class="col-md-12 padfix-r hidden-xs" id="cookie_popup">
        <div class="col-md-10">
            <p>
                Deze website maakt gebruik van cookies, deze worden gebruikt voor een optimale gebruikerservaring
                <a href="https://www.consumentenbond.nl/internet-privacy/wat-zijn-cookies">Meer info</a>
            </p>
        </div>
        <div class="col-md-2 padfix-r">
            <button class="cbtn pull-right" id="cookie_accept">Accepteer</button>
        </div>
    </div>

    <section class="jumbotron homepage_landing_image">
        <div class="logo"><img src="../images/starfish-logo-zonder-text.png"></div>
        <div class="container">
            <h1>STARFISH</h1>
            <h4>The ultimate guide to health & wellbeing</h4>
            @include('layouts.errors')
            <form action="{{Route('searchDirector')}}" method="get" class="form-horizontal justify">
                <div class="row justify-content-center">

                    <div class="col-md-2">
                        <select class="form-control" id="list" name="list">
                            <option value="complaints">Klacht</option>
                            <option value="disciplines">Werkgebied</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="q" name="q" list="complaints"
                               placeholder="Zoek op klacht, therapie, onderwerp..." required>
                        <datalist id="complaints">
                            @php$complaints = \App\Models\Complaint::all(); @endphp
                            @foreach($complaints as $complaint)
                                <option value="{{$complaint->name}}">
                            @endforeach
                        </datalist>
                        <datalist id="disciplines">
                            @php$specialisms = \App\Models\Specialism::all() @endphp
                            @foreach($specialisms as $specialism)
                                <option value="{{$specialism->name}}">
                            @endforeach
                        </datalist>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-starfish-blue">Zoeken
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <nav class="navbar bg-white navigation-shadow sticky-top">
        <ul class="nav center-block justify-content-center nav-spacing">
            <li class="nav-item nav-item-color">
                <a class="nav-link " href="{{route('health')}}">Health</a>
            </li>
            <li class="nav-item nav-item-color">
                <a class="nav-link" href="{{route('philosophy')}}">Philosophy</a>
            </li>
            <li class="nav-item nav-item-color">
                <a class="nav-link" href="{{route('complaints')}}">Imbalance</a>
            </li>
            <li class="nav-item nav-item-color">
                <a class="nav-link" href="">Treatments</a>
            </li>

            <li class="nav-item dropdown nav-item-color">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Other
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Kids</a>
                    <a class="dropdown-item" href="#">Pets</a>
                    <a class="dropdown-item" href="#">Webshop</a>
                    <a class="dropdown-item" href="#">Contact</a>
                </div>
            </li>
        </ul>
    </nav>

    <sxxection class="container main-content">
        <div class="card-group">
            <div class="col-md-8">
                <section class="row">@if($articles->count() > 0 )
                        @foreach($articles->chunk(4) as $row)
                            @foreach($row as $article)
                                <div class="col-md-6">
                                    <div class="card card-position" data-href="/artikel/{{$article->name}}">
                                        <img alt="{{$article->name}}" class="card-img card-img-top"
                                             src="{{substr($article->article_image, 6)}}"
                                             style="max-height: 475px">
                                        <div class="card-body">
                                            <h5>{{$article->name}}</h5>
                                            <p>{{$article->short_description}}</p>
                                            <button class="btn btn-lees-meer">Meer info</button>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                </section>
            </div>
            <section class="col-md-4">
                @if($specs->count() > 0 )
                    @foreach($specs->chunk(1) as $row)
                        @foreach($row as $spec)
                            @if($spec->is_anonymous = 1 )
                                <div class="card homepage-card-Gray mb-3"
                                     data-href="/specialist/{{$spec->url_name}}">
                                    <img class="card-img-top specialist-image center-block"
                                         src="{{substr($spec->profile_image, 6)}}" alt="Card image cap">
                                    <div class="card-body">
                                        <div class="container">
                                            <div class="card-title card-title-Gray">
                                                <h5>{{$spec->name}}</h5>
                                            </div>
                                            <div class="card-title card-sub-title-Gray">
                                                <p>{{$spec->occupation}}</p>
                                            </div>
                                            <div class="card-content">
                                                <p>{{$spec->occupation}}</p>
                                                <p>{{$spec->address}}</p>
                                                <p>{{$spec->postal_code}} {{$spec->city}}</p>
                                                <p>{{$spec->mobile_phone}}</p>
                                            </div>
                                            <button class="btn btn-lees-meer-Gray justify-content-center">Meer info</button>

                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endforeach
                @else
                    <h2 class="noresultshead text-center">Sorry, geen zoekresultaten</h2>
                @endif
            </section>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                {{ $articles->links() }}

            </ul>
        </nav>
        @else
            <h2 class="noresultshead text-center">Sorry, geen artikelen beschikbaar</h2>
        @endif


    </sxxection>
@endsection
@section('scripts')
    @parent
    <script src="{{asset('js/landing.js')}}"></script>
@endsection