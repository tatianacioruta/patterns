<style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }
    #map {
        height: 100%;
    }
</style>

<style>
    table {
        font-size: 12px;
    }
    #map {
        left: 135px;
        width: 1019px;
    }
</style>

<div class="" style="display: block; left: 135px; width: 100%;border: 1px solid black; background-color: yellow; text-align: center; padding: 10px;"><h1 style="font-size: 70px; margin: 20px;">Memories</h1></div>
<div id="map"></div>


<script>

 var url = '<?=_URL_PATH . 'map/get_markers_info'?>';
 var markers = [];
 var infowindow = [];
 var content;
   function initMap() {
        var myLatLng = {lat: 47.75546, lng: 27.92215};

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: myLatLng
        });
       $.ajax({
           url: url,
           data: {social: true},
           method: 'POST',
           dataType: 'JSON',
           success:function(results){
               console.log(results.length);
               for (var i = 0; i < results.length; i++) {
                   var markerIcon = '<?= _URL_PATH . 'images/markers/'?>' + results[i].icon;
                   var position = {lat:parseFloat(results[i].lat),lng:parseFloat(results[i].lng)};

                   // Use marker animation to drop the icons incrementally on the map.
                   markers[i] = new google.maps.Marker({
                       position: position,
                       icon: markerIcon,
                       title:results[i].title,
                       address:results[i].address
                   });
                   content = '<h1 id="firstHeading" class="firstHeading">'+results[i].title+'</h1>'+
                   '<div id="bodyContent">'+
                   '<p><b>Memory:</b>, '+results[i].content+ '<p>Adresa: '+results[i].address+'</p>';
                   infowindow[i] = new google.maps.InfoWindow({
                       content: content
                   });

                   var id = i;
                   google.maps.event.addListener(markers[i],'click', my_window(id));
                   function my_window(i){
                       infowindow[i].open(map,  markers[i]);
                   }
                   markers[i].setMap(map);
               }
           },
           error:function(res){
               console.log(res[0].title);
           }
       });
    }



   /* var map, places, infoWindow;
    var markers = [];
    var autocomplete;
    var countryRestrict = {'country': 'md'};
    var MARKER_PATH = 'https://maps.gstatic.com/intl/en_us/mapfiles/marker_green';
    var hostnameRegexp = new RegExp('^https?://.+?/');

    var countries = {
        'md': {
            center: {lat: 47.4116, lng: 28.3699},
            zoom: 7
        },
        'au': {
            center: {lat: -25.3, lng: 133.8},
            zoom: 4
        },
        'br': {
            center: {lat: -14.2, lng: -51.9},
            zoom: 3
        },
        'ca': {
            center: {lat: 62, lng: -110.0},
            zoom: 3
        },
        'fr': {
            center: {lat: 46.2, lng: 2.2},
            zoom: 5
        },
        'de': {
            center: {lat: 51.2, lng: 10.4},
            zoom: 5
        },
        'mx': {
            center: {lat: 23.6, lng: -102.5},
            zoom: 4
        },
        'nz': {
            center: {lat: -40.9, lng: 174.9},
            zoom: 5
        },
        'it': {
            center: {lat: 41.9, lng: 12.6},
            zoom: 5
        },
        'za': {
            center: {lat: -30.6, lng: 22.9},
            zoom: 5
        },
        'es': {
            center: {lat: 40.5, lng: -3.7},
            zoom: 5
        },
        'pt': {
            center: {lat: 39.4, lng: -8.2},
            zoom: 6
        },
        'us': {
            center: {lat: 37.1, lng: -95.7},
            zoom: 3
        },
        'uk': {
            center: {lat: 54.8, lng: -4.6},
            zoom: 5
        }
    };

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: countries['md'].zoom,
            center: countries['md'].center,
            mapTypeControl: false,
            panControl: false,
            zoomControl: true,
            streetViewControl: true
        });

        infoWindow = new google.maps.InfoWindow({
            content: document.getElementById('info-content')
        });

        // Create the autocomplete object and associate it with the UI input control.
        // Restrict the search to the default country, and to place type "cities".
        autocomplete = new google.maps.places.Autocomplete(
             /!*@type {!HTMLInputElement}*!/(
                document.getElementById('autocomplete')), {
                types: ['(cities)'],
                componentRestrictions: countryRestrict
            });
        places = new google.maps.places.PlacesService(map);

        autocomplete.addListener('place_changed', onPlaceChanged);

        // Add a DOM event listener to react when the user selects a country.
        document.getElementById('country').addEventListener(
            'change', setAutocompleteCountry);
    }

    // When the user selects a city, get the place details for the city and
    // zoom the map in on the city.
    function onPlaceChanged() {
        var place = autocomplete.getPlace();
        if (place.geometry) {
            map.panTo(place.geometry.location);
            map.setZoom(15);
            search();
        } else {
            document.getElementById('autocomplete').placeholder = 'Enter a city';
        }
    }

    // Search for hotels in the selected city, within the viewport of the map.
    function search() {
        var search = {
            bounds: map.getBounds(),
            types: ['cafe']
        };

        places.nearbySearch(search, function(results, status) {
            if (status === google.maps.places.PlacesServiceStatus.OK) {
                clearResults();
                clearMarkers();
                // Create a marker for each hotel found, and
                // assign a letter of the alphabetic to each marker icon.
                for (var i = 0; i < results.length; i++) {
                    var markerLetter = String.fromCharCode('A'.charCodeAt(0) + i);
                    var markerIcon = MARKER_PATH + markerLetter + '.png';
                    // Use marker animation to drop the icons incrementally on the map.
                    markers[i] = new google.maps.Marker({
                        position: results[i].geometry.location,
                        animation: google.maps.Animation.DROP,
                        icon: markerIcon
                    });
                    // If the user clicks a hotel marker, show the details of that hotel
                    // in an info window.
                    markers[i].placeResult = results[i];
                    google.maps.event.addListener(markers[i], 'click', showInfoWindow);
                    setTimeout(dropMarker(i), i * 100);
                    addResult(results[i], i);
                }
            }
        });
    }

    function clearMarkers() {
        for (var i = 0; i < markers.length; i++) {
            if (markers[i]) {
                markers[i].setMap(null);
            }
        }
        markers = [];
    }

    // [START region_setcountry]
    // Set the country restriction based on user input.
    // Also center and zoom the map on the given country.
    function setAutocompleteCountry() {
        var country = document.getElementById('country').value;
        if (country == 'all') {
            autocomplete.setComponentRestrictions([]);
            map.setCenter({lat: 15, lng: 0});
            map.setZoom(2);
        } else {
            autocomplete.setComponentRestrictions({'country': country});
            map.setCenter(countries[country].center);
            map.setZoom(countries[country].zoom);
        }
        clearResults();
        clearMarkers();
    }
    // [END region_setcountry]

    function dropMarker(i) {
        return function() {
            markers[i].setMap(map);
        };
    }

    function addResult(result, i) {
        var results = document.getElementById('results');
        var markerLetter = String.fromCharCode('A'.charCodeAt(0) + i);
        var markerIcon = MARKER_PATH + markerLetter + '.png';

        var tr = document.createElement('tr');
        tr.style.backgroundColor = (i % 2 === 0 ? '#F0F0F0' : '#FFFFFF');
        tr.onclick = function() {
            google.maps.event.trigger(markers[i], 'click');
        };

        var iconTd = document.createElement('td');
        var nameTd = document.createElement('td');
        var icon = document.createElement('img');
        icon.src = markerIcon;
        icon.setAttribute('class', 'placeIcon');
        icon.setAttribute('className', 'placeIcon');
        var name = document.createTextNode(result.name);
        iconTd.appendChild(icon);
        nameTd.appendChild(name);
        tr.appendChild(iconTd);
        tr.appendChild(nameTd);
        results.appendChild(tr);
    }

    function clearResults() {
        var results = document.getElementById('results');
        while (results.childNodes[0]) {
            results.removeChild(results.childNodes[0]);
        }
    }

    // Get the place details for a hotel. Show the information in an info window,
    // anchored on the marker for the hotel that the user selected.
    function showInfoWindow() {
        var marker = this;
        places.getDetails({placeId: marker.placeResult.place_id},
            function(place, status) {
                if (status !== google.maps.places.PlacesServiceStatus.OK) {
                    return;
                }
                infoWindow.open(map, marker);
                buildIWContent(place);
            });
    }

    // Load the place information into the HTML elements used by the info window.
    function buildIWContent(place) {
        document.getElementById('iw-icon').innerHTML = '<img class="hotelIcon" ' +
            'src="' + place.icon + '"/>';
        document.getElementById('iw-url').innerHTML = '<b><a href="' + place.url +
            '">' + place.name + '</a></b>';
        document.getElementById('iw-address').textContent = place.vicinity;

        if (place.formatted_phone_number) {
            document.getElementById('iw-phone-row').style.display = '';
            document.getElementById('iw-phone').textContent =
                place.formatted_phone_number;
        } else {
            document.getElementById('iw-phone-row').style.display = 'none';
        }

        // Assign a five-star rating to the hotel, using a black star ('&#10029;')
        // to indicate the rating the hotel has earned, and a white star ('&#10025;')
        // for the rating points not achieved.
        if (place.rating) {
            var ratingHtml = '';
            for (var i = 0; i < 5; i++) {
                if (place.rating < (i + 0.5)) {
                    ratingHtml += '&#10025;';
                } else {
                    ratingHtml += '&#10029;';
                }
                document.getElementById('iw-rating-row').style.display = '';
                document.getElementById('iw-rating').innerHTML = ratingHtml;
            }
        } else {
            document.getElementById('iw-rating-row').style.display = 'none';
        }

        // The regexp isolates the first part of the URL (domain plus subdomain)
        // to give a short URL for displaying in the info window.
        if (place.website) {
            var fullUrl = place.website;
            var website = hostnameRegexp.exec(place.website);
            if (website === null) {
                website = 'http://' + place.website + '/';
                fullUrl = website;
            }
            document.getElementById('iw-website-row').style.display = '';
            document.getElementById('iw-website').textContent = website;
        } else {
            document.getElementById('iw-website-row').style.display = 'none';
        }
    }*/
</script>
