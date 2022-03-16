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
        } else if (datos[i].icono_eti == 'sys_user') {
            icon = L.icon({
                iconUrl: 'img/icon/ico_user.png',
                iconSize: [38, 38],
                iconAnchor: [10, 10],
            })
        }
        //Este funciona para ruta
        //markerPosition.push(L.marker([datos[i].latitud_ubi, datos[i].longitud_ubi], { icon: icon }).on("click", getPositionDirection).addTo(map));
        //Este es de prueba de pop up más sacar la posicion
        strPopUpHTML += "<div>";
        strPopUpHTML += "<h1>" + datos[i].nombre_ubi + "</h1>";
        let tagsDireccion = await TagsDireccion(datos[i].id);
        if (tagsDireccion.length == 1) {
            strPopUpHTML += "<p>" + tagsDireccion[0].nombre_eti + "</p>";
        } else {
            strPopUpHTML += "<p>";
            for (let i = 0; i < tagsDireccion.length; i++) {
                strPopUpHTML += tagsDireccion[i].nombre_eti + " / ";
            }
            strPopUpHTML += "</p>";
        }
        strPopUpHTML += "<h3>" + datos[i].direccion_ubi + "</h3>";
        strPopUpHTML += "<p>" + datos[i].descripcion_ubi + "</p>";
        strPopUpHTML += "<img src='storage/" + datos[i].foto_ubi + "'/>";
        strPopUpHTML += "<button onclick='getPositionDirection(\"" + datos[i].latitud_ubi + "\",\"" + datos[i].longitud_ubi + "\");'>Coger ubicación</button>";
        strPopUpHTML += "<button onclick='getUserTags(" + datos[i].id + ");'>Agregar etiqueta</button>";
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
    }).addTo(map);
    btnQuitRoute.style.display = 'block';
    btnQuitRoute.onclick = function() {
        btnQuitRoute.style.display = 'none';
        map.removeControl(routingControl);
        routingControl = null;
    }
}

function getUserTags(idUbicacion) {
    let token = document.getElementById('token').getAttribute("content");
    let formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'POST');
    let ajax = objetoAjax();
    ajax.open("POST", "etiquetas/usuarios", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var datos = JSON.parse(this.responseText);
            for (let i = 0; i < datos.length; i++) {
                mostrarEtiquetasAgregadas(datos[i], idUbicacion);
            }
        }
    }
    ajax.send(formData);
}

function mostrarEtiquetasAgregadas(etiquetasUser, idUbicacion) {
    let divTags = document.getElementById('divUserTags');
    let strDivTags = "";
    let token = document.getElementById('token').getAttribute("content");
    let formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'GET');
    let ajax = objetoAjax();
    ajax.open("POST", "etiquetas/usuarios/" + idUbicacion + "/" + etiquetasUser.id, true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var datos = JSON.parse(this.responseText);
            if (datos.length == 0) {
                strDivTags += `<input type="checkbox" onclick="addDeleteTagDirection(this,${idUbicacion},${etiquetasUser.id})">${etiquetasUser.nombre_eti}`
                    //console.log(etiquetasUser);
            } else {
                strDivTags += `<input type="checkbox" onclick="addDeleteTagDirection(this,${idUbicacion},${etiquetasUser.id})" checked>${etiquetasUser.nombre_eti}`
            }
            divTags.innerHTML = strDivTags;
        }
    }
    ajax.send(formData);
}

function addDeleteTagDirection(checkbox, idUbicacion, idEtiqueta) {
    if (checkbox.checked) {
        //Agregar
        addTagDirection(idUbicacion, idEtiqueta)
            //console.log("Check");
    } else {
        //Eliminar
        console.log("notcheck");
        deleteTagDirection(idUbicacion, idEtiqueta);
    }
}

function addTagDirection(idUbicacion, idEtiqueta) {
    let token = document.getElementById('token').getAttribute("content");
    let formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'GET');
    let ajax = objetoAjax();
    ajax.open("POST", "etiquetas/usuarios/add/" + idUbicacion + "/" + idEtiqueta, true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            console.log("Dentro");
            var respuesta = JSON.parse(ajax.responseText);
            if (respuesta.resultado == "OK") {
                /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
                //message.innerHTML = '<p>Nota creada correctamente.</p>';
            } else {
                console.log(respuesta.resultado)
                    /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                    //    /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
                    //message.innerHTML = 'Ha habido un error:' + respuesta.resultado;
            }
        }
    }
    ajax.send(formData);
}

function deleteTagDirection(idUbicacion, idEtiqueta) {
    let token = document.getElementById('token').getAttribute("content");
    let formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'GET');
    let ajax = objetoAjax();
    ajax.open("POST", "etiquetas/usuarios/delete/" + idUbicacion + "/" + idEtiqueta, true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(this.responseText);
            if (respuesta.resultado == "OK") {
                /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
                //message.innerHTML = '<p>Nota creada correctamente.</p>';
            } else {
                console.log(respuesta.resultado)
                    /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                    //    /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
                    //message.innerHTML = 'Ha habido un error:' + respuesta.resultado;
            }
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
        zoomOffset: -1,
        accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw'
    }).addTo(map);
    //El mapa le ponemos la vista hasta un maximo de zoom de 18
    map.locate({ setView: true, maxZoom: 18 });
    getLocation();
    mostrarDirecciones();
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

function GincanaEquipo(idGincana) {
    return new Promise(function(resolve, reject) {
        let token = document.getElementById('token').getAttribute("content");
        let formData = new FormData();
        formData.append('_token', token);
        formData.append('_method', 'GET');
        let ajax = objetoAjax();
        ajax.open("POST", "equipo/gimcana/" + idGincana, true);
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

async function IniciarGincana(id) {
    cerrarModal();
    deleteSessionGincana();
    idEquipo_Global = 0;
    idGincana_Global = 0;
    objetivoNum = 0;
    gincana = 0;
    infoObjetivos = null;
    let teamInGame = await GincanaEquipo(id);
    polygon = L.polygon([
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
            //console.log(respuesta);
            //question(results);
            if (respuesta.id_equipo == null) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error...',
                    text: 'Debes estar en un equipo!'
                })
            } else {
                //console.log(Object.keys(teamInGame).length);
                idEquipo_Global = respuesta.id_equipo;
                idGincana_Global = id;
                if (Object.keys(teamInGame).length != 0) {
                    //console.log(teamInGame);
                    cargarJuego(id, respuesta.id_equipo);
                } else {
                    //console.log("No hay registro");
                    iniciarJuego(id, respuesta.id_equipo);
                }
            }
        }
    }
    ajax.send(formData);
}

function cargarJuego(idGincana, idEquipo) {
    //console.log(idGincana);
    //console.log(idEquipo);
    //console.log("Numero objetivo: " + objetivoNum)
    intervalDistance = null;
    /* Si hace falta obtenemos el elemento HTML donde introduciremos la recarga (datos o mensajes) */
    /* Usar el objeto FormData para guardar los parámetros que se enviarán:
    formData.append('clave', valor);
    valor = elemento/s que se pasarán como parámetros: token, method, inputs... */
    if (infoObjetivos == null) {
        var formData = new FormData();
        formData.append('_token', document.getElementById('token').getAttribute("content"));
        /* Inicializar un objeto AJAX */
        var ajax = objetoAjax();
        ajax.open("GET", "equipo/gimcana/cargar/" + idGincana, true);
        ajax.onreadystatechange = function() {

            if (ajax.readyState == 4 && ajax.status == 200) {
                var respuesta = JSON.parse(this.responseText);
                infoObjetivos = respuesta;
                gincana = respuesta.length;
                mostrarObjetivo(infoObjetivos);
            }
        }
        ajax.send(formData);
    } else {
        mostrarObjetivo(infoObjetivos);
    }
}

function iniciarJuego(idGincana, idEquipo) {
    var formData = new FormData();
    formData.append('_token', document.getElementById('token').getAttribute("content"));
    formData.append('_method', 'GET');

    var ajax = objetoAjax();

    ajax.open("GET", "equipo/gimcana/incio/" + idGincana + "/" + idEquipo, true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(this.responseText);
            if (respuesta.resultado == "OK") {
                /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
                //message.innerHTML = '<p>Nota creada correctamente.</p>';
                cargarJuego(idGincana, idEquipo);

            } else {
                /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                //    /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
                //message.innerHTML = 'Ha habido un error:' + respuesta.resultado;
            }
        }
    }
    ajax.send(formData);
}

function contPlayers(idGincana, idEquipo) {
    return new Promise(function(resolve, reject) {
        let token = document.getElementById('token').getAttribute("content");
        let formData = new FormData();
        formData.append('_token', token);
        formData.append('_method', 'GET');
        let ajax = objetoAjax();
        ajax.open("POST", "gincana/jugadores/" + idGincana + "/" + idEquipo, true);
        ajax.onreadystatechange = function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                /*setTimeout(function() {ss
                    resolve(JSON.parse(ajax.responseText));
                }, 3000);*/
                //console.log(ajax.responseText);
                resolve(JSON.parse(ajax.responseText));
            }
        }
        ajax.send(formData);
    });
}

function comprobarPosicion(meLatitud, meLongitud, latitudUbi, longitudUbi, idParticipante) {
    /*console.log(meLatitud);
    console.log(meLongitud);
    console.log(latitudUbi);
    console.log(longitudUbi);
    console.log(parseFloat(latitudUbi));
    console.log(parseFloat(longitudUbi));*/
    rad = function(x) { return x * Math.PI / 180; }
    var R = 6378.137; //Radio de la tierra en km
    var dLat = rad(parseFloat(latitudUbi) - meLatitud);
    var dLong = rad(parseFloat(longitudUbi) - meLongitud);
    var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.cos(rad(meLatitud)) * Math.cos(rad(parseFloat(latitudUbi))) * Math.sin(dLong / 2) * Math.sin(dLong / 2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    var d = R * c;
    d = d.toFixed(3) * 1000;
    //console.log(d + "m");
    //if (d <= 500) {
    if (d <= 500) {
        //console.log("Cerca");
        //clearInterval(intervalDistance);
        updateEstado(idParticipante);
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Posición Incorrecta',
            text: 'Sigue investigando...'
        })
    }
}

async function updateEstado(idParticipante) {
    let token = document.getElementById('token').getAttribute("content");
    let formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'GET');
    let ajax = objetoAjax();
    ajax.open("POST", "participantes/estado/" + idParticipante, true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            //console.log(ajax.responseText);
            var respuesta = JSON.parse(ajax.responseText);
            //console.log(respuesta)
            if (respuesta.resultado == "OK") {
                objetivoNum = objetivoNum + 1
                intervalWaitAllPlayers = null;
                if (gincana != objetivoNum) {
                    //setInterval(mostrarObjetivo, 10000, infoObjetivos);
                    //deleteSessionGincana();
                    if (intervalWaitAllPlayers) {
                        clearInterval(intervalWaitAllPlayers);
                    }
                    //let prueba = await deleteSessionGincana()
                    deleteSessionGincana();
                    mostrarObjetivo(infoObjetivos);
                } else {
                    //cleartInterval();
                    //deleteSessionGincana();
                    if (intervalWaitAllPlayers) {
                        clearInterval(intervalWaitAllPlayers);
                    }
                    //let prueba = await deleteSessionGincana()
                    deleteSessionGincana();
                    finalizarJuego(idParticipante);
                }
            } else if (respuesta.resultado == "EQUIPO_INCOMPLETO") {
                document.getElementById("messageAllUsers").style.display = "block";
                document.getElementById("messageAllUsers").innerHTML = "<p>Faltan más jugadores por llegar, espera a que lleguen los demás</p>";
                intervalWaitAllPlayers = setInterval(waitPlayers, 10000, idParticipante);
                //console.log(idEquipo_Global)
                //console.log(idGincana_Global)
                Swal.fire({
                        icon: 'warning',
                        title: 'Posicion correcta',
                        text: 'Faltan jugadores de tu equipo por llegar...'
                    })
                    //setInterval(mostrarObjetivo, 10000, infoObjetivos);
                    //updateEstado(idParticipante);
            } else {

            }
        }
    }
    ajax.send(formData);
}

async function waitPlayers(idParticipante) {
    let quantityPlayersInPosition = await contPlayers(idGincana_Global, idEquipo_Global);
    if (quantityPlayersInPosition.length == 0 || quantityPlayersInPosition[0].estado == 0) {
        clearInterval(intervalWaitAllPlayers);
        objetivoNum = objetivoNum + 1
        if (gincana != objetivoNum) {
            //setInterval(mostrarObjetivo, 10000, infoObjetivos);
            deleteSessionGincana();
            mostrarObjetivo(infoObjetivos);
        } else {
            //cleartInterval(intervalWaitAllPlayers);
            deleteSessionGincana();
            finalizarJuego(idParticipante);
        }
    }
}

function finalizarJuego(idParticipante) {
    map.removeLayer(polygon);
    let token = document.getElementById('token').getAttribute("content");
    let formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'DELETE');
    let ajax = objetoAjax();
    ajax.open("POST", "participantes/eliminar/" + idParticipante, true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(this.responseText);
            if (respuesta.resultado == "OK") {
                Swal.fire({
                    icon: 'success',
                    title: 'Felicitaciones!!!',
                    text: 'Has terminado el juego con exito...'
                })
                var contenedor = document.getElementById("messageGame");
                contenedor.style.display = "none";
            } else {

            }
        }
    }
    ajax.send(formData);
}

function deleteSessionGincana() {
    //console.log("Cierro session");
    //return new Promise(function(resolve, reject) {
    let token = document.getElementById('token').getAttribute("content");
    let formData = new FormData();
    formData.append('_token', token);
    formData.append('_method', 'POST');
    let ajax = objetoAjax();
    ajax.open("POST", "participantes/eliminar/session", true);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(this.responseText);
            if (respuesta.resultado == "OK") {
                //resolve(respuesta.resultado);
            } else {
                console.log(respuesta.resultado);
                //reject(respuesta.resultado);
            }
        }
    }
    ajax.send(formData);
    //});
}
async function mostrarObjetivo(respuestaObjetivo) {
    var contenedor = document.getElementById("messageGame");
    let quantityPlayersInPosition = await contPlayers(idGincana_Global, idEquipo_Global);
    var recarga = '';
    recarga += `
            <h1 class="">Objetivo Gimcana</h1>
            <div class="">
                <div class="">
                    <div class="">
                        <div class="">
                            <div class="">${respuestaObjetivo[objetivoNum].nombre_obj}</div>
                            <div id="messageAllUsers" style="display:none;"></div>
                            <div class=""><button onclick="comprobarPosicion(${myPosition.coords.latitude}, ${myPosition.coords.longitude}, ${respuestaObjetivo[objetivoNum].latitud_ubi}, ${respuestaObjetivo[objetivoNum].longitud_ubi}, ${quantityPlayersInPosition[0].id})">Comprobar posicion</button></div>
                        </div>
                    </div>
                </div>
            </div>
            `;
    contenedor.innerHTML = recarga;
    //intervalDistance = setInterval(comprobarPosicion(myPosition.coords.latitude, myPosition.coords.longitude, respuesta.latitud_ubi, respuesta.longitud_ubi), 1000);
    //intervalDistance = setInterval(comprobarPosicion, 1000, myPosition.coords.latitude, myPosition.coords.longitude, respuesta.latitud_ubi, respuesta.longitud_ubi);
    //comprobarPosicion(myPosition.coords.latitude, myPosition.coords.longitude, respuestaObjetivo[objetivoNum].latitud_ubi, respuestaObjetivo[objetivoNum].longitud_ubi, quantityPlayersInPosition[0].id);
}