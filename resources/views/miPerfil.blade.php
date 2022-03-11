<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/icon/raxmaps.png" type="image/x-icon">
    <link rel="stylesheet" href="{!! asset('css/mainstyle.css') !!}">
    <link href="fa/css/all.css" rel="stylesheet">
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
                        {{$perfil[0]->nick_usu}}
                    </h1>
                    @if ($perfil[0]->id_equipo != null)
                    <h2 class="equipo-usuario">
                        {{$perfil[0]->nombre_equ}}
                    </h2>
                    @endif
                </div>
                <div class="perfil-opciones">
                    {{-- modalEtiquetas({{session()->get('id_usuario');}}); --}}
                    <button onclick="modalEtiquetas();">Mis etiquetas</button>
                    <button onclick="modalModPerfil();">Modificar Perfil</button>
                    <button onclick="modalEquipos();">Equipo</button>
                    @if (Session::get('rol') == "administrador")
                        <button onclick="modalDirecciones();">Ubicaciones</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal hidden" id="modal">
        <div class="modalBox" id="modalBox">
            
        </div>
    </div>
    <script src="js/burger.js"></script>
    <script src="js/perfil.js"></script>
</body>
</html>