@extends('layouts.master')

@section('styles')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('css/search.css') }}"/>
@endsection
@section('title')
        Zoek: {{$keyword}}
@endsection
@section('main')
    <div class="col-md-12">
        {!! Breadcrumbs::render('searchSpecialism', $keyword) !!}
    </div>
    <div class="col-md-12" id="wrapper" onload="address_geocoder()">
        <div class="col-md-3 bg-light"  >
            <div class="col-md-12" id="contentfix">
                        <form method="get" action="#">
                            <div class="form-group">
                                <label for="q"><i>Discipline</i></label>
                                <input  type="text" name="q" id="q" list="disciplines" class="form-control" value="{{$keyword}}">
                                <datalist id="disciplines">
                                    @php$specialisms = \App\Models\Specialism::all() @endphp
                                    @foreach($specialisms as $specialism)
                                        <option value="{{$specialism->name}}">
                                    @endforeach
                                </datalist>
                            </div>
                            <hr>
                           <div class="form-group">
                               <label for="filter_zip" class="control-label"><i>Postcode</i></label>
                                <input type="text" name="filter_zip" id="filter_zip" class="form-control"  onblur="address_geocoder()" value="{{$filter_zip}}">
                           </div>
                            <div class="form-group">
                                <label for="filter_city" class="control-label"><i>Plaats</i></label>
                                <input type="text" name="filter_city" id="filter_city" class="form-control"  onblur="address_geocoder();" value="{{$filter_city}}">
                            </div>
                            <input type="hidden" value="{{$filter_lat}}" id="geolat" name="geolat">
                            <input type="hidden" value="{{$filter_lng}}" id="geolng" name="geolng">
                            <hr>
                            <div class="form-group" id="locationsearch">
                                <label for="radius">Afstand</label>
                                <input  name="radius" id="radius" type="range"  value="{{$radius}}" step="1" min="1" max="200"  oninput=" redrawCircle(); distance.value = radius.value+' km'">
                                <output class="text-center"name="distance" id="distance" ><b>{{$radius}} km</b></output>
                            </div>
                            <button type="submit" class="btn  btn-search pull-right">Zoek</button>
                    </form>
            </div>
            <div class="col-md-12">
                <div id="gmap"></div>
            </div>
        </div>
        <div class="col-md-9" id="contentfix">
            @include('layouts.errors')
            <div class="row">
                <div class="col-md-12">
                    @if($specs->count() > 0 )
                        @foreach($specs->chunk(3) as $row)
                            <div class="row">
                                @foreach($row as $spec)
                                    @if($spec->is_anonymous)
                                        <div class="col-md-4 spec" >
                                            <div class="box">
                                            <div class="col-md-4">
                                                <img alt="{{$spec->name}}" src="{{ asset("images/anonymous.png") }}" class="spec_image">
                                            </div>
                                            <div class="col-md-8 " id="specinfo">
                                                    <p class="text-center">{{$spec->name}}</p>
                                                @php
                                                    $specialism = App\Models\Specialism::whereHas('specialists', function($q) use ($spec)  { $q->where('name', $spec->name ); })->where('name', $keyword)->first();
                                                @endphp
                                                <p class="text-center">{{$specialism->name}}</p>
                                                    <p class="text-center">{{$spec->address}}</p>
                                                    <p class="text-center">{{$spec->postal_code}} {{$spec->city}}</p>
                                                    <p class="text-center">{{$spec->mobile_phone}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-md-4 spec"  data-href="/specialist/{{$spec->url_name}}" >
                                            <div class="box">
                                            <div class="col-md-4">
                                                <img alt="{{$spec->name}}" src="{{urldecode(asset('images/avatars/specialists/'.$spec->profile_image)) }}" class="spec_image">
                                            </div>
                                            <div class="col-md-8 " id="specinfo">
                                                <p class="text-center">{{$spec->name}}</p>
                                                @php
                                                    $specialism = App\Models\Specialism::whereHas('specialists', function($q) use ($spec)  { $q->where('name', $spec->name ); })->whereLike('name', $keyword)->first();
                                                @endphp
                                                <p class="text-center" style="color: royalblue">@if($specialism){{$specialism->name}}@else Geen werkgebied bekend @endif</p>
                                                <p class="text-center">{{$spec->address}}</p>
                                                <p class="text-center">{{$spec->postal_code}} {{$spec->city}}</p>
                                                <p class="text-center">{{$spec->mobile_phone}}</p>
                                            </div>
                                                <div class="col-md-12">
                                                    @php
                                                        if($specialism) {
                                                           $specialism_import = $spec->specialisms()->whereNot('name' ,$specialism->name)->limit(3)->get();
                                                       }
                                                    @endphp
                                                   <p class="text-center">
                                                       @if(isset($specialism_import))
                                                            @foreach($specialism_import as $item)
                                                                @if($item != $specialism)
                                                                    <span class="spec_item"> {{$item->name}}  </span>
                                                                @endif
                                                            @endforeach
                                                           @endif
                                                   </p>
                                                </div>
                                            </div>
                                            </div>
                                    @endif
                                @endforeach
                            </div>
                        @endforeach
                        <div class="text-center">
                          {{$specs->appends(request()->input())->links()}}
                        </div>
                    @else
                        <h2 class="noresultshead text-center">Sorry,  geen zoekresultaten</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTMGtzFUNyyV3YICxx0aGCag3eryHThEc&callback=initMap">
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.0/jquery.matchHeight-min.js"></script>
            <script type="text/javascript" src="{{ asset('js/search.js') }}"></script>
@endsection
