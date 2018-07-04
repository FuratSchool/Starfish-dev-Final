{{--{% set breadcrumb = [--}}
{{--{--}}
{{--title: "Specialisten",--}}
{{--url: path('specialists')--}}
{{--}]--}}
{{--%}--}}

@extends('base')

@section('styles')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset("css/specialists.css") }}"/>
@endsection

@section('title', 'Starfish - Specialisten')

@section('main')
    <div ng-app="specialistSearch">
        <div class="row loading" ng-controller="specialistSearchController as specList" ng-init="navVar = specList">
            <div class="col-xs-12 col-sm-5 col-lg-4">
                <div class="row">
                    <div class="col-xs-offset-1 col-xs-10 col-sm-offset-0 col-lg-offset-0 col-lg-12 searchbar search-category">
                        <h3>Specifiek zoeken</h3>
                        <input type="text" class="form-control" placeholder="Zoeken naar...">
                    </div>
                    <div class="col-xs-offset-1 col-xs-10 col-sm-offset-0 col-lg-offset-0 col-lg-12 map search-category">
                        <h3>Map</h3>
                        <div id="gMaps"></div>
                        <div class="radius-options">
                            <div class="input-group">
                                <span class="input-group-addon input-sm">Op Postcode</span>
                                <input class="form-control input-sm" id="gmaps-postalcode" />
                            </div>
                            <br />
                            <div class="input-group">
                                <span class="input-group-addon input-sm">Binnen</span>
                                <input class="form-control input-sm" id="gmaps-radius2" type="number" value="50" min="5" max="150" />
                                <span class="input-group-addon input-sm">kilometers</span>
                            </div>
                            <input id="gmaps-radius" value="50" type="range" min="5" max="150" />
                        </div>
                        <input type="checkbox" id="enable-radius" /> Zoek in de buurt
                    </div>
                    <div class="col-xs-offset-1 col-xs-12 col-sm-offset-0 col-lg-offset-0 tree search-category">
                        <h3>Categorieen</h3>
                        @foreach($categories as $cat)
                            @include('modules.category', ['cat' => $cat])
                        @endforeach
                    </div>
                    <div class="col-xs-offset-1 col-xs-12 col-sm-offset-0 col-lg-offset-0">
                        <button class="btn btn-default search-button" type="button">Filter <span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                    </div>
                </div>
            </div>
            <div class="specResults col-xs-11 col-xs-offset-1 col-sm-offset-0 col-sm-7 col-lg-offset-0 col-lg-8">
                <div id="more-info">
                    <div class="row">
                        <div class="col-xs-6 profile-picture">
                            <img data-path="{{ asset("images/") }}" src="" />
                        </div>
                        <div class="col-xs-6">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h3>Specialist</h3>
                            <p>Occupation</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="specialist col-xs-6" ng-repeat="spec in specList.specs">
                        <div class="row" ng-if="!spec.is_anonymous">
                            <div class="profile-picture col-xs-10 col-sm-8 col-lg-6">
                                <img ng-src="{{ urldecode(asset('images/avatars/<% spec.profile_image %>')) }}"/>
                            </div>
                            <div class="col-xs-10 col-sm-12 col-lg-6">
                                <h3><a href="{{ urldecode(route('specialist', ['name' => '<% spec.url_name %>'])) }}"><% spec.name %></a></h3>
                                <p><% spec.occupation %></p>
                            </div>
                        </div>
                        <div class="row" ng-if="spec.is_anonymous">
                            <div class="profile-picture col-xs-10 col-sm-8 col-lg-6">
                                <img ng-src="{{ asset("images/anonymous.png") }}"/>
                            </div>
                            <div class="col-xs-10 col-sm-12 col-lg-6">
                                <h3><% spec.name %></h3>
                                <p><% spec.occupation %></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="no-results row" ng-hide="specList.specs.length">
                    <div class="col-xs-12">
                        <h2 class="text-center">Geen resultaten gevonden!</h2>
                    </div>
                    <div class="col-xs-offset-4 col-xs-4">
                        <img src="{{ asset("images/no-results.png") }}" />
                    </div>
                </div>
                <div class="load-image">
                    <h2 class="text-center">We zijn de resultaten aan het laden!</h2>
                </div>
                <div class="row" ng-show="specList.specs.length">
                    <div class="pageNumberNav col-xs-12">
                        @include('modules.pagination', ['pages' => 1, 'page' => 1, 'routeName' => 'specialists'])
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="CSRF" value="{{ csrf_token() }}" />
@endsection

@section('scripts')
    @parent
    <script src="{{ asset("js/navigation.jquery.js") }}"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular.min.js"></script>
    <script src="{{ asset("js/specialistSearch.js") }}"></script>
    <script src="{{ asset("js/recursiveTree.jquery.js") }}"></script>
    <script type="text/javascript">
        var rTree = $(".tree").recursiveTree(".tree-branch", ".tree-body", ".tree-left");
        var gMaps;
        function initMap() {
            gMaps = $("#gMaps").gmaps();
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA15Jp14XMy02oaTBfFmproOorm3QFjG5E&callback=initMap"></script>
@endsection