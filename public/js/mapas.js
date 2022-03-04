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
//Sobre mi posicion
function getLocation() {
    if (navigator.geolocation) {
        //navigator.geolocation.clearWatch(id);
        //Coger posicion
        navigator.geolocation.getCurrentPosition(showPosition);
        if (routingControl != null) {
            //No borrar primera opción
            /*map.removeControl(routingControl);
            routingControl = L.Routing.control({
                draggableWaypoints: false,
                createMarker: function() { return null; },
                waypoints: [
                    L.latLng(myPosition.coords.latitude, myPosition.coords.longitude),
                    L.latLng(markerDestination.latlng.lat, markerDestination.latlng.lng)
                ],
                routeWhileDragging: false,
                fitSelectedRoutes: false,
            }).addTo(map);*/
            //console.log(routingControl.getWaypoints()[0]);
            //console.log(myPosition);
            routingControl.spliceWaypoints(0, 1, [myPosition.coords.latitude, myPosition.coords.longitude]);
        }
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
//Mostrar otras direcciones
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
                let icon = "";
                if (datos[i].icono_eti == 'sys_museo') {
                    icon = L.icon({
                        iconUrl: 'img/icon/ico_museo.png',
                        iconSize: [38, 38],
                        iconAnchor: [10, 10],
                    })
                } else if (datos[i].icono_eti == 'sys_ocio') {
                    icon = L.icon({
                        iconUrl: 'img/icon/ico_ocio.png',
                        iconSize: [38, 38],
                        iconAnchor: [10, 10],
                    })
                } else if (datos[i].icono_eti == 'sys_restaurante') {
                    icon = L.icon({
                        iconUrl: 'img/icon/ico_restaurante.png',
                        iconSize: [38, 38],
                        iconAnchor: [10, 10],
                    })
                } else if (datos[i].icono_eti == 'sys_playa') {
                    icon = L.icon({
                        iconUrl: 'img/icon/ico_playa.png',
                        iconSize: [38, 38],
                        iconAnchor: [10, 10],
                    })
                } else if (datos[i].icono_eti == 'sys_hotel') {
                    icon = L.icon({
                        iconUrl: 'img/icon/ico_hotel.png',
                        iconSize: [38, 38],
                        iconAnchor: [10, 10],
                    })
                } else if (datos[i].icono_eti == 'sys_supermercado') {
                    icon = L.icon({
                        iconUrl: 'img/icon/ico_supermercado.png',
                        iconSize: [38, 38],
                        iconAnchor: [10, 10],
                    })
                } else if (datos[i].icono_eti == 'sys_bar') {
                    icon = L.icon({
                        iconUrl: 'img/icon/ico_bar.png',
                        iconSize: [38, 38],
                        iconAnchor: [10, 10],
                    })
                } else if (datos[i].icono_eti == 'sys_hospital') {
                    icon = L.icon({
                        iconUrl: 'img/icon/ico_hospital.png',
                        iconSize: [38, 38],
                        iconAnchor: [10, 10],
                    })
                } else if (datos[i].icono_eti == 'sys_parque') {
                    icon = L.icon({
                        iconUrl: 'img/icon/ico_parque.png',
                        iconSize: [38, 38],
                        iconAnchor: [10, 10],
                    })
                }
                markerPosition.push(L.marker([datos[i].latitud_ubi, datos[i].longitud_ubi], { icon: icon }).on("click", getPositionDirection).addTo(map));
            }
        }
    }
    ajax.send(formData);
}

function getPositionDirection(e) {
    markerDestination = e;
    if (routingControl != null) {
        map.removeControl(routingControl);
    }
    routingControl = L.Routing.control({
        draggableWaypoints: false,
        createMarker: function() { return null; },
        waypoints: [
            L.latLng(myPosition.coords.latitude, myPosition.coords.longitude),
            L.latLng(e.latlng.lat, e.latlng.lng)
        ],
        routeWhileDragging: false,
        fitSelectedRoutes: false,
    }).addTo(map);
}
window.onload = function() {
    geocoder = L.esri.Geocoding.geocodeService();
    myMarker = {}
    routingControl = null
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