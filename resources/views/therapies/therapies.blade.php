@extends('layouts.master')
@section('title')
@endsection
@section('styles')
    @parent
    <link rel="stylesheet" type="text/css" href="{{asset('css/search.css')}}">
@endsection
@section('main')
    <div class="col-md-12 first-section" id="wrapper" onload="address_geocoder()">

        <h2 class="Starfish-Logo-with-text-blue">Treatments</h2>
        <hr>

        @if($therapies->count() > 0 )
            @foreach($therapies->chunk(3) as $row)
                <div class="row">
                    @foreach($row as $therapy)
                        <div class="col-md-4">
                            <div class="card" data-href="/treatment/{{$therapy->name}}">
                                <div class="row">
                                    <div class="col-md-5 ">
                                        <img alt="{{$therapy->name}}" class="card-img"
                                             src="{{substr($therapy->therapy_image, 6)}}" width="100%"
                                             style="height: 100%">
                                    </div>
                                    <div class="col-md-7  ReceptCard" >
                                        <div class="card-body" style="text-align: center">
                                            <p class="text-center Starfish-Logo-with-text-blue">{{$therapy->name}}</p>
                                            <p class="text-center">{{$therapy->description}}</p>
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
                    {{ $therapies->links() }}

                </ul>
            </nav>
        @else
            <h2 class="noresultshead text-center">Sorry, geen zoekresultaten</h2>
        @endif

    </div>

@endsection
@section('scripts')
    @parent
@endsection