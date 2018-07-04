try {
    $(document).ready(function() {
        $('.box').matchHeight();
    });

    $('#toggle_filter').click(function() {
        $('#filter').slideToggle(275, 'swing');
    });

    function getParameterValue(param) {
        var searchParams = new URLSearchParams(window.location.search);
        var result =  searchParams.get(param);
        return result;
    }
// Function to make divs with a data-href clickable
    $('div[data-href]').on("click", function() {
        document.location = $(this).data('href');
    });
    function geocode(position) {
        var lat = position.coords.latitude;
        var lng = position.coords.longitude;
        var latLng = new google.maps.LatLng(parseFloat(lat), parseFloat(lng));
        initMap(latLng);
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'latLng' :  latLng}, function (results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                var address = results[0].address_components;
                var country = address[address.length - 2].long_name;
                var zipcode = address[address.length - 1].long_name;
                var city = address[address.length - 4].short_name;
                var street = address[address.length - 6].long_name;
                if(address[address.length - 7]) {
                    var street_number = address[address.length - 7].long_name;
                } else {
                    var street_number = "";
                }
                var output = document.getElementById('filter_zip_auto');
                output.value = street +' ' +street_number+",  " + city + ", " + zipcode + ", " + country;
                var info = " <br><p class='text-muted'> Uw locatie kan fout zijn, mocht dit voorkomen klik dan uw locatie aan op de kaart</p>";
                output.insertAdjacentHTML('beforeend', info);
            }
        });
    }
    function geocode_api(latLng) {
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'latLng': latLng}, function (results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                var address = results[0].address_components;
                var country = address[address.length - 2].long_name;
                var zipcode = address[address.length - 1].long_name;
                var city = address[address.length - 4].short_name;
                var street = address[address.length - 6].long_name;
                if(address[address.length - 7]) {
                    var street_number = address[address.length - 7].long_name;
                } else {
                    var street_number = "";
                }
                var output = document.getElementById('filter_zip_auto');
                output.value = street + ' ' + street_number + ",  " + city + ", " + zipcode + ", " + country;
                var info = " <br><p class='text-muted'> Uw locatie kan fout zijn, mocht dit voorkomen klik dan uw locatie aan op de kaart</p>";
                output.insertAdjacentHTML('beforeend', info);
            }
        });
    }
    function errorHandler(err) {
        if(err.code === 1) {
            console.log("Error: Access to location is denied!");
        }

        else if( err.code === 2) {
            console.log("Error: Position is unavailable!");
        }
    }

    var markers = [ ];
    var circles = [ ];
    var maps = [ ];
    var first_load = true;
    function initMap(current_latLng) {
        deleteMarkers();
        if (first_load === true) {
            try {
                var hidden_lat_field = document.getElementById('geolat');
                var hidden_lng_field = document.getElementById('geolng');
                console.log(isFinite(hidden_lat_field.value));
                console.log(isFinite(hidden_lng_field.value));
                if(isFinite(hidden_lat_field.value) && isFinite(hidden_lng_field.value)){
                    var start_lat = hidden_lat_field.value;
                    var start_lng = hidden_lng_field.value;
                } else {
                    var start_lat = 52.0893191;
                    var start_lng = 5.1101691;
                }
                console.log(start_lat);
                try {
                    var start_latLng = new google.maps.LatLng(parseFloat(start_lat), parseFloat(start_lng));
                } catch(e) {
                    alert(e);
                }
                var gmap = document.getElementById('gmap');
                var map = new google.maps.Map(gmap, {
                    zoom: 10,
                    center: start_latLng
                });
                maps.push(map);

                var marker = new google.maps.Marker({
                    position: start_latLng,
                    map: map
                });
                map.panTo(start_latLng);
                markers.push(marker);
                drawCircle();
                first_load = false;
            } catch(e) {
                console.log(e);
            }
        } else {
            var map = maps[0];
            var marker = new google.maps.Marker({
                position: current_latLng,
                map: map
            });
            map.panTo(current_latLng);
            markers.push(marker);
            drawCircle();
        }
        map.addListener('click', function(e) {
            // placeMarkerAndPanTo(e.latLng, map);
        });
        function setMapOnAll(map) {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(map);
            }
        }
        function clearMarkers() {
            setMapOnAll(null);
        }
        function deleteMarkers() {
            clearMarkers();
            markers = [];
        }
        function placeMarkerAndPanTo(latLng, map) {
            deleteMarkers();
            var marker = new google.maps.Marker({
                position: latLng,
                map: map
            });
            markers.push(marker);
            drawCircle();
            geocode_api(latLng);
            map.panTo(latLng);
        }
    }
    function removeAllcircles() {
        for(var i in circles) {
            circles[i].setMap(null);
        }
        circles = []; // this is if you really want to remove them, so you reset the variable.
    }
    function drawCircle() {
        try {
            var marker = markers[0];
            var map = maps[0];
            removeAllcircles();
            var lat = marker.getPosition().lat();
            var lng = marker.getPosition().lng();
            // noinspection JSUndefinedPropertyAssignment
            document.getElementById('geolat').value = marker.position.lat();
            document.getElementById('geolng').value = marker.position.lng();
            var latLng = new google.maps.LatLng(parseFloat(lat), parseFloat(lng));
            var circ_radius = document.getElementById('radius').value * 1000;
            var circle = new google.maps.Circle({
                strokeColor: '#FF0000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#FF0000',
                fillOpacity: 0.35,
                map: map,
                center: latLng,
                radius: circ_radius,
                clickable: false
            });
            circles.push(circle);
        } catch (e) {
            alert(e);
        }
    }

    function redrawCircle() {
        drawCircle();
    }
    function address_geocoder() {
        setTimeout(geocode_address, 50);
    }
    function geocode_address() {
        var zip = document.getElementById('filter_zip').value;
        var city = document.getElementById('filter_city').value;
        var address = zip+" "+city;
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({
            'address' : address
        },function (results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                console.log(results);
                var lat =(results[0].geometry.bounds.f.f + results[0].geometry.bounds.f.b)/2;
                var lng = (results[0].geometry.bounds.b.f + results[0].geometry.bounds.b.b)/2;
                console.log(lat+" "+lng);
                document.getElementById('geolat').value = lat;
                document.getElementById('geolng').value = lng;
                console.log(document.getElementById('geolat').value);
                var latLng = new google.maps.LatLng(parseFloat(lat), parseFloat(lng));
                initMap(latLng)
            }
        });
    }


} catch (e) {
    alert(e);
}