@extends('layouts.master')
@section('title')
    {{$spec->name}}
@endsection
@section('styles')
    @parent
    <link rel="stylesheet" type="text/css" href="{{asset('css/specialist.css')}}"
@endsection
@section('main')
    <div class="col-md-12">
       {!! Breadcrumbs::render('specialist', $spec) !!}
    </div>
    <div class="col-md-12" id="wrapper">
        <div class="col-md-3 ">
            <img alt="{{$spec->name}}" class="specimage" src="{{urldecode(asset('images/avatars/specialists/'.$spec->profile_image)) }}">
            <div class="bg-white text-center contact-info">
                <p>{{$spec->company}}</p>
                <p>{{$spec->address}}</p>
                <p>{{$spec->postal_code}}, {{$spec->city}}</p>
                <p>{{$spec->phone_number}} / {{$spec->mobile_phone}}</p>
                <p>{{$spec->email}}</p>
                <p>{{$spec->url}}</p>
            </div>
            <div class="col-md-6">
                <input type="hidden" id="map_lat" value="{{$spec->map_lat}}">
                <input type="hidden" id="map_lng" value="{{$spec->map_lng}}">
                <div id="gmap"></div>
            </div>
            <div class="col-md-6">
                <div id="pano"></div>
            </div>
        </div>
        <div class="col-md-6 bg-white" id="contentfix">
            <h1 class="specname">{{$spec->name}} </h1>
            <h2 class="spectitle">{{$spec->occupation}}</h2>
            <p><b>Mijn Verhaal: </b>{{$spec->story}}</p>
            <p><b>Mijn Missie: </b>{{$spec->mission}}</p>
        </div>
        <div class="col-md-3">
            <div class="col-md-12">
                <div class="col-md-12 bg-sand list-block" style="z-index: 1">
                    <h3  class="specialismtitle">Werkgebieden</h3>
                    <ul class="star-list">
                        @if(!$spec->specialisms->isEmpty())
                            @foreach($spec->specialisms as $specialism)
                                <li><a href="/werkgebied/{{$specialism->name}}">{{$specialism->name}}</a></li>
                            @endforeach
                        @else
                            <li>Geen werkgebied</li>
                        @endif
                    </ul>
                </div>
                <hr>
                @if(!$spec->images->count() == 0)
                    <div id="myCarousel" class="carousel slide" data-ride="carousel" style="z-index: 0">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            @for($y = 0; $y < $spec->images->count(); $y++)
                                @if($y == 0)
                                    <li data-target="#myCarousel" data-slide-to="{{$y}}" class="active"></li>
                                @else
                                    <li data-target="#myCarousel" data-slide-to="{{$y}}"></li>
                                @endif
                            @endfor
                        </ol>
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner">
                            <?php $firstit = true ?>
                            @foreach($spec->images as $image)
                                @if($firstit)
                                    <div class="item active">
                                        {{$firstit = false}}
                                        @else
                                            <div class="item">
                                                @endif
                                                <img src="{{urldecode(asset('images/avatars/specialists/images/'.$image->path)) }}" alt="" width="100%">
                                                <div class="carousel-caption">
                                                    <p>{{$image->caption}}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                        <!-- Left and right controls -->
                                            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                                                <span class="glyphicon glyphicon-chevron-left"></span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                                                <span class="glyphicon glyphicon-chevron-right"></span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                    </div>
                        </div>
                    </div>
                @else
                            <div class="col-md-12 bg-light list-block" id="contentfix">
                            <h2>Deze specialist heeft geen afbeeldingen</h2>
                            </div>
                        @endif
                <hr>
                    <div class="col-md-12 bg-sand list-block">
                        <h3  class="specialismtitle">DIVERSEN</h3>
                        <ul class="star-list">
                            @if(!$spec->diverse->isEmpty())
                                @foreach($spec->diverse as $diverse)
                                    <li><a href="{{$diverse->target}}">{{$diverse->name}}</a></li>
                                @endforeach
                            @else
                                <li>Geen diversen</li>
                            @endif
                        </ul>
                    </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCwRFzYMQjJX3TbhiQ7dUXrdKKknl0gApM&callback=initialize">
    </script>
    <script src="{{asset('js/specialistmap.js')}}"></script>
@endsection