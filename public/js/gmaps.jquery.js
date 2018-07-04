// the semi-colon before function invocation is a safety net against concatenated
// scripts and/or other plugins which may not be closed properly.
;( function( $, window, document, undefined ) {

    "use strict";

    // undefined is used here as the undefined global variable in ECMAScript 3 is
    // mutable (ie. it can be changed by someone else). undefined isn't really being
    // passed in so we can ensure the value of it is truly undefined. In ES5, undefined
    // can no longer be modified.

    // window and document are passed through as local variables rather than global
    // as this (slightly) quickens the resolution process and can be more efficiently
    // minified (especially when both are regularly referenced in your plugin).

    // Create the defaults once
    var pluginName = "gMaps",
        defaults = {
            resultOptions: $(""),
            street: $(""),
            streetNumber: $(""),
            postalCode: $(""),
            city: $(""),
            country: $(""),
            latitude: $(""),
            longitude: $("")
        };

    // The actual plugin constructor
    function Plugin ( element, map, options ) {
        this.element = $(element);

        // jQuery has an extend method which merges the contents of two or
        // more objects, storing the result in the first object. The first object
        // is generally empty as we don't want to alter the default options for
        // future instances of the plugin
        this.settings = $.extend( {}, defaults, options );
        this._defaults = defaults;
        this._name = pluginName;
        this.map = null;
        this.marker = null;
        this.lastValue = ""; // The last value that has been checked
        this.resultTimeout = -1; // the timeout variable, saved so we can clear it
        this.init(map);
    }

    // Avoid Plugin.prototype conflicts
    $.extend( Plugin.prototype, {
        init: function(map) {
            // Initialize google maps
            var center = {lat: 52.15, lng: 5.39};
            this.map = new google.maps.Map(map.get(0), {
                zoom: 7,
                center: center
            });
            this.marker = new google.maps.Marker({
                position: center,
                map: this.map
            });

            // On key press in adres load the geocoder and when done, execute loadResults
            this.element.keyup($.proxy(function(){
                if(this.lastValue === this.element.val()) return;

                // Clear all the results
                this.lastValue = this.element.val();
                this.settings.resultOptions.empty();
                this.settings.resultOptions.hide();

                // Clear any previous possible set timeout
                clearTimeout(this.resultTimeout);

                // Create a new timeout that loads all results after 2 seconds
                this.resultTimeout = setTimeout(function() {
                    var geocoder = new google.maps.Geocoder();
                    var address = this.element.val();
                    geocoder.geocode({ 'address': address}, this.loadResults.bind(this));
                }.bind(this), 1000);
            }, this));

            // On focus of the element show the result options
            this.element.focus($.proxy(function(){
                if(this.settings.resultOptions.children().length > 0){
                    this.settings.resultOptions.show();
                }
            }, this));

            // When we click on the map, update the latitude and longtitude
            google.maps.event.addListener(this.map, 'click', $.proxy(function(event){
                this.settings.latitude.val(event.latLng.lat());
                this.settings.longitude.val(event.latLng.lng());
                this.marker.setPosition(event.latLng);
            }, this));

            // Make sure that the parent elements won't get triggered on click
            this.element.parent().click(function(event){
                event.stopPropagation();
            });

            // On click of any element hide the resultOptions
            $(window).click($.proxy(function(){
                this.settings.resultOptions.hide();
            }, this));
        },

        loadResults: function(results, status){
            // If status is not OK, cancel (TODO, maybe tell the user that something went wrong)
            if(status !== google.maps.GeocoderStatus.OK) return;

            // With 0 results we won't do anything (TODO, maybe tell the user that no results are found)
            if(results.length === 0) return;

            // If there's only 1 result, fill in info
            if(results.length === 1) {
                // call the fillForm function to load the results
                this.fillForm(results[0]);
            }
            // As we know, 0 is not an option, so this must be > 1
            // We do need to know for sure that an element for resultOptions has been set
            else if(this.settings.resultOptions.length > 0) {
                // Loop over all results and build the resultOptions
                results.forEach($.proxy(function(el){
                    var span = $('<span>');
                    span.html(el.formatted_address);
                    span.click($.proxy(function(){
                        this.fillForm(el);
                        this.settings.resultOptions.hide();
                    }, this));
                    this.settings.resultOptions.append(span);
                }, this));
                this.settings.resultOptions.show();
            }
        },

        fillForm: function(result){
            // Loop over every result component
            result.address_components.forEach($.proxy(function(addrC){
                addrC.types.forEach($.proxy(function(type){
                    switch(type){
                        case 'street_number':
                            this.settings.streetNumber.val(addrC.long_name);
                            break;
                        case 'route':
                            this.settings.street.val(addrC.long_name);
                            break;
                        case 'postal_code':
                            this.settings.postalCode.val(addrC.long_name);
                            break;
                        case 'locality':
                            this.settings.city.val(addrC.long_name);
                            break;
                        case 'country':
                            this.settings.country.val(addrC.long_name);
                            break;
                    }
                }, this));
            }, this));

            // Grab the latitude and longtitude to fill these in their respective inputs
            var latLng = result.geometry.location;

            // Fill in the latitude and longtitude in their respective fields
            this.settings.latitude.val(latLng.lat());
            this.settings.longitude.val(latLng.lng());

            // Update the google maps
            this.marker.setPosition(latLng);
            this.map.setCenter(latLng);
            this.map.setZoom(15);
        }
    });

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[ pluginName ] = function( map, options ) {
        return this.each( function() {
            if ( !$.data( this, "plugin_" + pluginName ) ) {
                $.data( this, "plugin_" +
                    pluginName, new Plugin( this, map, options ) );
            }
        } );
    };

} )( jQuery, window, document );