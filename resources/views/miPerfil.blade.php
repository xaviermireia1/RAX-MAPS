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
<body>
    <div class="region-content">
        <div class="region-sidebar" id="sidebar">
            <nav>
                <div class="btn-burger">
                    <button id="btn-burger"> ☰ </button>
                </div>
                <ul id="form-sidebar" class="form-sidebar hidden">
                    <li><form action="{{url('login')}}" method="GET">
                        <button>Iniciar Session</button>
                    </form></li>
                    <li><form action="{{url('')}}" method="GET">
                        <button>Iniciar Gimcana</button>
                    </form></li>
                    @if (Session::get('nombre'))
                        <li><form action="{{url('perfil')}}" method="GET">
                            <button>Mi Perfil</button>
                        </form></li>
                        <li><form action="{{url('logout')}}" method="GET">
                            <button type="submit">Cerrar Sesión</button>
                        </form></li>
                    @endif
                </ul>
            </nav>
        </div>
        <div class="">

        </div>
    </div>
    <script src="js/burger.js"></script>
</body>
</html>