@extends('layouts.master')
@section('title')
@endsection
@section('styles')
    @parent
    <link rel="stylesheet" type="text/css" href="{{asset('css/specialist.css')}}">
@endsection
@section('main')
    <div class="first-section">
        <div class="card homepage-card-Gray">
            <div class="card-body">
                <p class="Starfish-Logo-with-text-blue Roboto-light text-center"> Health</p>
                <p class="Roboto-light text-center"> fficitur rhoncus vitae eget lectus. Cras augue ligula, aliquam ut
                    enim ut, feugiat imperdiet sem. Integer sed mi quis nisl eleifend interdum.</p>
            </div>
        </div>
    </div>

    <div class="container second-section">
        <div class="container">
            <div class="card">
                <div class="row">
                    <div class="col-md-3">
                        <img class="card-img img-responsive "
                             src="{{ asset('../images/globe.png') }}"
                             alt="Card image">
                    </div>
                    <div class="col-md-9">
                        <div class="card-body">
                            <h4 class="card-title Starfish-Logo-with-text-blue">Mijn Wereld.</h4>
                            <p class="card-text">fficitur rhoncus vitae eget lectus. Cras augue ligula, aliquam
                                ut enim ut, feugiat imperdiet sem. Integer sed mi quis nisl eleifend
                                interdum.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="row">
                    <div class="col-md-3">
                        <img class="card-img img-responsive "
                             src="{{ asset('../images/heart.jpg') }}"
                             alt="Card image">
                    </div>
                    <div class="col-md-9">
                        <div class="card-body">
                            <h4 class="card-title Starfish-Logo-with-text-blue">Mijn Gevoel</h4>
                            <p class="card-text">fficitur rhoncus vitae eget lectus. Cras augue ligula, aliquam
                                ut enim ut, feugiat imperdiet sem. Integer sed mi quis nisl eleifend
                                interdum.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="row">
                    <div class="col-md-3">
                        <img class="card-img img-responsive "
                             src="{{ asset('../images/yoga.png') }}"
                             alt="Card image">
                    </div>
                    <div class="col-md-9">
                        <div class="card-body">
                            <h4 class="card-title Starfish-Logo-with-text-blue">Mijn Gevoel</h4>
                            <p class="card-text">fficitur rhoncus vitae eget lectus. Cras augue ligula, aliquam
                                ut enim ut, feugiat imperdiet sem. Integer sed mi quis nisl eleifend
                                interdum.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="row">
                    <div class="col-md-3">
                        <img class="card-img img-responsive "
                             src="{{ asset('../images/meditation.png') }}"
                             alt="Card image">
                    </div>
                    <div class="col-md-9">
                        <div class="card-body">
                            <h4 class="card-title Starfish-Logo-with-text-blue">Mijn Gevoel</h4>
                            <p class="card-text">fficitur rhoncus vitae eget lectus. Cras augue ligula, aliquam
                                ut enim ut, feugiat imperdiet sem. Integer sed mi quis nisl eleifend
                                interdum.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="row">
                    <div class="col-md-3">
                        <img class="card-img img-responsive "
                             src="{{ asset('../images/brain.png') }}"
                             alt="Card image">
                    </div>
                    <div class="col-md-9">
                        <div class="card-body">
                            <h4 class="card-title Starfish-Logo-with-text-blue">Mijn Gevoel</h4>
                            <p class="card-text">fficitur rhoncus vitae eget lectus. Cras augue ligula, aliquam
                                ut enim ut, feugiat imperdiet sem. Integer sed mi quis nisl eleifend
                                interdum.</p>
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