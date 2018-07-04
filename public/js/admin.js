var geocoder;
var map;
var init = true;
var markers = [];
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
function drawMap() {
        var latlng = new google.maps.LatLng(52.0893191, 5.1101691);
        var mapOptions = {
            zoom: 10,
            center: latlng
        }
        map = new google.maps.Map(document.getElementById('gmap'), mapOptions);
        init = false;
}
function codeAddress(addr) {
    if(init) {
        drawMap();
    }
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({'address': addr}, function (results, status) {
        if (status === 'OK') {
            var latLng = results[0].geometry.location.toString();
            var arrLatLng = latLng.substring(1, latLng.length -1).split(",")
            var lat = arrLatLng[0];
            var lngDirty = arrLatLng[1];
            var lng = lngDirty.trim();
            var region;
            var country;
            results[0].address_components.forEach(function (e) {
                if(e.types[0] == "administrative_area_level_1") {
                    region = e.long_name;
                } else if (e.types[0] == "country") {
                    country = e.long_name;
                }
            })
            $("#region").val(region);
            $("#regionOut").val(region);
            $("#country").val(country);
            $("#countryOut").val(country);
            $("#lat").val(lat);
            $("#lng").val(lng);
            map.setCenter(results[0].geometry.location);
            deleteMarkers();
            var marker = new google.maps.Marker({
                map: map,
                position: results[0].geometry.location
            });
            setTimeout(map.setZoom(10), 1000);
            setTimeout(map.panTo(marker.position), 2000);
            setTimeout(map.setZoom(15), 3000);
            markers.push(marker);
        }
    });
}
var panPath = [];   // An array of points the current panning action will use
var panQueue = [];  // An array of subsequent panTo actions to take
var STEPS = 200;     // The number of steps that each panTo action will undergo

function panTo(newLat, newLng) {
    if (panPath.length > 0) {
        // We are already panning...queue this up for next move
        panQueue.push([newLat, newLng]);
    } else {
        // Lets compute the points we'll use
        panPath.push("LAZY SYNCRONIZED LOCK");  // make length non-zero - 'release' this before calling setTimeout
        var curLat = map.getCenter().lat();
        var curLng = map.getCenter().lng();
        var dLat = (newLat - curLat)/STEPS;
        var dLng = (newLng - curLng)/STEPS;

        for (var i=0; i < STEPS; i++) {
            panPath.push([curLat + dLat * i, curLng + dLng * i]);
        }
        panPath.push([newLat, newLng]);
        panPath.shift();      // LAZY SYNCRONIZED LOCK
        setTimeout(doPan, 20);
    }
}

function doPan() {
    var next = panPath.shift();
    if (next != null) {
        // Continue our current pan action
        map.panTo( new google.maps.LatLng(next[0], next[1]));
        setTimeout(doPan, 20 );
    } else {
        // We are finished with this pan - check if there are any queue'd up locations to pan to
        var queued = panQueue.shift();
        if (queued != null) {
            panTo(queued[0], queued[1]);
        }
    }
}
// the smooth zoom function
function smoothZoom (map, max, cnt) {
    if (cnt >= max) {
        return;
    }
    else {
        var z = google.maps.event.addListener(map, 'zoom_changed', function(event){
            google.maps.event.removeListener(z);
            smoothZoom(map, max, cnt + 1);
        });
        setTimeout(function(){map.setZoom(cnt)}, 80); // 80ms is what I found to work well on my system -- it might not work well on all systems
    }
}

$(document).ready(function(){
    $('.assignee:first #removeAssignee ').remove();
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
    $(function () {
        $(".fa-info-circle").tooltip({
            content: function () {
                return $(this).prop('title').innerHTML();
            }
        });
    });
    $(function () {
      var children =  $("#sidenav li") ;
      var n  = children.length;
      var nheight = 100/n;
      children.css('max-height', "25%");
      children.css('height', nheight+"%");
    });
    $(".droptoggle").click(function() {
        $(".usermenu").stop(true, true).slideToggle(500);
        $(this).addClass("hovered");
        $(this).find("i").addClass('transition').toggleClass('rotate');
        return false;
    });
    $(".toggletable2").click(function() {
        $('#table2').parent().stop(true, true).slideToggle(500);
        $(this).find("i").addClass('transition').toggleClass('rotate');
        return false;
    });
    $("html:not(.droptoggle):not(.usermenu)").click(function(e) {
        $(".usermenu").stop(true, true).slideUp(300);
        $(".droptoggle").removeClass("hovered");
    });
    $('#checkall:checkbox').change(function () {
        if( $(this).prop("checked") ) {
            $('input:checkbox').prop('checked', true);
        } else {
            $('input:checkbox').prop('checked', false);
        }
    });

    $('input[data-group="accessBox"]:checkbox').change(function () {
        if ( $('#checkall:checkbox').prop('checked')  ) {
            $('#checkall:checkbox').prop('checked', false);
        }
        if($('input[data-group="accessBox"]:checkbox:checked').length == $('input[data-group="accessBox"]:checkbox').length) {
            $('#checkall:checkbox').prop('checked', true);
        }
    });
    $('input:checkbox').ready(function () {
        if($('input[data-group="accessBox"]:checkbox:checked').length == $('input[data-group="accessBox"]:checkbox').length) {
            $('#checkall:checkbox').prop('checked', true);
        }
    });

    $('#is_anonymous').on('click', function () {
            $('#payfields').stop(true,true).slideUp(300);
    });
    $('#not_anonymous').on('click', function () {
        $('#payfields').stop(true,true).slideDown(300);
    });
    var iUsername = '<input class="form-control" type="text" name="q" id="q" placeholder="Gebruikersnaam"/> ';
    var iFirstName = '<input class="form-control" type="text" name="q" id="q" placeholder="Voornaam"/> ';
    var iSurName = '<input class="form-control" type="text" name="q" id="q" placeholder="Achternaam"/> ';
    var iName = '<input class="form-control" type="text" name="q" id="q" placeholder="Naam">';
    var iEmail = '<input class="form-control" type="email" name="q" id="q" placeholder="E-Mail"/> ';
    var sStatus = '<select class="form-control" name="q" id="q">' +
        '<option value="1">Actief</option>' +
        '<option value="0">Niet Actief</option>' +
        '</select>';
    var sAnon = '<select class="form-control" name="q" id="q">' +
        '<option value="1">Niet Betaald</option>' +
        '<option value="0">Betaald</option>' +
        '</select>';
    var sLOA =     '<select class="form-control" name="q" id="q">' +
        '<option value="1">Standaard</option>' +
        '<option value="2">Mod</option>' +
        '<option value="3">Admin</option>' +
        '<option value="4">Webmaster</option>' +
        '</select>';

    var sOnline = '<select class="form-control" name="q" id="q">' +
        '<option value="1">Online</option>' +
        '<option value="0">Offline</option>' +
        '</select>';


    var setup = true;
    $('select#filter_type').on('change', function() {
        var val = this.value;
        var iField;
        switch (val) {
            case 'username':
                 iField = iUsername;
                break;
            case 'first_name':
                 iField = iFirstName;
                break;
            case 'sur_name':
                 iField = iSurName;
                break;
            case 'email':
                 iField = iEmail;
                break;
            case 'status':
                 iField = sStatus;
                break;
            case 'LOA':
                 iField = sLOA;
                break;
            case 'online':
                iField = sOnline;
                break;
            case 'name':
                 iField = iName;
                break;
            case 'occupation':
                 iField = sOccupation;
                break;
            case 'city':
                 iField = sCity;
                break;
            case 'is_anonymous':
                 iField = sAnon;
                break;
        }
        var initializer = $('option[value="init"]');
        var sq = $('#sq');
        var input = $('#q');
        if(setup) {
            initializer.remove();
            var sform = $('#sform');
            sq.replaceWith('<div class="form-group" id="sq">' +
                '                <label for="q">Zoekterm:   </label>' +
                iField +
                '            </div>');
            sq = $('#sq');
            sq.hide();
            var w = 100*5/12;
            var ml = 100*5/12;
            sform.animate({
                    width: w+'%',
                    marginLeft: ml+'%'
                }, 0);
            sq.css('dislay', 'inline-block');
            var inputbox = $('#q');
            var label = $("label[for='q']");
            sq.css({width: 120+"px"});
            sq.animate({width: 280+"px"}, 500);
            label.animate({width: 80+'px'}, 0);
           inputbox.animate({width: 180+'px'}, 500);
            setup = false;
        }
        input.replaceWith(iField);
        $('#q').css({width: 180+'px'});
    });
});


jQuery.fn.initMap = function() {
    var address = $('#address').val();
    var zip = $('#postal_code').val() ;
    var city = $('#city').val();
    var testspace = address.match(/\s/);
    if(testspace) {
        var number = address.match(/(?:(?:\s)(?:[a-zA-Z](?=\d))?[a-zA-Z0-9]+)$/i);
        var cNumber= number.toString().replace(/\s/g, '');
    }
    if(cNumber && zip && city ) {
        var addr= address + " , " + zip + " , " + city;
       codeAddress(addr);
    }
};
function specialist(id) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "/admin/specialisten/lijst/"+id, false);
    xhr.send();

    return xhr.responseText;

}

$(document).on('change', '#recipient_type', function () {
    var newType = this.value;
    var selectList = $(this).next('select');
    selectList.empty();
    var newList;
    switch (newType) {
        case 'groups':
            newList = sGroup;
            break;
        case 'users':
            newList = sUser;
            break;
    }
    selectList.append(newList);
});

$(document).on('change', '#assignee_type', function () {
    var newType = this.value;
    var selectList = $(this).next('select');
    selectList.empty();
    var newList;
    switch (newType) {
        case 'groups':
            newList = sGroup;
            break;
        case 'users':
            newList = sUser;
            break;
    }
    selectList.append(newList);
    var values= [];
    $('#updateTask .assignee_id:not(:last)').each(function (e) {
        if($(this).prev('select').val() == 'users') {
            values.push($(this).val())
        }
    });
   values.forEach(function (e) {
       $(selectList).find('[value='+e+']').remove();
   })
    values= [];
    $('#updateTask .assignee_id:not(:last)').each(function (e) {
        if($(this).prev('select').val() == 'users') {
            values.push($(this).val())
        }
    });
    values.forEach(function (e) {
        $(selectList).find('[value='+e+']').remove();
    })
});

function initList(obj) {
    obj.append(sUser);
    obj.val()
}
var index = 1;
$('button#addRecipient').on('click', function () {
    var numRecipients = $('.recipient').length;
    var content;
    if(numRecipients < 5) {
        content = ' <div class="col-md-12 recipient"> <label for="recipient_type" class="col-md-2" style="padding-left: 0 !important;">Type</label> <label for="recipient_name" class="col-md-10">Naam</label> <select id="recipient_type" name="recipients['+index+'][type]" class="form-control recipient_type" style="width: 20%; display: inline-block"> <option value="">Kies een type</option> <option value="users">Gebruikers</option> <option value="groups">Groep</option> </select> <select id="recipient_name" name="recipients['+index+'][name]" class="form-control recipient_name" style="width: 40%; display: inline-block"> </select> <i class="fa fa-trash msg msg-danger-background text-white removeRecipient" id="removeRecipient" aria-hidden="true" title="Ontvanger Verwijderen"></i></div>';
        index++
    } else {
        content = '<div class="col-md-8" id="msg" style="margin-top: 10px;"> <div class="msg msg-danger msg-danger-background text-white"> <span class="fa fa-exclamation-triangle"></span> Maximaal aantal ontvangers bereikt <i class="fa fa-close" style="float: right" aria-hidden="true" onclick="return $(\'#msg\').remove()"></i> </div> </div>'
        $(this).attr('disabled', true)
    }
    $('.recipient:last').after(content);
    numRecipients = $('.recipient').length;
    if(numRecipients == 5) {
        $(this).attr('disabled', true);
        $('.recipient:last').after( '<div class="col-md-8" id="msg" style="margin-top: 10px;"> <div class="msg msg-danger msg-danger-background text-white"> <span class="fa fa-exclamation-triangle"></span> Maximaal aantal ontvangers bereikt <i class="fa fa-close" style="float: right" aria-hidden="true" onclick="return $(\'#msg\').remove()"></i> </div> </div>')
    }
});

$(document).on('click', "#removeRecipient", function () {
    $(this).parent('.recipient').next("#msg").remove();
    $(this).parent('.recipient').remove();
    var numRecipients = $('.recipient').length;
    if(numRecipients < 5) {
        $('#addRecipient').attr('disabled', false)
    }
})

$('button#addAssignee').on('click', function () {
    var numRecipients = $('.assignee').length;
    var content;
    if(numRecipients < 5) {
        content = ' <div class="col-md-12 assignee"> <label for="assignee_type" class="col-md-2" style="padding-left: 0 !important;">Type</label> <label for="assignee_id" class="col-md-10">Naam</label> <select id="assignee_type" name="assignees['+index+'][type]" class="form-control assignee_type" style="width: 20%; display: inline-block"> <option value="">Kies een type</option> <option value="users">Gebruikers</option> <option value="groups">Groep</option> </select> <select id="assignee_id" name="assignees['+index+'][id]" class="form-control assignee_id" style="width: 40%; display: inline-block"> </select> <i class="fa fa-trash msg msg-danger-background text-white removeAssignee" id="removeAssignee" aria-hidden="true" title="Toewijzing Verwijderen"></i></div>';
        index++
    } else {
        content = '<div class="col-md-8" id="msg" style="margin-top: 10px;"> <div class="msg msg-danger msg-danger-background text-white"> <span class="fa fa-exclamation-triangle"></span> Maximaal aantal toewijzingen bereikt <i class="fa fa-close" style="float: right" aria-hidden="true" onclick="return $(\'#msg\').remove()"></i> </div> </div>'
        $(this).attr('disabled', true)
    }
    $('.assignee:last').after(content);
    numRecipients = $('.assignee').length;
    if(numRecipients == 5) {
        $(this).attr('disabled', true);
        $('.assignee:last').after( '<div class="col-md-8" id="msg" style="margin-top: 10px;"> <div class="msg msg-danger msg-danger-background text-white"> <span class="fa fa-exclamation-triangle"></span> Maximaal aantal toewijzingen bereikt <i class="fa fa-close" style="float: right" aria-hidden="true" onclick="return $(\'#msg\').remove()"></i> </div> </div>')
    }
});

$(document).on('click', "#removeAssignee", function () {
    $(this).parent('.assignee').next("#msg").remove();
    $(this).parent('.assignee').remove();
    var numRecipients = $('.assignee').length;
    if(numRecipients < 5) {
        $('#addAssignee').attr('disabled', false)
    }
})