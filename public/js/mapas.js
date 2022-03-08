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
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    myPosition = position;
    if (routingControl != null) {
        //En caso que exista una ruta le pasamos mi posicion actual a la ruta para que cambie la posicion (así modo maps de ir de un sitio a otro y se actualiza mi posición)
        routingControl.spliceWaypoints(0, 1, [myPosition.coords.latitude, myPosition.coords.longitude]);
    }
    //Para que el mapa se centre en mi posicion actual que es donde se situará el marker
    //map.panTo(new L.LatLng(position.coords.latitude, position.coords.longitude));
    //map.setView([position.coords.latitude, position.coords.longitude], 30);
    //var popup = L.popup();
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
            infoUbicacion(datos);
        }
    }
    ajax.send(formData);
}
//filtro por Etiquetas
function filtroEtiqueta(id) {
    let token = document.getElementById('token').getAttribute("content");
    let formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'GET');
    let ajax = objetoAjax();
    ajax.open("POST", "etiqueta/" + id, true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var datos = JSON.parse(this.responseText);
            infoUbicacion(datos);
        }
    }
    ajax.send(formData);
}

function infoUbicacion(datos) {
    if (markerPosition != []) {
        for (let y = 0; y < markerPosition.length; y++) {
            map.removeLayer(markerPosition[y]);
        }
        markerPosition = [];
    }
    if (routingControl != null) {
        //En caso que exista una ruta le pasamos mi posicion actual a la ruta para que cambie la posicion (así modo maps de ir de un sitio a otro y se actualiza mi posición)
        map.removeControl(routingControl);
        btnQuitRoute.style.display = 'none';
    }
    for (let i = 0; i < datos.length; i++) {
        let strPopUpHTML = "";
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
        //Este funciona para ruta
        //markerPosition.push(L.marker([datos[i].latitud_ubi, datos[i].longitud_ubi], { icon: icon }).on("click", getPositionDirection).addTo(map));
        //Este es de prueba de pop up más sacar la posicion
        strPopUpHTML += "<div>";
        strPopUpHTML += "<h1>" + datos[i].nombre_ubi + "</h1>";
        strPopUpHTML += "<p>" + datos[i].descripcion_ubi + "</p>";
        strPopUpHTML += "<img src='storage/" + datos[i].foto_ubi + "'/>";
        strPopUpHTML += "<button onclick='getPositionDirection(\"" + datos[i].latitud_ubi + "\",\"" + datos[i].longitud_ubi + "\");'>Coger ubicación</button>";
        strPopUpHTML += "</div>";
        console.log(strPopUpHTML);
        markerPosition.push(L.marker([datos[i].latitud_ubi, datos[i].longitud_ubi], { icon: icon })
            .bindPopup(strPopUpHTML)
            .addTo(map));
    }
}

function getPositionDirection(lat, lng) {
    //markerDestination = { lat, lng };
    if (routingControl != null) {
        map.removeControl(routingControl);
    }
    routingControl = L.Routing.control({
        draggableWaypoints: false,
        createMarker: function() { return null; },
        waypoints: [
            L.latLng(myPosition.coords.latitude, myPosition.coords.longitude),
            L.latLng(lat, lng)
        ],
        addWaypoints: false,
        routeWhileDragging: false,
        fitSelectedRoutes: false,
    }).addTo(map);
    btnQuitRoute.style.display = 'block';
    btnQuitRoute.onclick = function() {
        btnQuitRoute.style.display = 'none';
        map.removeControl(routingControl);
    }
}
window.onload = function() {
    geocoder = L.esri.Geocoding.geocodeService();
    myMarker = {};
    markerPosition = [];
    routingControl = null
    btnQuitRoute = document.getElementById('btnQuitRoute');
    btnQuitRoute.style.display = 'none';
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