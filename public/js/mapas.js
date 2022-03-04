function objetoAjax() {
    var xmlhttp = false;
    try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (E) {
            xmlhttp = false;
        }
    }
    if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}

function getLocation() {
    if (navigator.geolocation) {
        //navigator.geolocation.clearWatch(id);
        //Coger posicion
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    myPosition = position;
    //Para que el mapa se centre en mi posicion actual que es donde se situará el marker
    //map.panTo(new L.LatLng(position.coords.latitude, position.coords.longitude));
    //map.setView([position.coords.latitude, position.coords.longitude], 30);
    var popup = L.popup();
    //Si el mapa tiene el marker de myMarker (mi posición) lo reestablecemos
    if (map.hasLayer(myMarker)) {
        map.removeLayer(myMarker);
    }
    myMarker = L.marker([position.coords.latitude, position.coords.longitude], { draggable: false, autoPan: false }).addTo(map);
}

function mostrarDirecciones() {
    let token = document.getElementById('token').getAttribute("content");
    let formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'POST');
    let ajax = objetoAjax();
    ajax.open("POST", "direcciones", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var datos = JSON.parse(this.responseText);
            console.log(datos);
            for (let i = 0; i < datos.length; i++) {
                //console.log(datos[i].id)
                markerPosition = [];
                removeRouting = false;
                markerPosition.push(L.marker([datos[i].latitud_ubi, datos[i].longitud_ubi]).on("click", getPositionDirection).addTo(map));
            }
        }
    }
    ajax.send(formData);
}

function getPositionDirection(e) {
    if (removeRouting != false) {
        map.removeControl(routingControl);
    } else {
        removeRouting = true;
    }
    routingControl = L.Routing.control({
        waypoints: [
            L.latLng(myPosition.coords.latitude, myPosition.coords.longitude),
            L.latLng(e.latlng.lat, e.latlng.lng)
        ],
        routeWhileDragging: false,
        draggableWaypoints: false,
        fitSelectedRoutes: false
    }).addTo(map);
}
window.onload = function() {
    geocoder = L.esri.Geocoding.geocodeService();
    myMarker = {}
    map = L.map('map');
    var tiles = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw'
    }).addTo(map);
    //El mapa le ponemos la vista hasta un maximo de zoom de 18
    map.locate({ setView: true, maxZoom: 18 });
    getLocation();
    mostrarDirecciones();
}
setInterval(getLocation, 2000);