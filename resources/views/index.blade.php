<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" id="token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    <!-- Esri Leaflet Geocoder -->
    <!-- Load Esri Leaflet from CDN -->
    <script src="https://unpkg.com/esri-leaflet"></script>

    <!-- Esri Leaflet Geocoder -->
    <link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder/dist/esri-leaflet-geocoder.css" />
    <script src="https://unpkg.com/esri-leaflet-geocoder"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/leaflet.esri.geocoder/2.1.0/esri-leaflet-geocoder.css">
    <script src="https://cdn.jsdelivr.net/leaflet.esri.geocoder/2.1.0/esri-leaflet-geocoder.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
    <script src="js/mapas.js"></script>
    <link rel="stylesheet" href="{!! asset('css/style.css') !!}">
    <link rel="stylesheet" href="{!! asset('css/mainstyle.css') !!}">
    <title>Agenda Churrerías</title>
</head>
<body>
    <div class="region-content">
        <div class="region-sidebar" id="sidebar">
            <nav>
                <div class="btn-burger">
                    <button id="btn-burger"> ☰ </button>
                </div>
                <ul id="form-sidebar" class="form-sidebar hidden">
                    @if (Session::get('nombre'))
                        <li><form action="{{url('')}}" method="GET">
                            <button>Iniciar Gimcana</button>
                        </form></li>
                        <li><form action="{{url('perfil')}}" method="POST">
                            @csrf
                            {{method_field('GET')}}
                            <button>Mi Perfil</button>
                        </form></li>
                        <li class="sidebar-logout"><form action="{{url('logout')}}" method="GET">
                            <button type="submit">Cerrar Sesión</button>
                        </form></li>
                    @else
                        <li><form action="{{url('login')}}" method="POST">
                            @csrf
                            {{method_field('GET')}}
                            <button>Iniciar Sesión</button>
                        </form></li>
                        <li><form action="{{url('')}}" method="GET">
                            <button>Iniciar Gimcana</button>
                        </form></li>
                    @endif
                </ul>
            </nav>
        </div>
        <!-- RADIO BUTTON DE LOS BOTONES TANTO DEL SISTEMA COMO DEL USUARIO SI HAY SESION INICIADA -->        
        @foreach ($listaEtiquetas as $etiqueta)
            <input type="radio" name="etiqueta" value="{{$etiqueta->id}}">{{$etiqueta->nombre_eti}}
        @endforeach
        <!-- BOTON PARA CANCELAR LA RUTA -->
        <div class="region-map" id="map">

        </div>
    </div>

    <script src="js/burger.js"></script>
</body>
</html>