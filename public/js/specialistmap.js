function initialize() {
    var lat = document.getElementById('map_lat').value;
    var lng = document.getElementById('map_lng').value;
    var latLng = new google.maps.LatLng(parseFloat(lat), parseFloat(lng));
    var map = new google.maps.Map(document.getElementById('gmap'), {
        center: latLng,
        zoom: 14
    });
    var marker = new google.maps.Marker({
        position: latLng,
        map: map
    });
    var panorama = new google.maps.StreetViewPanorama(
        document.getElementById('pano'), {
            position: latLng,
            pov: {
                heading: 34,
                pitch: 10
            },
            addressControlOptions: {
                position: google.maps.ControlPosition.BOTTOM_CENTER
            },
            linksControl: false,
            panControl: false,
            enableCloseButton: false
        });
    map.setStreetView(panorama);
}