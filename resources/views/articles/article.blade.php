@extends('layouts.master')
@section('title')
    {{$article->name}}
@endsection
@section('styles')
    @parent
@endsection
@section('main')
    <div class="first-section">
        <div class="container">
        <div class="card">
            <div class="row">
                <div class="col-md-6">
                    <div class="card-body" style="text-align: center">
                        <h1 class="card-title Starfish-Logo-with-text-blue">{{$article->name}}</h1>
                        <p class="text-center">{{$article->description}}</p>

                    </div>
                </div>
                <div class="col-md-6">
                    <img alt="{{$article->name}}" class="card-img articleCardImage"
                         src="{{substr($article->article_image, 6)}}"
                         style="height: 100%">
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
@endsection