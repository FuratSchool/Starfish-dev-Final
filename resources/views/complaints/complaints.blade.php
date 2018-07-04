@extends('layouts.master')

@section('styles')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('css/search.css') }}"/>
@endsection
@section('title')
    Alle Klachten
@endsection
@section('main')
    <div class="col-md-12">
        {!! Breadcrumbs::render('complaints') !!}
    </div>
    <div class="col-md-12" id="wrapper" onload="address_geocoder()">
        <div class="col-md-12" id="contentfix">
            <div class="row">
                <div class="col-md-12">
                    @if($complaints->count() > 0 )
                        @foreach($complaints->chunk(3) as $row)
                            <div class="row">
                                @foreach($row as $complaint)
                                    <div class="col-md-4 spec"  data-href="/klacht/{{$complaint->name}}" >
                                        <div class="box">
                                            <div class="col-md-4">
                                                <img alt="{{$complaint->name}}" src="{{urldecode(asset('images/avatars/complaints/'.$complaint->complaint_image)) }}" class="spec_image">
                                            </div>
                                            <div class="col-md-8 " id="specinfo">
                                                <p class="text-center">{{$complaint->name}}</p>
                                                <p class="text-center">{{$complaint->description}}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                        <div class="text-center">
                            {{$complaints->appends(request()->input())->links()}}
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
