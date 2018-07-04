angular.module('specialistSearch', [], function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    })
    .config(function($httpProvider){
        $httpProvider.defaults.headers.post =  {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-CSRF-TOKEN': $('#CSRF').val()
        };
    })

    .controller('specialistSearchController', function($scope, $element, $http) {
        var specList = this;
        specList.scopeElement = $element;
        specList.specs = [];
        specList.navigation = $(".pagination").navigation(specList);
        specList.requesting = false;
        specList.needsDifferentRequest = false;


        $(".search-button").click(function(){
            specList.viewPage();
        });

        $(".searchbar input").keydown(function(event){
            if(event.keyCode === 13) specList.viewPage();
        });

        specList.viewPage = function(page) {
            if(specList.requesting){
                specList.needsDifferentRequest = true;
                return;
            }
            specList.needsDifferentRequest = false;
            specList.requesting = true;

            page = typeof page !== 'undefined' ? page : 1;

            $(specList.scopeElement).addClass('loading');

            var data = { search: $(".searchbar input").val(), page: page };

            if(gMaps){
                data['mapLat'] = gMaps.lat;
                data['mapLng'] = gMaps.lng;
                data['radius'] = $("#gmaps-radius").val();
                if(!$("#enable-radius").is(":checked")){
                    data['radius'] = -1;
                }
            }

            if(rTree){
                data['categories'] = JSON.stringify(rTree.getActiveNames());
            }

            $http.post( "/specialists/search", $.param(data)).then(function successCallback(response) {
                specList.specs = response.data.data;

                specList.navigation.generateHTML(response.data.last_page, response.data.current_page);

                if(gMaps){
                    gMaps.update(response.data.data);
                }

                $(specList.scopeElement).removeClass('loading');

                specList.requesting = false;
                if(specList.needsDifferentRequest){
                    specList.viewPage(page);
                }

            }, function errorCallback(response) {
                console.debug("ERROR loading specialists");

                specList.requesting = false;
                if(specList.needsDifferentRequest){
                    specList.viewPage(page);
                }
            });
        };
        specList.viewPage();

        if(gMaps){
            gMaps.link(specList.viewPage);
        }
    });


// jQuery search, still need to find a way to simplify this
(function ($) {
    $.fn.gmaps = function(){
        var maps = this;
        maps.links = [];

        maps.lat = 52;
        maps.lng = 5;

        maps.map = new google.maps.Map(maps.get(0), {
            zoom: 7,
            center: {lat: maps.lat, lng: maps.lng}
        });

        maps.markers = [];
        maps.markerCache = {};



        maps.radius = new google.maps.Circle({
            strokeColor: '#20e4f9',
            strokeOpacity: 0.5,
            strokeWeight: 2,
            fillColor: '#20e4f9',
            fillOpacity: 0.2,
            map: maps.map,
            center: { lat: 52, lng: 5},
            radius: $("#gmaps-radius").val()*1000/2
        });

        maps.radius.setMap(null);

        maps.updateCenter = function(event){
            if(!$("#enable-radius").is(":checked")) return;
            maps.lat = event.latLng.lat();
            maps.lng = event.latLng.lng();
            maps.updateRadius();
            maps.callUpdate();
        };
        google.maps.event.addListener(maps.map, "click", maps.updateCenter);
        google.maps.event.addListener(maps.radius, "click", maps.updateCenter);

        $("#gmaps-radius").on('input', function(){
            $("#gmaps-radius2").val($(this).val());
            maps.updateRadius();
        });

        $("#gmaps-radius2").on('input', function(){
            $("#gmaps-radius").val($(this).val());
            maps.updateRadius();
        });


        // More info
        maps.markerClick = function(){
            var spec = this.get('spec');
            if(!spec.isAnonymous){
                $("#more-inf").find("img"").attr('src', $("#more-inf").find("img"").data('path')+ "avatars/" + spec.profileImage);
            } else {
                $("#more-inf").find("img"").attr('src', $("#more-inf").find("img"").data('path') + "anonymous.png");
            }

            $("#more-inf").find("h3"").html(spec.name);
            $("#more-inf").find("p"").html(spec.occupation);
            $("#more-info").stop().fadeIn(200);
        };

        $(document).mouseup(function (e)
        {
            var container = $("#more-info");

            if (!container.is(e.target) // if the target of the click isn't the container...
                && container.has(e.target).length === 0) // ... nor a descendant of the container
            {
                container.fadeOut(200);
            }
        });

        $("#more-inf").find(".close"").fadeOut(200);

        // End more info


        // Allow linking
        $("#gmaps-radius, #gmaps-radius, #gmaps-postalcode").on("change", function(){
            maps.callUpdate();
        });
        //


        $("#enable-radius").click(function(){
            if($(this).is(":checked")){
                $(".radius-options").stop().slideDown(500);
                maps.radius.setMap(maps.map);
            } else {
                $(".radius-options").stop().slideUp(500);
                maps.radius.setMap(null);
            }
            maps.callUpdate();
        });

        $("#gmaps-postalcode").on("input", function(){
            if($(this).val().match(/^\d{4}( |)[a-z]{2}$/i)){
                var data = {address: $(this).val(), key: "AIzaSyA15Jp14XMy02oaTBfFmproOorm3QFjG5E"};

                $.get("https://maps.googleapis.com/maps/api/geocode/json", data).done(function(data) {
                    try {
                        maps.lat = data.results[0].geometry.location.lat;
                        maps.lng = data.results[0].geometry.location.lng;
                        maps.updateRadius();
                    } catch(e){}
                });
            }
        });


        maps.link = function(func){
            maps.links.push(func);
        };

        maps.callUpdate = function(){
            maps.links.forEach(function(func){
                func();
            });
        };

        maps.updateRadius = function(){
            if(!$("#enable-radius").is(":checked")) return;
            maps.radius.setCenter(new google.maps.LatLng(maps.lat, maps.lng));
            maps.radius.setRadius($("#gmaps-radius").val()*1000/2);
        };

        maps.update = function(specialists){
            try {
                maps.markers.forEach(function (marker) {
                    marker.setMap(null);
                });
                maps.markers = [];
                specialists.forEach(function (spec) {
                    if(maps.markerCache.hasOwnProperty(spec.id)){
                        maps.markerCache[spec.id].setMap(maps.map);
                        maps.markers.push(maps.markerCache[spec.id]);
                    } else {
                        var marker = new google.maps.Marker({
                            position: {lat: parseFloat(spec.map_lat), lng: parseFloat(spec.map_lng)},
                            map: maps.map,
                            title: spec.name
                        });
                        marker.set('spec', spec);
                        marker.addListener('click', maps.markerClick);
                        maps.markers.push(marker);
                        maps.markerCache[spec.id] = marker;
                    }
                });
            } catch(e){
                console.debug(e);
            }
        };

        return this;
    }
}(jQuery));