<!DOCTYPE html>

  <html>

   <head>

    <style type="text/css">

      html, body { height: 100%; margin: 0; padding: 0; }

      #map { height: 50%; }

     #map2 { height: 50%; }

     #locationField, #controls {

      position: relative;

      width: 480px;

    }

  #autocomplete {

    position: absolute;

    top: 0px;

    left: 0px;

    width: 99%;

  }

  .label {

    text-align: right;

    font-weight: bold;

    width: 100px;

    color: #303030;

  }

  #address {

    border: 1px solid #000090;

    background-color: #f0f0ff;

    width: 480px;

    padding-right: 2px;

  }

  #address td {

    font-size: 10pt;

  }

  .field {

    width: 99%;

  }

  .slimField {

    width: 80px;

    }

    .wideField {

     width: 200px;

   }

   #locationField {

    height: 20px;

     margin-bottom: 2px;

   }

    </style>

    </head>

	<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.0.min.js"></script>

     <body>

		<div id="locationField" style="float:left; width:50%;">

			<input id="autocomplete" placeholder="Enter your address" onFocus="geolocate()" type="text"></input>

			<div>

				<h3>Stores sorted by distance</h3>

				<div id="stores-list"></div>

			</div>

		</div>



  <div id="map" style="float:left; width:50%;"></div>



          <a href="javascript: void(0);" onClick="delete_markers();">Delete all markers</a>

     

      

    <script type="text/javascript">

    var markers = [];

    function delete_markers(){

        clearMarkers();

    } // function



    function addMarker(position, abrir){

        var position_lmp = {lat: position.lat, lng: position.lng};

        var iconBase = 'http://' . $_SERVER['HTTP_HOST'] . '/sites/default/files/gsl_marker_icon/';

        var marker = new google.maps.Marker({

            position: position_lmp,

            title: position.title,

            icon: iconBase + 'pin-fuster.png'

        });

		

        marker.setMap(map);

		infowindow.setContent("<h1>" + position.title + "</h1><br /><a href='" + position.url + "' target='_blank'>See more info about " + position.title + "</a>");

        if(abrir) infowindow.open(map, marker);

		

        marker.addListener('click', function() {

			infowindow.setContent("<h1>" + position.title + "</h1><br /><a href='" + position.url + "' target='_blank'>See more info about " + position.title + "</a>");

			infowindow.open(map, marker);

        });

        markers.push(marker);

    } // function



    //positions = [{lat: 41.62, lng: -0.87, title: "Zaragoza", url : "https://en.wikipedia.org/wiki/Zaragoza"},  {lat: 41.3948976, lng: 2.0787282, title: "Barcelona", url : "https://en.wikipedia.org/wiki/Barcelona"}];

	positions = [];

    function initMap() {

        infowindow = new google.maps.InfoWindow({

            content: ""

        });



        map = new google.maps.Map(document.getElementById('map'), {

		center: {lat: 41.62, lng: -0.87},

            zoom: 6

        });



       

        initAutocomplete();

    } // function initMap



    var autocomplete;



    function initAutocomplete() {

        // Create the autocomplete object, restricting the search to geographical

        // location types.

        autocomplete = new google.maps.places.Autocomplete(

        /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),

        {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address

        // fields in the form.

        autocomplete.addListener('place_changed', fillInAddress);

    } // function



    // [START region_fillform]

    function fillInAddress(lat, lng) {

        // Get the place details from the autocomplete object.

        var place = autocomplete.getPlace();

		if(place.geometry){

			lat2 =  place.geometry.location.lat();

			lng2 =  place.geometry.location.lng();

		} // if

		if (!place.geometry && lat == 0 && lng == 0) {

			//window.alert("Intentaré detectar las coordenadas de " + jQuery("#autocomplete").val() );

		jQuery.get("http://maps.google.com/maps/api/geocode/json?address=" + jQuery("#autocomplete").val(),				

			function (data3, status){

			 for (var i=0; i<data3.results.length;i++){

				 //alert(data3.results[i].geometry.location.lat + " " + data3.results[i].geometry.location.lng );

				 fillInAddress(data3.results[i].geometry.location.lat , data3.results[i].geometry.location.lng);

			 } // for

			//alert(data2);

			//if(status == "success") alert(data2.results.geometry.location.lat, data2.results.geometry.location.lng);

		});

			// http://maps.google.com/maps/api/geocode/json?address=Barcelona

			//window.alert("Autocomplete's returned place contains no geometry");

            return;

        }

		

		if(!place.geometry){

			lat2 = lat;

			lng2 = lng;

		} // if

		jQuery.post("distance-calculator.php",

		{

			lat:lat2,

			lng: lng2

		},

			function(data, status){

				//alert("Data: " + data + "\nStatus: " + status);

				map.setCenter(new google.maps.LatLng(lat2, lng2));

				deleteMarkers();

				data2 = JSON.parse(data);

				cadena = "";

				for(var key in data2){

					showStore(parseFloat(data2[key].lat) , parseFloat(data2[key].lng), data2[key].nombre , data2[key].email);

					cadena += "<li><a href='javascript: void(0);' onClick='showStore(" + data2[key].lat + "," + data2[key].lng + "," + "\"" + data2[key].nombre  + "\"" + "," + "\"" + data2[key].email + "\"" +  ", true);'>" + data2[key].nombre + "</a> <br />" + data2[key].localidad + " " + data2[key].distancia + "</li>";

				} // for

				jQuery("#stores-list").html(cadena);

				

		});

		

		

        //alert(place.geometry.location.lat() + " " + place.geometry.location.lng());

    } // function fillIndAddress

	

	function showStore(lat2, lng2, nombre, email, mostrar){

		addMarker({lat: lat2, lng: lng2, title: nombre, url: email}, mostrar);

	} // function

    function geolocate() {

        // nothing

    }



    // Sets the map on all markers in the array.

    function setMapOnAll(map) {

        for (var i = 0; i < markers.length; i++) {

            markers[i].setMap(map);

        } // for

    } // function



    // Removes the markers from the map, but keeps them in the array.

    function clearMarkers() {

        setMapOnAll(null);

    } // function clearMarkers



    function deleteMarkers() {

        clearMarkers();

        markers = [];

    } // function deleteMarkers

	

	function codeAddress() {

    var address = document.getElementById('address').value;

    geocoder.geocode( { 'address': address}, function(results, status) {

      if (status == google.maps.GeocoderStatus.OK) {

        map.setCenter(results[0].geometry.location);

    if (customerMarker) customerMarker.setMap(null);

        customerMarker = new google.maps.Marker({

            map: map,

            position: results[0].geometry.location

        });

    closest = findClosestN(results[0].geometry.location,10);

        // get driving distance

        closest = closest.splice(0,3);

        calculateDistances(results[0].geometry.location, closest,3);

      } else {

        alert('Geocode was not successful for the following reason: ' + status);

      }

    });

  }



function findClosestN(pt,numberOfResults) {

   var closest = [];

   document.getElementById('info').innerHTML += "processing "+gmarkers.length+"<br>";

   for (var i=0; i<gmarkers.length;i++) {

     gmarkers[i].distance = google.maps.geometry.spherical.computeDistanceBetween(pt,gmarkers[i].getPosition());

     document.getElementById('info').innerHTML += "process "+i+":"+gmarkers[i].getPosition().toUrlValue(6)+":"+gmarkers[i].distance.toFixed(2)+"<br>";

     gmarkers[i].setMap(null);

     closest.push(gmarkers[i]);

   }

   closest.sort(sortByDist);

   return closest;

}



function sortByDist(a,b) {

   return (a.distance- b.distance)

}



function calculateDistances(pt,closest,numberOfResults) {

  var service = new google.maps.DistanceMatrixService();

  var request =    {

      origins: [pt],

      destinations: [],

      travelMode: google.maps.TravelMode.DRIVING,

      unitSystem: google.maps.UnitSystem.METRIC,

      avoidHighways: false,

      avoidTolls: false

    };

  for (var i=0; i<closest.length; i++) request.destinations.push(closest[i].getPosition());

  service.getDistanceMatrix(request, function (response, status) {

    if (status != google.maps.DistanceMatrixStatus.OK) {

      alert('Error was: ' + status);

    } else {

      var origins = response.originAddresses;

      var destinations = response.destinationAddresses;

      var outputDiv = document.getElementById('side_bar');

      outputDiv.innerHTML = '';



      var results = response.rows[0].elements;

      for (var i = 0; i < numberOfResults; i++) {

        closest[i].setMap(map);

        outputDiv.innerHTML += "<a href='javascript:google.maps.event.trigger(closest["+i+"],\"click\");'>"+closest[i].title + '</a><br>' + closest[i].address+"<br>"

            + results[i].distance.text + ' appoximately '

            + results[i].duration.text + '<br><hr>';

      }

    }

  });

}

  </script>

    <script async defer

       src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-F5OhNohRAqyVLLJOXlEJPpzAu42XtXk&libraries=places&language=en&callback=initMap">

    </script>

   </body>

 </html>