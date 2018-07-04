@extends('frame')

@section('styles')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('css/landing.css') }}"/>
@endsection

@section('body')

    <div class="col-md-12 padfix-r hidden-xs" id="cookie_popup">
        <div class="col-md-10">
            <p>
                Deze website maakt gebruik van cookies, deze worden gebruikt voor een optimale gebruikerservaring
                <a href="https://www.consumentenbond.nl/internet-privacy/wat-zijn-cookies" >Meer info</a>
            </p>
        </div>
        <div class="col-md-2 padfix-r">
                <button class="cbtn pull-right" id="cookie_accept">Accepteer</button>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-6 col-xs-12 contentfix">
            <div class=" contentblock ">
                <h2 class="text-center cbheading ">Health & Food</h2>
            </div>
            <div class="contentblock">
                <h2 class="text-center cbheading">Specialisten aan het woord</h2>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-xs-12 contentfix">
            <div class=" contentblock doubleblock">
                <h1 class="text-center cbheading">BODY, MIND & SOUL</h1>
                <a class="center-block" href="{{ route('landing') }}"><img class="center-block clogo" src="{{ asset('images/logo.png') }}"/></a>
                <div class="row">
                    @include('layouts.errors')
                    <form action="{{Route('searchDirector')}}" method="get" class="form-horizontal">
                        <div class="col-md-12">
                            <div class="col-md-3">
                                <label for="list">Ik wil zoeken op:</label>
                                <select class="form-control input-lg" id="list" name="list">
                                    <option value="complaints">Klacht</option>
                                    <option value="disciplines">Werkgebied</option>
                                </select>
                            </div>
                            <div class="col-md-7">
                                <label  for="search-query">Zoekterm</label>
                                <input type="text" class="form-control input-lg" id="q" name="q" list="complaints" placeholder="Zoeken..." required>
                                <datalist id="complaints">
                                    @php$complaints = \App\Models\Complaint::all(); @endphp
                                    @foreach($complaints as $complaint)
                                        <option value="{{$complaint->name}}">
                                    @endforeach
                                </datalist>
                                <datalist id="disciplines">
                                    @php$specialisms = \App\Models\Specialism::all() @endphp
                                    @foreach($specialisms as $specialism)
                                        <option value="{{$specialism->name}}">
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary btn-lg" style="margin-top: 25px;">Zoeken</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-xs-12 contentfix">
            <div class=" contentblock ">
                <h2 class="text-center cbheading ">Philosophy</h2>
            </div>
            <div class="contentblock">
                <h2 class="text-center cbheading">Shopping</h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-6 col-xs-12 contentfix">
            <div class=" contentblock doubleblock">
                <h2 class="text-center cbheading">Gebruikers aan het woord</h2>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12 contentfix">
            <div class=" contentblock ">
                <h2 class="text-center cbheading ">Plaatje</h2>
            </div>
            <div class="contentblock">
                <h2 class="text-center cbheading">Workshop & events</h2>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-xs-12 contentfix">
            <div class=" contentblock doubleblock">
                <h2 class="text-center cbheading">Externe links</h2>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script src="{{asset('js/landing.js')}}"></script>
@endsection