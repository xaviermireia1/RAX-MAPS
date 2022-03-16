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

function get_filter() { //Estilos etiquetas

    var listaFiltro = document.getElementsByClassName("etiqueta");
    for (var i = 0; i < listaFiltro.length; i += 1) {

        if (listaFiltro[i].checked == true) {
            listaFiltro[i].parentElement.style.backgroundColor = "#69a6d9";

        } else {
            listaFiltro[i].parentElement.style.backgroundColor = "lightgrey";

        }
    }
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
            get_filter();
        }
    }
    ajax.send(formData);
}

async function infoUbicacion(datos) {
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
        strPopUpHTML = "";
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
        strPopUpHTML += "<div class='contenido-popup'>";
        strPopUpHTML += "<h1 class='nombre-ubicacion'>" + datos[i].nombre_ubi + "</h1>";
        strPopUpHTML += "<div class='etiquetas-ubicacion'>";
        let tagsDireccion = await TagsDireccion(datos[i].id);
        if (tagsDireccion.length == 1) {
            strPopUpHTML += "<p>" + tagsDireccion[0].nombre_eti + "</p>";
        } else {
            strPopUpHTML += "<p>/" + tagsDireccion[0].nombre_eti + "/</p>";
        }
        strPopUpHTML += "</div>";
        strPopUpHTML += "<h3 class='direccion-ubicacion'>" + datos[i].direccion_ubi + "</h3>";
        strPopUpHTML += "<p class='descripcion-ubicacion'>" + datos[i].descripcion_ubi + "</p>";
        strPopUpHTML += "<img src='storage/" + datos[i].foto_ubi + "'/>";
        strPopUpHTML += "<div class='botones-ubicacion'>"
        strPopUpHTML += "<button onclick='getPositionDirection(\"" + datos[i].latitud_ubi + "\",\"" + datos[i].longitud_ubi + "\");'><i class='fa-solid fa-location-arrow'></i> Coger ubicación</button>";
        strPopUpHTML += "<button onclick='getUserTags(" + datos[i].id + ");'><i class='fa-solid fa-tag'></i> Agregar etiqueta</button>";
        strPopUpHTML += "</div>"
        strPopUpHTML += "<div id='divUserTags'></div>";
        strPopUpHTML += "</div>";
        //strPopUpHTML += "<p>" + result[0].nombre_eti + "</p>";
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
        position: 'bottomright',
    }).addTo(map);
    btnQuitRoute.style.display = 'block';
    document.getElementById("btnQuitRoute").focus();
    btnQuitRoute.onclick = function() {
        btnQuitRoute.style.display = 'none';
        map.removeControl(routingControl);
        routingControl = null;
    }
}

function getUserTags(idUbicacion) {
    let divTags = document.getElementById('divUserTags');
    let strDivTags = "";
    let token = document.getElementById('token').getAttribute("content");
    let formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'POST');
    let ajax = objetoAjax();
    ajax.open("POST", "etiquetas/usuarios", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var datos = JSON.parse(this.responseText);
            if (datos.length != 0) {
                for (let i = 0; i < datos.length; i++) {
                    strDivTags += "<p>" + datos[i].nombre_eti + "</p>";
                }
            } else {
                strDivTags = "<p>No existe ninguna etiqueta</p>";
            }
            divTags.innerHTML = strDivTags;
        }
    }
    ajax.send(formData);
}

function TagsDireccion(idUbicacion) {
    return new Promise(function(resolve, reject) {
        let token = document.getElementById('token').getAttribute("content");
        let formData = new FormData();
        formData.append('_token', token);
        formData.append('_method', 'GET');
        let ajax = objetoAjax();
        ajax.open("POST", "etiquetas/direcciones/" + idUbicacion, true);
        ajax.onreadystatechange = function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                /*setTimeout(function() {
                    resolve(JSON.parse(ajax.responseText));
                }, 3000);*/
                resolve(JSON.parse(ajax.responseText));
            }
        }
        ajax.send(formData);
    });
}

/*async function getTagsDireccion(idUbicacion) {
    let tagsDireccion = await TagsDireccion(idUbicacion);
    console.log(tagsDireccion);
}*/

window.onload = function() {
    geocoder = L.esri.Geocoding.geocodeService();
    myMarker = {};
    markerPosition = [];
    routingControl = null;
    btnQuitRoute = document.getElementById('btnQuitRoute');
    btnQuitRoute.style.display = 'none';
    map = L.map('map');
    var tiles = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomControl: false,
        zoomOffset: -1,
        accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw'
    }).addTo(map);
    //El mapa le ponemos la vista hasta un maximo de zoom de 18
    map.locate({ setView: true, maxZoom: 18 });
    getLocation();
    mostrarDirecciones();
    map.addControl(L.control.zoom({ position: 'bottomleft' }));

}
setInterval(getLocation, 2000);



//------------------------------------------ GINCANA-----------------------------------//

var modal = document.getElementById("modal");

window.onclick = function(event) {
    if (event.target == modal) {
        modal.classList.add("hidden");
    }
}

function abrirModal() {
    modal.classList.remove("hidden")
}

function cerrarModal() {
    modal.classList.add("hidden")
}

function modalGincana() {
    /* Si hace falta obtenemos el elemento HTML donde introduciremos la recarga (datos o mensajes) */
    /* Usar el objeto FormData para guardar los parámetros que se enviarán:
    formData.append('clave', valor);
    valor = elemento/s que se pasarán como parámetros: token, method, inputs... */
    var contenedor = document.getElementById("modalBox");
    var formData = new FormData();
    formData.append('_token', document.getElementById('token').getAttribute("content"));

    /* Inicializar un objeto AJAX */
    var ajax = objetoAjax();
    ajax.open("POST", "mostrarGincana", true);
    ajax.onreadystatechange = function() {

        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(this.responseText);

            var recarga = '';
            recarga += `
            <h1 class="titulo-modal">Gimcanas Disponibles</h1>
            <div class="contenido-modal">
                <div class="modal-first">
                    <div class="contenido">`
            for (let i = 0; i < respuesta.length; i++) {
                recarga += `
                    <div class="item">
                        <div class="nombre-item">${respuesta[i].nombre_gin}</div>
                        <div class="boton-item">
                            <form onsubmit="IniciarGincana(${respuesta[i].id});return false;">
                                <div class="submit-eliminar-etiqueta">
                                    <button type="submit" class="icono-iniciar">
                                        <i class="fa-solid fa-play"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>`
            }
            recarga += `</div>
                </div>
            </div>
            `;
            contenedor.innerHTML = recarga;
            abrirModal();
        }
    }
    ajax.send(formData);
}

function IniciarGincana(id) {
    cerrarModal();
    var polygon = L.polygon([
        [41.357596, 2.183804],
        [41.383637, 2.182141],
        [41.387918, 2.195807],
        [41.384903, 2.199920],
        [41.380766, 2.197533],
        [41.374282, 2.194663],
        [41.357662, 2.185403]
    ]).addTo(map);

    var formData = new FormData();
    formData.append('_token', document.getElementById('token').getAttribute("content"));
    formData.append('_method', 'POST');

    var ajax = objetoAjax();

    ajax.open("POST", "comprobarEquipo", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(this.responseText);
            console.log(respuesta);
            //question(results);
            if (respuesta.id_equipo == null) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error...',
                    text: 'Debes estar en un equipo!'
                })
            } else {
                alert("Estas en un equipo")
            }
        }
    }
    ajax.send(formData);
}