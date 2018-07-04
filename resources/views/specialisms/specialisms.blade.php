@extends('layouts.master')

@section('styles')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('css/search.css') }}"/>
@endsection
@section('title')
       Alle Werkgebieden
@endsection
@section('main')
    <div class="col-md-12">
        {!! Breadcrumbs::render('specialisms') !!}
    </div>
    <div class="col-md-12" id="wrapper" onload="address_geocoder()">
        <div class="col-md-12" id="contentfix">
            <div class="row">
                <div class="col-md-12">
                    @if($specs->count() > 0 )
                        @foreach($specs->chunk(3) as $row)
                            <div class="row">
                                @foreach($row as $spec)
                                    <div class="col-md-4 spec" data-href="/werkgebied/{{$spec->name}}">
                                        <div class="box">
                                          <h1>{{$spec->name}}</h1>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                        <div class="text-center">
                          {{$specs->appends(request()->input())->links()}}
                        </div>
                    @else
                        <h2 class="noresultshead text-center">Sorry,  geen zoekresultaten</h2>
                    @endif
                </div>
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
