<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/icon/raxmaps.png" type="image/x-icon">
    <link rel="stylesheet" href="{!! asset('css/mainstyle.css') !!}">
    <script src="{!! asset('fa/js/all.js') !!}"></script>
    <link rel="stylesheet" href="{!! asset('fa/css/all.min.css') !!}">
    <meta name="csrf-token" id="token" content="{{ csrf_token() }}">
    <title>Mi Perfil</title>
</head>
<body class="page-perfil">
    <div class="region-content">
        <div class="region-sidebar" id="sidebar">
            <nav>
                <div class="btn-burger">
                    <button id="btn-burger"> ☰ </button>
                </div>
                <ul id="form-sidebar" class="form-sidebar hidden">
                    <li><form action="{{url('')}}" method="POST">
                        @csrf
                        {{method_field('GET')}}
                        <button>Volver Al Mapa</button>
                    </form></li>
                    @if (Session::get('nombre'))
                        <li><form action="{{url('perfil')}}" method="GET">
                            <button>Mi Perfil</button>
                        </form></li>
                        <li class="sidebar-logout"><form action="{{url('logout')}}" method="GET">
                            <button type="submit">Cerrar Sesión</button>
                        </form></li>
                    @endif
                </ul>
            </nav>
        </div>
        <div class="region-content-perfil">
            <div class="perfil">
                <div class="perfil-foto">
                    <img src="img/icon/profile.png" alt="Foto Usuario" class="foto-perfil">
                </div>
                <div class="perfil-datos">
                    <h1 class="nombre-usuario">
                        Lorem Ipsum Dolor
                    </h1>
                    <h2 class="equipo-usuario">
                        Equipo A
                    </h2>
                </div>
                <div class="perfil-opciones">
                    {{-- modalEtiquetas({{session()->get('id_usuario');}}); --}}
                    <button onclick="abrirModal();">Mis etiquetas</button>
                    <button onclick="abrirModal();">Modificar Perfil</button>
                    <button onclick="abrirModal();">Equipo</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal hidden" id="modal">
        <div class="modalBox" id="modalBox">
            <h1 class="titulo-modal">Mis etiquetas</h1>
            <div class="contenido-modal">
                <div class="lista-etiquetas">
                    <div class="etiqueta">
                        <div class="nombre-etiqueta">ETIQUETA</div>
                        <div class="eliminar-etiqueta">
                            <form onsubmit="eliminarEtiqueta()return false;">
                                <div class="submit-eliminar-etiqueta">
                                    <input type="submit">
                                    <i class="fa-solid fa-xmark"></i>
                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="etiqueta">
                        <div class="nombre-etiqueta">ETIQUETA</div>
                        <div class="eliminar-etiqueta">
                            <form onsubmit="eliminarEtiqueta()return false;">
                                <div class="submit-eliminar-etiqueta">
                                    <input type="submit">
                                    <i class="fa-solid fa-xmark"></i>
                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="etiqueta">
                        <div class="nombre-etiqueta">ETIQUETA</div>
                        <div class="eliminar-etiqueta">
                            <form onsubmit="eliminarEtiqueta()return false;">
                                <div class="submit-eliminar-etiqueta">
                                    {{-- <input type="submit"> --}}
                                    <i class="fa-solid fa-xmark"></i>
                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="etiqueta">
                        <div class="nombre-etiqueta">ETIQUETA</div>
                        <div class="eliminar-etiqueta">
                            <form onsubmit="eliminarEtiqueta()return false;">
                                <div class="submit-eliminar-etiqueta">
                                    <input type="submit">
                                    <i class="fa-solid fa-xmark"></i>
                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="etiqueta">
                        <div class="nombre-etiqueta">ETIQUETA</div>
                        <div class="eliminar-etiqueta">
                            <form onsubmit="eliminarEtiqueta()return false;">
                                <input type="submit" value="X">
                            </form>
                        </div>
                    </div>
                    <div class="etiqueta">
                        <div class="nombre-etiqueta">ETIQUETA</div>
                        <div class="eliminar-etiqueta">
                            <form onsubmit="eliminarEtiqueta()return false;">
                                <input type="submit" value="X">
                            </form>
                        </div>
                    </div>
                    <div class="etiqueta">
                        <div class="nombre-etiqueta">ETIQUETA</div>
                        <div class="eliminar-etiqueta">
                            <form onsubmit="eliminarEtiqueta()return false;">
                                <input type="submit" value="X">
                            </form>
                        </div>
                    </div>
                    <div class="etiqueta">
                        <div class="nombre-etiqueta">ETIQUETA</div>
                        <div class="eliminar-etiqueta">
                            <form onsubmit="eliminarEtiqueta()return false;">
                                <input type="submit" value="X">
                            </form>
                        </div>
                    </div>
                    <div class="etiqueta">
                        <div class="nombre-etiqueta">ETIQUETA</div>
                        <div class="eliminar-etiqueta">
                            <form onsubmit="eliminarEtiqueta()return false;">
                                <input type="submit" value="X">
                            </form>
                        </div>
                    </div>
                    <div class="etiqueta">
                        <div class="nombre-etiqueta">ETIQUETA</div>
                        <div class="eliminar-etiqueta">
                            <form onsubmit="eliminarEtiqueta()return false;">
                                <input type="submit" value="X">
                            </form>
                        </div>
                    </div>
                    <div class="etiqueta">
                        <div class="nombre-etiqueta">ETIQUETA</div>
                        <div class="eliminar-etiqueta">
                            <form onsubmit="eliminarEtiqueta()return false;">
                                <input type="submit" value="X">
                            </form>
                        </div>
                    </div>
                    <div class="etiqueta">
                        <div class="nombre-etiqueta">ETIQUETA</div>
                        <div class="eliminar-etiqueta">
                            <form onsubmit="eliminarEtiqueta()return false;">
                                <div class="submit-eliminar-etiqueta">
                                    <input type="submit">
                                    <i class="fa-solid fa-xmark"></i>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <div class="crear-etiqueta">
                    <form onsubmit="crearEtiqueta();return false;">
                        <h2>Crear etiqueta</h2>
                        <input type="text" placeholder="Nueva etiqueta..." class="nombre-etiqueta-crear">
                        <input type="submit" name="enviar" value="Crear etiqueta" class="btn-etiqueta">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="js/burger.js"></script>
    <script src="js/perfil.js"></script>
</body>
</html>