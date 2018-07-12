@extends('layouts.master')
@section('title')
    {{$therapy->name}}
@endsection
@section('styles')
    @parent
    <link rel="stylesheet" type="text/css" href="{{asset('css/specialist.css')}}">
@endsection
@section('main')

    <section class="first-section">
        <div class="card main-content">
            <div class="card-body">
                <section class="row">
                    <div class="col-md-4">
                        <img alt="{{$therapy->name}}" class="img-circle center-block"
                             src="{{substr($therapy->therapy_image , 6)}}"
                             width="80%">                    </div>
                    <div class="col-md-5">
                        <h3>{{$therapy->name}}</h3>
                        <p>{{$therapy->description}}</p>

                    </div>
                    <div class="col-md-3">
                        <div class="card complaints-card-Gray">
                            <div class="card-body">
                                <h3>Meer informatie :</h3>
                                <p>Beroepsverenigingen:</p>
                                <p>Verzekeringen</p>
                                <p>Artikelen</p>
                                <p>Ervarings verhalen</p>
                                <p>Workshop</p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="text-center Starfish-Logo-with-text-blue">Deze therapie kan o.a. helpen bij:</h4>
                <p class="text-center">Rugpijn - Nekpijn - Hoofdpijn - Ligamen
                    taire pijn - Gewrichtspijn - Trauma - Functi-
                    ionele admenhalingsklachten - Spierverte-
                    ringklachten - Allergie
                </p><br>
            </div>
        </div>
    </section>

    <div class="second-section">
        <div class="card homepage-card-Gray">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="card-title text-center Starfish-Logo-with-text-blue ">Waar kan je terecht met je
                            klacht?</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
@endsection