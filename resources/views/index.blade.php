<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/icon/raxmaps.png" type="image/x-icon">
    {{-- <script type="text/javascript" src="js/jquery.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{!! asset('css/mainstyle.css') !!}">
    <script type="text/javascript" src="js/js.js"></script>
    <link href="fa/css/all.css" rel="stylesheet">
    <title>Raxmaps</title>
</head>
<body class="page-mapa">
    <div class="region-content">
        <div class="region-sidebar" id="sidebar">
            <nav>
                <div class="btn-burger">
                    <button id="btn-burger"> ??? </button>
                </div>
                <ul id="form-sidebar" class="form-sidebar hidden">
                    @if (Session::get('nombre'))
                        <li>
                            <button onclick="modalGincana(); return false;">Iniciar Gincana</button>
                        </li>
                        <li><form action="{{url('perfil')}}" method="POST">
                            @csrf
                            {{method_field('GET')}}
                            <button>Mi Perfil</button>
                        </form></li>
                        <li class="sidebar-logout"><form action="{{url('logout')}}" method="GET">
                            <button type="submit">Cerrar Sesi??n</button>
                        </form></li>
                    @else
                        <li><form action="{{url('login')}}" method="POST">
                            @csrf
                            {{method_field('GET')}}
                            <button>Iniciar Sesi??n</button>
                        </form></li>
                        <li><form action="{{url('')}}" method="GET">
                            <button>Iniciar Gimcana</button>
                        </form></li>
                    @endif
                </ul>
            </nav>
        </div>
        <div class="with-region-map">
            <!-- RADIO BUTTON DE LOS BOTONES TANTO DEL SISTEMA COMO DEL USUARIO SI HAY SESION INICIADA -->
            <div class="filtros-mapa">
                <form action="">
                    <div class="wrapper">
                        <div class="carousel owl-carousel">
                            <div class="card card-1">
                                <input type="radio" name="etiqueta" onclick="filtroEtiqueta(0)" value="Todo" class="etiqueta">
                                <label for="etiqueta">
                                    <img class="" src="img/icon/ico_todo.png" width="20">Todo
                                </label>    
                            </div>
                            <?php $contador=2 ?>
                            @foreach ($listaEtiquetas as $etiqueta)

                                <div class="card card-{{$contador}}">
                                    <input type="radio" name="etiqueta" onclick="filtroEtiqueta({{$etiqueta->id}})" class="etiqueta">
                                    <label for="etiqueta">
                                        @if($etiqueta->icono_eti == 'sys_ocio')
                                            <img class="" src="img/icon/ico_ocio.png" width="20">
                                        @elseif($etiqueta->icono_eti == 'sys_bar')
                                            <img class="" src="img/icon/ico_bar.png" width="20">
                                        @elseif($etiqueta->icono_eti == 'sys_hospital')
                                            <img class="" src="img/icon/ico_hospital.png" width="20">
                                        @elseif($etiqueta->icono_eti == 'sys_hotel')
                                            <img class="" src="img/icon/ico_hotel.png" width="20">
                                        @elseif($etiqueta->icono_eti == 'sys_museo')
                                            <img class="" src="img/icon/ico_museo.png" width="20">
                                        @elseif($etiqueta->icono_eti == 'sys_parque')
                                            <img class="" src="img/icon/ico_parque.png" width="20">
                                        @elseif($etiqueta->icono_eti == 'sys_playa')
                                            <img class="" src="img/icon/ico_playa.png" width="20">
                                        @elseif($etiqueta->icono_eti == 'sys_restaurante')
                                            <img class="" src="img/icon/ico_restaurante.png" width="20">
                                        @elseif($etiqueta->icono_eti == 'sys_supermercado')
                                            <img class="" src="img/icon/ico_supermercado.png" width="20">
                                        @elseif($etiqueta->icono_eti == 'sys_fav')
                                            <img class="" src="img/icon/ico_fav.png" width="20">
                                        @elseif($etiqueta->icono_eti == 'sys_user')
                                            <img class="" src="img/icon/ico_user.png" width="20">
                                        @endif
                                        {{$etiqueta->nombre_eti}}
                                    </label>
                                </div>
                                <?php $contador=$contador+1 ?>
                            @endforeach
                        </div>
                    </div>
                </form>
            </div>

            <!-- BOTON PARA CANCELAR LA RUTA -->
            <button id="btnQuitRoute">Quitar ruta</button>
            <div class="region-map" id="map">

            </div>
        </div>
        
        <div class="modal hidden" id="modal">
            <div class="modalBox" id="modalBox">

            </div>
        </div>

        <div id="messageGame" class="messageGame in hidden"></div>
    </div>

    <script src="js/burger.js"></script>
    <script src="js/mapas.js"></script>
    <script src="js/owl-carousel.js"></script>
</body>
</html>