@extends('layouts.master')
@section('title')
    {{$spec->name}}
@endsection
@section('styles')
    @parent
    <link rel="stylesheet" type="text/css" href="{{asset('css/specialist.css')}}">
@endsection
@section('main')
    <div class="container">

        <div class="first-section" id="wrapper">
            <div class="card card-profile ">
                <div class="card-header">
                    <h5 class="Starfish-Logo-with-text-blue">{{$spec->occupation}}
                    </h5>
                </div>

                <div class="card-body ">

                    <section class="row">
                        <div class="col-md-3">
                            <img alt="{{$spec->name}}" class="card-img-left" src="{{substr($spec->profile_image, 6)}}"
                                 width="100%">
                        </div>
                        <div class="col-md-9">
                            <h5 class="Roboto-light">Naam: {{$spec->name}}</h5>

                            <h3 class="Starfish-Logo-with-text-blue">{{$spec->occupation}}</h3>
                            <p><b>Mijn Verhaal: </b>{{$spec->story}}</p>
                        </div>
                    </section>
                </div>
            </div>

        </div>
        <div class="card card-profile ">
            <div class="card-body ">
                <div class="justify-content-center">
                    <h5 class="Prices text-center Roboto-light Starfish-Logo-with-text-blue">Meer
                        informatie</h5>
                    <hr>
                </div>
                <section class="row">
                    <div class="col-md-4">
                        <h5 class="Roboto-light Starfish-Logo-with-text-blue">Plaatje</h5>

                    </div>
                    <div class="col-md-4">
                        <h5 class="Roboto-light Starfish-Logo-with-text-blue">Diverse</h5>
                        @if(!$spec->diverse->isEmpty())
                            @foreach($spec->diverse as $diverse)
                                Divers Document: <a href="{{substr($diverse->target, 6)}}">{{$diverse->name}}</a>
                            @endforeach
                        @else
                            <li>Geen diversen</li>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <h5 class="Roboto-light Starfish-Logo-with-text-blue">Contact</h5>
                        <p><b>Bedrijf</b> {{$spec->company}}</p>
                        <p><b>Adres</b> {{$spec->address}}</p>
                        <p><b>Stad:</b> {{$spec->postal_code}}, {{$spec->city}}</p>
                        <p><b>Nummer:</b> {{$spec->phone_number}} / {{$spec->mobile_phone}}</p>
                        <p><b>Email:</b> {{$spec->email}}</p>
                        <p><b>Website:</b> {{$spec->url}}</p>
                        <input type="hidden" id="map_lat" value="{{$spec->map_lat}}">
                        <input type="hidden" id="map_lng" value="{{$spec->map_lng}}">
                        <div id="gmap"></div>
                    </div>
                </section>
            </div>
        </div>
        <div class="card card-profile ">
            <div class="card-body ">
                <div class="justify-content-center">
                    <h5 class="Prices text-center Roboto-light Starfish-Logo-with-text-blue">Artikelen geschreven
                        door: {{$spec->name}}</h5>
                    <hr>
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