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

var modal = document.getElementById("modal");

window.onclick = function(event) {
    if (event.target == modal) {
        modal.classList.add("hidden");
    }
}


function abrirModal() {
    modal.classList.remove("hidden")
}

//////////////////////////////////////////////////////////
//ETIQUETAS
//////////////////////////////////////////////////////////

function modalEtiquetas() {
    /* Si hace falta obtenemos el elemento HTML donde introduciremos la recarga (datos o mensajes) */
    /* Usar el objeto FormData para guardar los parámetros que se enviarán:
    formData.append('clave', valor);
    valor = elemento/s que se pasarán como parámetros: token, method, inputs... */
    var contenedor = document.getElementById("modalBox");
    var formData = new FormData();
    formData.append('_token', document.getElementById('token').getAttribute("content"));

    /* Inicializar un objeto AJAX */
    var ajax = objetoAjax();
    ajax.open("POST", "mostrarEtiqueta", true);
    ajax.onreadystatechange = function() {

        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(this.responseText);

            var recarga = '';
            recarga += `
            <h1 class="titulo-modal">Mis etiquetas</h1>
            <div class="contenido-modal">
                <div class="modal-first">
                    <div class="contenido">`
            for (let i = 0; i < respuesta.length; i++) {
                recarga += `
                    <div class="item">
                        <div class="nombre-item">${respuesta[i].nombre_eti}</div>
                        <div class="boton-item">
                            <form onsubmit="eliminarEtiqueta(${respuesta[i].id});return false;">
                                <div class="submit-eliminar-etiqueta">
                                    <button type="submit" class="icono-eliminar">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>`
            }
            recarga += `</div>
                </div>
                <div class="modal-second">
                    <form id="formCreateTag" method='POST' onsubmit="crearEtiqueta(); return false;">
                        <h2>Crear etiqueta</h2>
                        <input type="text" placeholder="Nueva etiqueta..." class="nombre-etiqueta-crear" name="nombre_eti">
                        <input type="submit" name="enviar" value="Crear etiqueta" class="btn-etiqueta">
                    </form>
                </div>
            </div>
            `;
            contenedor.innerHTML = recarga;
            abrirModal();
        }
    }
    ajax.send(formData);

}

function crearEtiqueta() {

    /* Si hace falta obtenemos el elemento HTML donde introduciremos la recarga (datos o mensajes) */
    /* Usar el objeto FormData para guardar los parámetros que se enviarán:
    formData.append('clave', valor);
    valor = elemento/s que se pasarán como parámetros: token, method, inputs... */
    console.log(document.getElementById('formCreateTag'));
    var formData = new FormData(document.getElementById('formCreateTag'));
    formData.append('_token', document.getElementById('token').getAttribute("content"));
    formData.append('_method', 'POST');
    /* Inicializar un objeto AJAX */
    var ajax = objetoAjax();
    ajax.open("POST", "crearEtiquetas", true);
    ajax.onreadystatechange = function() {

        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(this.responseText);

            if (respuesta.resultado == "OK") {
                /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
                //message.innerHTML = '<p>Nota creada correctamente.</p>';

            } else {
                /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                //    /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
                //message.innerHTML = 'Ha habido un error:' + respuesta.resultado;
            }
            modalEtiquetas();
        }
    }
    ajax.send(formData);
}

function eliminarEtiqueta(id) {

    /* Si hace falta obtenemos el elemento HTML donde introduciremos la recarga (datos o mensajes) */
    /* Usar el objeto FormData para guardar los parámetros que se enviarán:
    formData.append('clave', valor);
    valor = elemento/s que se pasarán como parámetros: token, method, inputs... */

    var formData = new FormData();
    formData.append('_token', document.getElementById('token').getAttribute("content"));
    formData.append('_method', 'DELETE');
    /* Inicializar un objeto AJAX */
    var ajax = objetoAjax();
    ajax.open("POST", "eliminarEtiquetas/" + id, true);
    ajax.onreadystatechange = function() {

        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(this.responseText);

            if (respuesta.resultado == "OK") {
                /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
                //message.innerHTML = '<p>Nota creada correctamente.</p>';

            } else {
                /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                //    /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
                //message.innerHTML = 'Ha habido un error:' + respuesta.resultado;
            }
            modalEtiquetas();
        }
    }
    ajax.send(formData);
}


////////////////////////////////////////////////////////////////////////////////
//EQUIPOS
////////////////////////////////////////////////////////////////////////////////

function modalEquipos() {
    /* Si hace falta obtenemos el elemento HTML donde introduciremos la recarga (datos o mensajes) */
    /* Usar el objeto FormData para guardar los parámetros que se enviarán:
    formData.append('clave', valor);
    valor = elemento/s que se pasarán como parámetros: token, method, inputs... */
    var contenedor = document.getElementById("modalBox");
    var formData = new FormData();
    formData.append('_token', document.getElementById('token').getAttribute("content"));

    /* Inicializar un objeto AJAX */
    var ajax = objetoAjax();
    ajax.open("POST", "mostrarEquipo", true);
    ajax.onreadystatechange = function() {

        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(this.responseText);

            var recarga = '';
            recarga += `
            <h1 class="titulo-modal">Equipos</h1>`
            if (respuesta[0].nick_usu) {
                recarga += `<h2 class="subtitulo-modal">Actualmente preteneces al equipo <span>${respuesta[0].nombre_equ}</span></h2>`
            } else {
                recarga += `<h2 class="subtitulo-modal">Actualmente no perteneces a ningún equipo</h2>`
            }
            recarga += `<div class="contenido-modal">`
            recarga += `<div class="modal-first">`
            if (respuesta[0].nick_usu) {
                recarga += `
                    <h3>Miembros del equipo "${respuesta[0].nombre_equ}": </h3>
                    <div class="contenido">`
                for (let i = 0; i < respuesta.length; i++) {
                    recarga += `
                            <div class="item">
                                <div class="nombre-item">${respuesta[i].nick_usu}</div>
                            </div>`
                }
            } else {
                recarga += `
                <h3>Unirse a un equipo:</h3>
                <div class="contenido">`
                for (let i = 0; i < respuesta.length; i++) {
                    recarga += `
                    
                        <div class="item">
                        <button class="item-click">
                            <div class="nombre-item">${respuesta[i].nombre_equ}</div>
                            `
                    if (respuesta[i].contra_equ != "") {
                        recarga += `<div class="boton-item"><i class="fas fa-lock" style="color:orange;"></i></div>`
                    } else {
                        recarga += `<div class="boton-item"><i class="fa fa-unlock" style="color:green;"></i></div>`
                    }
                    recarga += `
                    </button>
                        </div>`
                }
            }

            recarga += `</div>
                </div>
                <div class="modal-second">
                    `
            if (respuesta[0].nick_usu) {
                recarga += `<form id="formCreateTag" method='POST' onsubmit="abandonarEquipo(); return false;">
                                <h2>Abandonar equipo</h2>
                                <input type="submit" name="enviar" value="Haz click aquí para abandonar" class="btn-etiqueta">
                            </form>
            `

            } else {
                recarga += `<form id="formCreateTag" method='POST' onsubmit="crearEquipo(); return false;">
                                <h2>Crear equipo</h2>
                                <input type="text" placeholder="Nombre del equipo..." class="nombre-etiqueta-crear" name="nombre_equ">
                                <input type="submit" name="enviar" value="Crear" class="btn-etiqueta">
                            </form>
            `
            }
            `
                </div>
            </div>
            `;
            contenedor.innerHTML = recarga;
            abrirModal();
        }
    }
    ajax.send(formData);

}


function abandonarEquipo() {
    /* Si hace falta obtenemos el elemento HTML donde introduciremos la recarga (datos o mensajes) */
    /* Usar el objeto FormData para guardar los parámetros que se enviarán:
    formData.append('clave', valor);
    valor = elemento/s que se pasarán como parámetros: token, method, inputs... */
    var formData = new FormData();
    formData.append('_token', document.getElementById('token').getAttribute("content"));
    formData.append('_method', 'PUT');
    /* Inicializar un objeto AJAX */
    var ajax = objetoAjax();
    ajax.open("POST", "abandonarEquipo", true);
    ajax.onreadystatechange = function() {

        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(this.responseText);
            if (respuesta.resultado == "OK") {
                /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
                //message.innerHTML = '<p>Nota creada correctamente.</p>';
                alert("BIEN")
            } else {
                /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                //    /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
                //message.innerHTML = 'Ha habido un error:' + respuesta.resultado;
                alert("MAL")
            }
            modalEquipos();
        }
    }
    ajax.send(formData);
}


///////////////////////////////////////////////////////////////////////////////////////////////////////