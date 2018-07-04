@extends('base')

@section('styles')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset("css/specialist.css") }}"/>
@endsection

@section('title', $title)

@section('home_url', route('landing'))
@section('main')
    <div class="col-xs-6 col-md-4 col-md-offset-1">
        <div class="row">
            <div class="col-xs-4">
                <div class="">
                    <div id="gMaps"></div>
                    <script>
                        function initMap() {
                            var myLatLng = {lat: {{ $spec->map_lat }}, lng: {{ $spec->map_lng }}};
                                var map = new google.maps.Map(document.getElementById('gMaps'), {
                                zoom: 4,
                                center: myLatLng
                            });
                            var marker = new google.maps.Marker({
                                position: myLatLng,
                                map: map,
                                title: '{{ $spec->name }}'
                            });
                        }
                    </script>
                    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA15Jp14XMy02oaTBfFmproOorm3QFjG5E&callback=initMap"></script>
                </div>
                <div class="text-address">
                    <p class="text-street">{{ $spec->address }},</p>
                    <p class="text-city">{{ $spec->city }},</p>
                    <p class="text-postal">{{ $spec->postal_code }}</p>
                </div>
            </div>
            <div class="profile-picture col-xs-8">
                <img src="{{ asset("images/avatars/specialists/".$spec->profile_image) }}" />
            </div>
        </div>
    </div>
    <div class="col-xs-6">
        <h1>{{ $spec->name }}</h1>
        <p class="text-occupation">{{ $spec->occupation }}</p>
        <p class="text-specialities">{{ $spec->specialization }}</p>
        <p class="text-story">{!! $spec->story !!}</p>
        <hr/>
        <p class="text-mission">{{ $spec->mission }}</p>
        <p class="text-phone">{{ $spec->phone_number }}</p>
        <p class="text-email">{{ $spec->email }}</p>
        <a class="text-urls" target="_blank" href="https://{{$spec->url}}">{{ $spec->url }}</a>
    </div>
@endsection