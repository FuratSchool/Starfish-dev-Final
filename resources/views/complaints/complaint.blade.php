@extends('layouts.master')
@section('title')
    {{$complaint->name}}
@endsection
@section('styles')
    @parent
    <link rel="stylesheet" type="text/css" href="{{asset('css/specialist.css')}}"
@endsection
@section('main')
    <div class="first-section">
        <div class="row">
            <div class="col-md-5">
                <img alt="{{$complaint->name}}" class="img-circle center-block"
                     src="{{substr($complaint->complaint_image, 6)}}"
                     width="80%">
            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <h2 class=" Starfish-Logo-with-text-blue">{{$complaint->name}} </h2>
                        <p><b>Beschrijving </b>{{$complaint->description}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
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