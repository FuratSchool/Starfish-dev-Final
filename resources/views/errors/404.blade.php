@php
@endphp
@extends('layouts.admin')
@section('title', 'Error: 404')
@section('main')
    <h1>Error 404: de opgevraagde pagina kon niet worden gevonden</h1>
    <h2><a href="{{route("admin.admin")}}">Terug naar de dashboard</a></h2>
@endsection
