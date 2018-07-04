@extends('layouts.admin')
@section('styles')
    @parent
    <style>
        .messageBox {
            margin-left: 10%;
            width: 80%;
            height: 80%;
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
        }
    </style>
@endsection
@section('title')
    Niet beschikbaar
@endsection
@section('main')
    <div class="messageBox">
        <h1  style="color:red; font-weight: 900; font-size: 6em; text-align: center">DEZE FUNCTIE IS (NOG) NIET BESCHIKBAAR</h1>
    </div>
@endsection
@section('scripts')
    @parent

@endsection
