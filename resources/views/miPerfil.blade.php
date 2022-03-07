<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{!! asset('css/style.css') !!}">
    <link rel="stylesheet" href="{!! asset('css/mainstyle.css') !!}">
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
                    <li><form action="{{url('')}}" method="GET">
                        <button>Iniciar Gimcana</button>
                    </form></li>
                    @if (Session::get('nombre'))
                        <li><form action="{{url('logout')}}" method="GET">
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
                    <button>Etiquetas</button>
                    <button>Modificar Perfil</button>
                    <button>Equipo</button>
                </div>
            </div>
        </div>
    </div>
    <script src="js/burger.js"></script>
</body>
</html>