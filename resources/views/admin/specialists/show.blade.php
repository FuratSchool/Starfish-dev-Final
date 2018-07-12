@extends('layouts.admin')
@section('styles')
    @parent
    <link rel="stylesheet" type="text/css" href="{{asset("css/BudEdit.css")}}">
    <script defer=""
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTMGtzFUNyyV3YICxx0aGCag3eryHThEc&callback=initMap"></script>
    <script type="text/javascript">
        var lat = {{$specialist->map_lat}};
        var lng = {{$specialist->map_lng}};

        function initMap() {
            var gmap = document.getElementById("gmap");
            var center = {lat: lat, lng: lng};
            var map = new google.maps.Map(gmap, {
                zoom: 17,
                center: center
            });

            var marker = new google.maps.Marker({
                position: center,
                map: map
            }, $(".card").matchHeight({remove: false}));

        }

    </script>
@endsection
@section('title')
    {{$specialist->name}}
@endsection
@section('main')
    <div class="col-md-12">
        @if (\Session::has('success'))
            <div class="msg msg-success msg-success-background">
                <span class="glyphicon glyphicon glyphicon-ok"></span> {!! \Session::get('success') !!}<i
                        class="fa fa-close" style="float: right" aria-hidden="true"
                        onclick="return $('#msg').remove()"></i>
            </div>
        @endif
    </div>
    <div class="col-md-12 mb-3">
        <div class="row">
            <div class="col-md-3" id="specData">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="card-title">Gegevens</h3>
                    </div>
                    <div class="card-body text-center">
                        <a href="{{substr($specialist->profile_image, 6)}}" target="_blank">
                            <img class="img-circle center-block" src="{{substr($specialist->profile_image, 6)}}"
                                 style="padding-top: 10px; height: 150px">
                        </a>
                        <dl>
                            <dt>Naam:</dt>
                            <dd>{{$specialist->name}}</dd>
                            @php
                                $modalTitle = "Verhaal van: ".$specialist->name;
                                $modalBody = $specialist->story;
                            @endphp
                            <dt>Verhaal:</dt>
                            <dd>
                                <button type="button" class="btn btn-edit" data-toggle="modal"
                                        data-target="#storyViewer">
                                    Weergeven
                                </button>
                            </dd>
                            <dt>Beroep:</dt>
                            <dd>{{$specialist->occupation}}</dd>
                            <dt>Address:</dt>
                            <dd>{{$specialist->address}}</dd>
                            <dt>Stad:</dt>
                            <dd>{{$specialist->city}}</dd>
                            <dt>Postcode:</dt>
                            <dd>{{$specialist->postal_code}}</dd>
                            <dt>Type:</dt>
                            <dd>
                                @if($specialist->is_anonymous)
                                    Betaald
                                @else
                                    Niet betaald
                                @endif
                            </dd>
                            @php //TODO Add payment expiration date (Visibility: admin [3]) + auto payment reminders + auto setback to unpayed (CRON)@endphp
                        </dl>
                        @if( auth()->user()->hasAccess('admin.specialists.edit'))
                            <div class="text-center">
                                <form class="col-md-12" method="GET"
                                      action="{{route('admin.specialists.edit', $specialist->id)}}">
                                    <div class="form-group text-center">
                                        <input type="submit" class="form-control btn btn-edit" value="Bewerken"/>
                                    </div>
                                </form>
                                @if(!$specialist->trashed() and Auth::user()->hasAccess('admin.specialists.destroy'))
                                    <form class="col-md-12" method="POST"
                                          action="{{route('admin.specialists.destroy', $specialist->id)}}"
                                          onsubmit="return confirm('Weet je zeker dat je {{$specialist->name}} wilt verwijderen?\nDEZE BEWERKING KAN NIET TERUGGEDRAAID WORDEN')">
                                        {{csrf_field()}}
                                        {{method_field('delete')}}
                                        <div class="form-group text-center">
                                            <input type="submit" class="form-control btn btn-destroy"
                                                   value="Verwijderen"/>
                                        </div>
                                    </form>
                                @endif
                                @if($specialist->trashed())
                                    @if(auth()->user()->hasAccess('admin.specialists.restore'))
                                        <form class="col-md-12" method="POST"
                                              action="{{route('admin.specialists.restore', $specialist->id)}}">
                                            {{method_field('patch')}}
                                            {{csrf_field()}}
                                            <div class="form-group text-center">
                                                <input type="submit" class="form-control btn btn-new"
                                                       value="Herstellen"/>
                                            </div>
                                        </form>
                                    @endif
                                    @if(auth()->user()->hasAccess('admin.specialists.forget'))
                                        <form class="col-md-12" method="POST"
                                              action="{{route('admin.specialists.forget', $specialist->id)}}"
                                              onsubmit="return confirm('Weet je zeker dat je {{$specialist->name}} wilt vergeten?\nDEZE BEWERKING KAN NIET TERUGGEDRAAID WORDEN')">
                                            {{csrf_field()}}
                                            {{method_field('delete')}}
                                            <div class="form-group text-center">
                                                <input type="submit" class="form-control btn btn-destroy"
                                                       value="Vergeten"/>
                                            </div>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="card-title">Op de kaart</h3>
                    </div>
                    <div class="card-body" id="specMap" style="height: 100%">
                        <div class="col-md-12" id="gmap" style="height: 90%">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 mb-3" id="specSpecialisms">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title">Werkgebieden</h3>
            </div>
            <div class="card-body">

                <table class="table table-striped" id="log">
                    <thead>
                    <tr>
                        <th>Naam</th>
                        <th>Beschrijving</th>
                        <th>Prio</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($specialist->specialisms as $specialism)
                        <tr>
                            <td><a href="{{route("admin.specialisms.show", $specialism)}}"
                                   style="color: white; text-decoration: underline; font-weight: bolder"> {{$specialism->name}} </a>
                            </td>
                            <td>{{$specialism->description}}</td>
                            <td>{{$specialism->pivot->prio}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-12 mb-3" id="specImages">
        <div class="card" id="specImages">
            <div class="card-header bg-primary">
                <h3 class="card-title">Afbeeldingen</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="log">
                    <thead>
                    <tr>
                        <th>Bestand</th>
                        <th>Bijschrift</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($specialist->images as $image)
                        <tr>
                            <td><a href="{{substr($image->path, 6)}}" target="_blank"
                                   style="hyphens: auto ;color: white; text-decoration: underline; font-weight: bolder"> {{preg_replace("/(?:\S+)(\S{32}\.\S{1,4}$)/", "$1", $image->path)}}</a>
                            </td>
                            <td>{{$image->caption}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-12 mb-3" id="specDiverse">
        <div class="card" id="specDiverse">
            <div class="card-header bg-primary">
                <h3 class="card-title">Diverse</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="log">
                    <thead>
                    <tr>
                        <th>Bestand</th>
                        <th>Naam</th>
                        <th>Type</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($specialist->diverse as $diverse)
                        <tr>
                            <td><a href="{{substr($diverse->target, 6)}}" target="_blank"
                                   style="hyphens: auto ;color: white; text-decoration: underline; font-weight: bolder"
                                   download> {{preg_replace("/(?:\S+\\\)(\S+$)/", "$1", $diverse->target)}}</a></td>

                            <td>{{$diverse->name}}</td>
                            <td>{{strtoupper(preg_replace("/(?:\S+\/)(\S+)$/", "$1",$diverse->type))}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    @include("modals.neditor")
@endsection
@section('scripts')
    @parent
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.0/jquery.matchHeight-min.js"></script>

@endsection
