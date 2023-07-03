<div id="page">
    <div id="main">
        <?php
            include 'modules/lateral/buscador-avanzado.php';
        ?>

        <div id="content" class="column ocultBusca"  role="main">
            
            <h1 class="page__title title" id="page-title"><?=${"lang_".$idioma}['puntosdeventat'];?></h1>
             
            <div id="google-store-locator-map-container" class="google-store-locator-map-container">
                <div class="google-store-locator-panel storelocator-panel" id="locationField">
                    <div class="storelocator-filter" onsubmit="reenviar=true;">
                        <div class="location-search">
                            <h2><?=${"lang_".$idioma}['dondeestas'];?></h2>
                            <p><span><?=${"lang_".$idioma}['introduceunalocalidad'];?></span></p>
                            <form onsubmit="return cambiar_sitio();"><input id="autocompletemap" placeholder="<?=${"lang_".$idioma}['escribeunadireccion'];?>" type="text" class="pac-target-input" autocomplete="off" /></form>
                        </div>
                        <div class="feature-filter"></div>
                    </div>
                    <div id="stores-list">
                        <ul class="store-list">
                        </ul>
                    </div>
                </div>
                <div id="map" class="google-store-locator-map" style="position: relative; overflow: hidden;">
                    MAPA
                </div>
            </div>

        </div>

        <?php 
            include 'modules/busqueda/resultadoBusqueda.php';
        ?>
    </div>
</div>


<script type="text/javascript">function cambiar_sitio() { adivinar_localizacion(); return false; }

    function adivinar_localizacion() { jQuery.get("//maps.google.com/maps/api/geocode/json?address=" + jQuery("#autocompletemap").val(), function (data3, status) { fillInAddress(data3.results[0].geometry.location.lat, data3.results[0].geometry.location.lng); }); }

    var markers = []; function delete_markers() { clearMarkers(); }

    function addMarker(position, abrir) {

        console.log(position.email);
        
        var position_lmp = { lat: position.lat, lng: position.lng }; var iconBase = 'assets/images/'; var marker = new google.maps.Marker({ position: position_lmp, title: position.title, icon: iconBase + 'pin-fuster.png' }); marker.setMap(map); if (abrir) { infowindow.setContent("<h3>" + position.title + "</h3><br />" + position.direccion + "<br />" + position.cp + " " + position.localidad + "<br />" + position.provincia + "<br />" + position.pais + "<br />" + position.telefono + '<br /><a href="mailto:' + position.email + '" target="_top">' + position.email + "</a>"); infowindow.open(map, marker); }
        marker.addListener('click', function () { infowindow.setContent("<h3>" + position.title + "</h3><br />" + position.direccion + "<br />" + position.cp + " " + position.localidad + "<br />" + position.provincia + "<br />" + position.pais + "<br />" + position.telefono + '<br /><a href="mailto:' + position.email + '" target="_top">' + position.email + " </a><br />"); infowindow.open(map, marker); }); markers.push(marker);
    }

    positions = []; function initMap() { infowindow = new google.maps.InfoWindow({ content: "" }); map = new google.maps.Map(document.getElementById('map'), { center: { lat: 41.62, lng: -0.87 }, zoom: 6 }); initAutocomplete(); }

    var autocomplete; function initAutocomplete() {
        
        
        const options = {
            bounds: defaultBounds,
            componentRestrictions: { country: ["es", "pt"] }, //<-- cl es el ISO de Chile
            fields: ["address_components", "geometry", "icon", "name"],
            strictBounds: false,
            types: ["geocode"],
        };

        
        var defaultBounds = new google.maps.LatLngBounds(new google.maps.LatLng(50, 10), new google.maps.LatLng(35, -10)); autocomplete = new google.maps.places.Autocomplete((document.getElementById('autocompletemap')), options); autocomplete.addListener('place_changed', fillInAddress); autocomplete.bindTo('bounds', map); }

    function fillInAddress(lat, lng) {
        var place = autocomplete.getPlace(); if (place.geometry) { lat2 = place.geometry.location.lat(); lng2 = place.geometry.location.lng(); } else { if (lat && lng) { lat2 = lat; lng2 = lng; } else { return; } }
        jQuery.post("googlemaps/distance-calculator.php", { lat: lat2, lng: lng2 }, function (data, status) {
            map.setCenter(new google.maps.LatLng(lat2, lng2)); deleteMarkers(); data2 = JSON.parse(data); cadena = ""; for (var key in data2) { 
                
                showStore(parseFloat(data2[key].lat), parseFloat(data2[key].lng), data2[key].nombre, data2[key].email, data2[key].direccion, data2[key].provincia, data2[key].pais, data2[key].telefono, data2[key].localidad, data2[key].cp, data2[key].mostrar); cadena += "<li class='store'>"; cadena += "<a href='javascript: void(0);' onClick='showStore(" + data2[key].lat + "," + data2[key].lng + "," + "\"" + data2[key].nombre + "\"" + "," + "\"" + data2[key].email + "\"" + ",\"" + data2[key].direccion + "\"," + "\"" + data2[key].provincia + "\"," + "\"" + data2[key].pais + "\"," + "\"" + data2[key].telefono + "\"," + "\"" + data2[key].localidad + "\"" + ",\"" + data2[key].cp + "\"" + ", true);jQuery(\"html, body\").animate({scrollTop: jQuery(\"#map\").offset().top - 30 }, 1200 );'><div class='title'>" + data2[key].nombre + "</div></a>"; cadena += "<div class='address'>"; cadena += "<div class='street-block'><div class='thoroughfare'>" + data2[key].direccion + "</div></div>"; cadena += "<div class='addressfield-container-inline locality-block country-ES'><span class='locality'>" + data2[key].cp + " " + data2[key].localidad + "</span><br /><span class='state'>" + data2[key].provincia + "</span></div>"; cadena += "<span class='country'>" + data2[key].pais + "</span><div class='distance'>" + data2[key].distancia + "</div>"; cadena += "<div class='phone'>" + data2[key].telefono + "</div><div class='web'><a href=\"mailto:" + data2[key].email + "\" target=\"_top\">" + data2[key].email + "</a></div>"; cadena += "</li>"; }
            jQuery("#stores-list").html("<ul class='store-list'>" + cadena + "</ul>");
        });
    }

    function showStore(lat2, lng2, nombre, email, direccion, provincia, pais, telefono, localidad, cp, mostrar) { addMarker({ lat: lat2, lng: lng2, title: nombre, email: email, direccion: direccion, provincia: provincia, pais: pais, telefono: telefono, localidad: localidad, cp: cp }, mostrar); }

    function setMapOnAll(map) { for (var i = 0; i < markers.length; i++) { markers[i].setMap(map); } }

    function clearMarkers() { setMapOnAll(null); }

    function deleteMarkers() { clearMarkers(); markers = []; }

</script>


<?php 
    if($idioma=='en'){
?>
    <script async="" defer="" 
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-F5OhNohRAqyVLLJOXlEJPpzAu42XtXk&amp;libraries=places&amp;language=en&amp;callback=initMap">
    </script>
    
    <?php
    }else if($idioma=='fr'){
?>
    <script async="" defer="" 
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-F5OhNohRAqyVLLJOXlEJPpzAu42XtXk&amp;libraries=places&amp;language=fr&amp;callback=initMap">
    </script>
<?php
    }else{
?>
    <script async="" defer="" 
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-F5OhNohRAqyVLLJOXlEJPpzAu42XtXk&amp;libraries=places&amp;language=es&amp;callback=initMap">
    </script>
<?php
    }
?>