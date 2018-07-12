@extends('layouts.master')

@section('styles')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('css/search.css') }}"/>
@endsection
@section('title')
    Alle Specialisten
@endsection
@section('main')

    <div class="col-md-12 first-section" id=" contentfix" onload="address_geocoder()">

        <h2 class="Starfish-Logo-with-text-blue">Alle specialisten</h2>
        <hr>
        <div class="row">
            <div class="col-md-12">
                @if($specs->count() > 0 )
                    @foreach($specs->chunk(3) as $row)
                        <div class="row">
                            @foreach($row as $spec)
                                @if($spec->is_anonymous)
                                    <div class="col-md-4 ">
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <img alt="{{$spec->name}}"
                                                             src="{{ asset("images/anonymous.png") }}"
                                                             class="spec_image">

                                                    </div>
                                                    <div class="col-md-8 " id="specinfo">
                                                        <p class="text-right">{{$spec->name}}</p>
                                                        <p class="text-right">{{$spec->occupation}}</p>
                                                        <p class="text-right">{{$spec->address}}</p>
                                                        <p class="text-right">{{$spec->postal_code}} {{$spec->city}}</p>
                                                        <p class="text-right">{{$spec->mobile_phone}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-md-4" data-href="/specialist/{{$spec->url_name}}">
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-4 ">
                                                        <img alt="{{$spec->name}}"
                                                             src="{{substr($spec->profile_image, 6)}}"
                                                             class="spec_image specialist-image">
                                                    </div>
                                                    <div class="col-md-8 " id="specinfo">
                                                        <p class="text-right">{{$spec->name}}</p>
                                                        <p class="text-right">{{$spec->occupation}}</p>
                                                        <p class="text-right">{{$spec->address}}</p>
                                                        <p class="text-right">{{$spec->postal_code}} {{$spec->city}}</p>
                                                        <p class="text-right">{{$spec->mobile_phone}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                    <div class="text-center">
                        {{$specs->appends(request()->input())->links()}}
                    </div>
                @else
                    <h2 class="noresultshead text-center">Sorry, geen zoekresultaten</h2>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular.min.js"></script>
    <script type="text/javascript" src="{{asset('js/cookie_handler.js')}}"></script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTMGtzFUNyyV3YICxx0aGCag3eryHThEc&callback=initMap">
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.0/jquery.matchHeight-min.js"></script>
    <script type="text/javascript" src="{{ asset('js/search.js') }}"></script>
@endsection
