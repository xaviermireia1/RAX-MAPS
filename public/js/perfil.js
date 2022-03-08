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
                <div class="lista-etiquetas">`
            for (let i = 0; i < respuesta.length; i++) {
                recarga += `
                    <div class="etiqueta">
                        <div class="nombre-etiqueta">${respuesta[i].nombre_eti}</div>
                        <div class="eliminar-etiqueta">
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
            recarga += `
                </div>
                <div class="crear-etiqueta">
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
    alert("sgsdg")

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
                alert("HA FUNCIONADO")

            } else {
                /* creación de estructura: la estructura que creamos no ha de contener código php ni código blade*/
                //    /* utilizamos innerHTML para introduciremos la recarga en el elemento html pertinente */
                //message.innerHTML = 'Ha habido un error:' + respuesta.resultado;
                alert("NO HA FUNCIONADO")
            }
            modalEtiquetas();
        }
    }
    ajax.send(formData);
}


////////////////////////////////////////////////////////////////////////////////