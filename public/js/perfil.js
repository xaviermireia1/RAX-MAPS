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

function cerrarModal() {
    modal.classList.add("hidden")
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
            <div class="cerrar-modal">
                <i class="fa-solid fa-xmark" onclick="cerrarModal();"></i>
            </div>
            <div class="titulo-modal-div">
                <h1 class="titulo-modal">Mis etiquetas</h1>
            </div>
            <div class="contenido-modal">
                <div class="modal-first">
                    <div class="contenido">`
            for (let i = 0; i < respuesta.length; i++) {
                recarga += `
                    <div class="item etiqueta">
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
                    <form id="formCreateTag" method='POST' onsubmit="crearEtiqueta(); return false;" class="form-create-tag">
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
            respuesta = JSON.parse(this.responseText);

            var recarga = '';
            recarga += `
            <div class="cerrar-modal" onclick="cerrarModal();">
                <i class="fa-solid fa-xmark"></i>
            </div>
            <div class="titulo-modal-div">
            <h1 class="titulo-modal">Equipos</h1>`
            if (respuesta[0].nick_usu) {
                recarga += `<h2 class="subtitulo-modal">Actualmente preteneces al equipo <span>${respuesta[0].nombre_equ}</span></h2>`
            } else {
                recarga += `<h2 class="subtitulo-modal">Actualmente no perteneces a ningún equipo</h2>`
            }

            recarga += `</div><div class="contenido-modal">`
            recarga += `<div class="modal-first">`
            if (respuesta[0].nick_usu) {
                recarga += `
                    <h3 class="sticky">Miembros del equipo "${respuesta[0].nombre_equ}": </h3>
                    <div class="contenido">`
                for (let i = 0; i < respuesta.length; i++) {
                    recarga += `
                            <div class="item miembro">
                                <div class="nombre-item">${respuesta[i].nick_usu}</div>
                            </div>`
                }
            } else {
                recarga += `
                <h3 class="sticky">Unirse a un equipo:</h3>
                <div class="contenido">`
                for (let i = 0; i < respuesta.length; i++) {
                    recarga += `
                    
                        <div class="item equipo">
                            `
                    if (respuesta[i].contra_equ != "" && respuesta[i].contra_equ != null) {
                        recarga += `
                        <button class="item-click" onclick="modalContraseña(${respuesta[i].id});">
                            <div class="nombre-item">${respuesta[i].nombre_equ}</div>
                            <div class="boton-item"><i class="fas fa-lock" style="color:orange;"></i></div>`
                    } else {
                        recarga += `
                        <button class="item-click" onclick="unirseEquipo(${respuesta[i].id});">
                        <div class="nombre-item">${respuesta[i].nombre_equ}</div>
                            <div class="boton-item"><i class="fa fa-unlock" style="color:green;"></i></div>`
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
                recarga += `<form method='POST' onsubmit="abandonarEquipo(); return false;" class="form-abandonar-equipo">
                                <h2>Abandonar equipo</h2>
                                <input type="submit" name="enviar" value="Abandonar" class="btn-etiqueta">
                            </form>
            `

            } else {
                recarga += `<form id="formCreateTeam" method='POST' onsubmit="crearEquipo(); return false;" class="form-crear-equipo">
                                <h2>Crear equipo</h2>
                                <input type="text" placeholder="Nombre del equipo..." class="nombre-etiqueta-crear" name="nombre_equ">
                                <input type="password" placeholder="Contraseña (Opcional)..." class="nombre-etiqueta-crear" name="contra_equ">
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
            } else {
                /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                //    /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
                //message.innerHTML = 'Ha habido un error:' + respuesta.resultado;
            }
            modalEquipos();
        }
    }
    ajax.send(formData);
}


function unirseEquipo(id) {
    /* Si hace falta obtenemos el elemento HTML donde introduciremos la recarga (datos o mensajes) */
    /* Usar el objeto FormData para guardar los parámetros que se enviarán:
    formData.append('clave', valor);
    valor = elemento/s que se pasarán como parámetros: token, method, inputs... */
    var formData = new FormData();
    if (document.getElementById('contra_equ')) {
        formData.append('contra_equ', document.getElementById('contra_equ').value)
    }
    formData.append('_token', document.getElementById('token').getAttribute("content"));
    formData.append('_method', 'PUT');
    /* Inicializar un objeto AJAX */
    var ajax = objetoAjax();


    ajax.open("POST", "unirseEquipo/" + id, true);

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
            modalEquipos();
        }
    }
    ajax.send(formData);
}



function modalContraseña(idEqu) {
    var contenedor = document.getElementById("modalBox");
    var recarga = '';
    for (let i = 0; i < respuesta.length; i++) {
        if (respuesta[i].id == idEqu) {
            recarga += `
            <div class="cerrar-modal" onclick="cerrarModal();">
                <i class="fa-solid fa-xmark"></i>
            </div>
            <div class="titulo-modal-div">
                <h1 class="titulo-modal">Equipo: <span>${respuesta[i].nombre_equ}</span></h1>
                <h3 class="subtitulo-modal">Introduce la contraseña del equipo: </h3>
            </div>

            <div class="contenido-modal modal-password">
                <form onsubmit="unirseEquipo(${idEqu});return false;" method="POST" class="form-contra">
                    <input id="contra_equ" class="contra-equ" name="contra_equ" type="text" placeholder="Contraseña...">
                    <button type="submit" class="enviar_contra" name="enviar">Unirse al equipo</button>
                </form>
                
            </div>
            `;
        }
    }
    contenedor.innerHTML = recarga;

}


function crearEquipo() {
    /* Si hace falta obtenemos el elemento HTML donde introduciremos la recarga (datos o mensajes) */
    /* Usar el objeto FormData para guardar los parámetros que se enviarán:
    formData.append('clave', valor);
    valor = elemento/s que se pasarán como parámetros: token, method, inputs... */
    var formData = new FormData(document.getElementById('formCreateTeam'));

    formData.append('_token', document.getElementById('token').getAttribute("content"));
    formData.append('_method', 'POST');
    /* Inicializar un objeto AJAX */
    var ajax = objetoAjax();


    ajax.open("POST", "crearEquipo", true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {

            var respuesta = JSON.parse(this.responseText);
            if (respuesta.resultado == "OK") {
                /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
                //message.innerHTML = '<p>Nota creada correctamente.</p>';
            } else {
                console.log(respuesta.resultado);
                /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                //    /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
                //message.innerHTML = 'Ha habido un error:' + respuesta.resultado;
            }
            modalEquipos();
        }
    }
    ajax.send(formData);
}

///////////////////////////////////////////////////////////////////////////////////////////////////////

function modalModPerfil() {
    /* Si hace falta obtenemos el elemento HTML donde introduciremos la recarga (datos o mensajes) */
    /* Usar el objeto FormData para guardar los parámetros que se enviarán:
    formData.append('clave', valor);
    valor = elemento/s que se pasarán como parámetros: token, method, inputs... */
    var contenedor = document.getElementById("modalBox");
    var formData = new FormData();
    formData.append('_token', document.getElementById('token').getAttribute("content"));

    /* Inicializar un objeto AJAX */
    var ajax = objetoAjax();
    ajax.open("POST", "mostrarPerfil", true);
    ajax.onreadystatechange = function() {

        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(this.responseText);

            var recarga = '';
            recarga += `
            <div class="cerrar-modal" onclick="cerrarModal();">
                <i class="fa-solid fa-xmark"></i>
            </div>
            <div class="titulo-modal-div">
                <h1 class="titulo-modal">Modificar perfil</h1>
            </div>
            <div class="contenido-modal">
                <form onsubmit="modificarPerfil();return false;" method="POST" id="form_mod_perfil" class="form-mod-perfil">
                    <input type="text" name="nick_usu" value="${respuesta.nick_usu}" placeholder="Nickname...">
                    <input type="text" name="correo_usu" value="${respuesta.correo_usu}" placeholder="Correo...">
                    <input type="password" name="contra_usu" placeholder="Contraseña...">
                    <button type="submit" class="btn-modificar-perfil">Modificar</button>
                </form>
            </div>
            `;
            contenedor.innerHTML = recarga;
            abrirModal();
        }
    }
    ajax.send(formData);

}

function modificarPerfil() {
    /* Si hace falta obtenemos el elemento HTML donde introduciremos la recarga (datos o mensajes) */
    /* Usar el objeto FormData para guardar los parámetros que se enviarán:
    formData.append('clave', valor);
    valor = elemento/s que se pasarán como parámetros: token, method, inputs... */
    var formData = new FormData(document.getElementById('form_mod_perfil'));
    formData.append('_token', document.getElementById('token').getAttribute("content"));
    formData.append('_method', 'PUT');
    /* Inicializar un objeto AJAX */
    var ajax = objetoAjax();


    ajax.open("POST", "modificarPerfil", true);

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
            cerrarModal();
        }
    }
    ajax.send(formData);
}

//////////////////////////////////////////////////////////
//DIRECCIONES
/////////////////////////////////////////////////////////
async function modalDirecciones() {
    var contenedor = document.getElementById("modalBox");
    var formData = new FormData();
    formData.append('_token', document.getElementById('token').getAttribute("content"));

    /* Inicializar un objeto AJAX */
    let etiquetas = await selectEtiquetas();
    var ajax = objetoAjax();
    ajax.open("POST", "mostrarDirecciones", true);
    ajax.onreadystatechange = function() {

        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(this.responseText);

            var recarga = '';
            recarga += `
            <h1 class="titulo-modal">Ubicaciones</h1>
            <div class="contenido-modal">
                <div class="modal-first">
                    <div class="contenido">`
            for (let i = 0; i < respuesta.length; i++) {
                recarga += `
                    <div class="item">
                        <div class="nombre-item">${respuesta[i].nombre_ubi}</div>
                        <div class="boton-item">
                            <form onsubmit="modificarDireccionesModal(${respuesta[i].id});return false;">
                                <div class="submit-eliminar-etiqueta">
                                    <button type="submit" class="icono-eliminar">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                </div>
                            </form>
                            <form onsubmit="eliminarDirecciones(${respuesta[i].id});return false;">
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
                    <form id="formCreateDir" method='POST' onsubmit="crearDirecciones(); return false;" enctype="multipart/form-data">
                        <h2>Crear Ubicaciones</h2>
                        <input type="text" placeholder="Nombre ubicacion..." class="nombre-etiqueta-crear" name="nombre_ubi">
                        <input type="text" placeholder="Direccion ubicación..." class="nombre-etiqueta-crear" name="direccion_ubi">
                        <textarea name="descripcion_ubi"></textarea>
                        <input type="text" placeholder="Latitud direccion..." class="nombre-etiqueta-crear" name="latitud_ubi">
                        <input type="text" placeholder="Longitud direccion..." class="nombre-etiqueta-crear" name="longitud_ubi">
                        <select name="id_eti">
                        `
            for (let z = 0; z < etiquetas.length; z++) {
                recarga += `<option value="${etiquetas[z].id}">${etiquetas[z].nombre_eti}</option>`
            }
            recarga += `
                        </select>
                        <input type="file" placeholder="Imagen direccion..." class="nombre-etiqueta-crear" name="foto_ubi">
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

function eliminarDirecciones(id) {
    /* Si hace falta obtenemos el elemento HTML donde introduciremos la recarga (datos o mensajes) */
    /* Usar el objeto FormData para guardar los parámetros que se enviarán:
    formData.append('clave', valor);
    valor = elemento/s que se pasarán como parámetros: token, method, inputs... */

    var formData = new FormData();
    formData.append('_token', document.getElementById('token').getAttribute("content"));
    formData.append('_method', 'DELETE');
    /* Inicializar un objeto AJAX */
    var ajax = objetoAjax();
    ajax.open("POST", "eliminarDireccion/" + id, true);
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
            modalDirecciones();
        }
    }
    ajax.send(formData);
}

function crearDirecciones() {
    /* Si hace falta obtenemos el elemento HTML donde introduciremos la recarga (datos o mensajes) */
    /* Usar el objeto FormData para guardar los parámetros que se enviarán:
    formData.append('clave', valor);
    valor = elemento/s que se pasarán como parámetros: token, method, inputs... */
    var formData = new FormData(document.getElementById('formCreateDir'));

    formData.append('_token', document.getElementById('token').getAttribute("content"));
    formData.append('_method', 'POST');
    /* Inicializar un objeto AJAX */
    var ajax = objetoAjax();


    ajax.open("POST", "crearDireccion", true);

    ajax.onreadystatechange = function() {
        console.log("dentro");
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
            modalDirecciones();
        }
    }
    ajax.send(formData);
}

async function modificarDireccionesModal(id) {
    let etiquetas = await selectEtiquetas();
    var contenedor = document.getElementById("modalBox");
    var formData = new FormData();
    formData.append('_token', document.getElementById('token').getAttribute("content"));
    formData.append('_method', 'GET');
    /* Inicializar un objeto AJAX */
    var ajax = objetoAjax();
    ajax.open("POST", "modificarDireccion/" + id, true);
    ajax.onreadystatechange = function() {

        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(this.responseText);
            console.log(respuesta);
            var recarga = '';
            recarga += `
            <h1 class="titulo-modal">Modificar ubicacion #${id}</h1>
            <div class="contenido-modal">
                <form onsubmit="modificarDireccionPost();return false;" method="POST" id="form_mod_direccion" class="form-mod-perfil" enctype="multipart/form-data">
                    <input type="text" name="nombre_ubi" value="${respuesta[0].nombre_ubi}">
                    <input type="text" name="direccion_ubi" value="${respuesta[0].direccion_ubi}">
                    <textarea name="descripcion_ubi">${respuesta[0].descripcion_ubi}</textarea>
                    <input type="text" name="latitud_ubi" value="${respuesta[0].latitud_ubi}">
                    <input type="text" name="longitud_ubi" value="${respuesta[0].longitud_ubi}">
                    <select name="id_eti">
                    `
            for (let z = 0; z < etiquetas.length; z++) {
                recarga += `<option value="${etiquetas[z].id}">${etiquetas[z].nombre_eti}</option>`
            }
            recarga += `
                    </select>
                    <input type="file" placeholder="Imagen direccion..." class="nombre-etiqueta-crear" name="foto_ubi">
                    <input type="hidden" name="id_ubicacion" value="${respuesta[0].id}">
                    <input type="submit" name="enviar" value="Modificar" class="btn-modificar-perfil">
                </form>
            </div>
            `;
            contenedor.innerHTML = recarga;
            abrirModal();
        }
    }
    ajax.send(formData);
}

function modificarDireccionPost() {
    /* Si hace falta obtenemos el elemento HTML donde introduciremos la recarga (datos o mensajes) */
    /* Usar el objeto FormData para guardar los parámetros que se enviarán:
    formData.append('clave', valor);
    valor = elemento/s que se pasarán como parámetros: token, method, inputs... */
    var formData = new FormData(document.getElementById('form_mod_direccion'));

    formData.append('_token', document.getElementById('token').getAttribute("content"));
    formData.append('_method', 'PUT');
    /* Inicializar un objeto AJAX */
    var ajax = objetoAjax();


    ajax.open("POST", "modificarDireccion", true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {

            var respuesta = JSON.parse(this.responseText);
            if (respuesta.resultado == "OK") {
                console.log("OK");
                /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
                //message.innerHTML = '<p>Nota creada correctamente.</p>';
            } else {
                console.log(respuesta.resultado)
                    /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                    //    /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
                    //message.innerHTML = 'Ha habido un error:' + respuesta.resultado;
            }
            modalDirecciones();
        }
    }
    ajax.send(formData);
}

function selectEtiquetas() {
    return new Promise(function(resolve, reject) {
        let token = document.getElementById('token').getAttribute("content");
        let formData = new FormData();
        formData.append('_token', token);
        formData.append('_method', 'POST');
        let ajax = objetoAjax();
        ajax.open("POST", "etiquetas/sistema", true);
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

function darseBaja() {
    /* Si hace falta obtenemos el elemento HTML donde introduciremos la recarga (datos o mensajes) */
    /* Usar el objeto FormData para guardar los parámetros que se enviarán:
    formData.append('clave', valor);
    valor = elemento/s que se pasarán como parámetros: token, method, inputs... */
    var formData = new FormData();

    formData.append('_token', document.getElementById('token').getAttribute("content"));
    formData.append('_method', 'DELETE');
    /* Inicializar un objeto AJAX */
    var ajax = objetoAjax();


    ajax.open("POST", "darseDeBaja", true);

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {

            var respuesta = JSON.parse(this.responseText);
            if (respuesta.resultado == "OK") {
                console.log("OK");
                /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
                //message.innerHTML = '<p>Nota creada correctamente.</p>';
                window.location.replace('../public');
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