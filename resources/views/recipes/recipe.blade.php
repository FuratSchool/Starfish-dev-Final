@extends('layouts.master')
@section('title')
    {{$recipe->name}}
@endsection
@section('styles')
    @parent
@endsection
@section('main')
    <div class="first-section">
        <section class="container ">
            <h1 class="card-title Starfish-Logo-with-text-blue"> Recept: {{$recipe->name}}</h1>
            <hr>
            <div class="card ">
                <div class="row">
                    <div class="col-md-6  ReceptCard" >
                        <div class="card-body" style="text-align: center">
                            <h1 class="card-title Starfish-Logo-with-text-blue">{{$recipe->name}}</h1>
                            <p class="text-center">{{$recipe->ingredients}}</p>

                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <img alt="{{$recipe->name}}" class="receptCardImage center-block"
                             src="{{substr($recipe->primary_image, 6)}}">
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="second-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Bereiding</h6>
                            <p class="text-center">{{$recipe->preperation}}</p>

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card homepage-card-Gray">
                        <div class="card-body">
                            <h6 class="card-title">Weetjes</h6>
                            <p class="">{{$recipe->factoid}}</p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    @parent
@endsection