@extends('layouts.master')
@section('title')
    {{$complaint->name}}
@endsection
@section('styles')
    @parent
    <link rel="stylesheet" type="text/css" href="{{asset('css/specialist.css')}}"
@endsection
@section('main')
    <div class="col-md-12">
        {!! Breadcrumbs::render('complaint', $complaint) !!}
    </div>
    <div class="col-md-12" id="wrapper">
        <div class="col-md-9 bg-white" id="contentfix">
            <h1 class="specname">{{$complaint->name}} </h1>
            <p><b>Beschrijving </b>{{$complaint->description}}</p>
        </div>
        <div class="col-md-3">
            <div class="col-md-12">
                <div class="col-md-12 bg-sand list-block">
                    <h3  class="specialismtitle">dingen</h3>
                    <ul class="star-list">
                            <li>Geen dingen</li>
                    </ul>
                </div>
                <hr>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
@endsection