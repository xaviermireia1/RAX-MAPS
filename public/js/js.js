// $(document).ready(function() {
//     $(".btn-cerrarPop").click(function() {
//         $(".overlay-p").removeClass('active');
//         $("#popup").removeClass('active');
//         $(".contenedor-popup .ejercicio-body").html('')
//     });
//     $(".btn-abrirPop").click(function() {
//         $(".overlay-p").addClass('active');
//         $("#popup").addClass('active');
//     });
// });

$(document).ready(function() {
    //inicializar el owl carousel (libreria para hacer carousel con jquery)



    $(".owl-carousel").owlCarousel();

    //pulsar la burger
    $(".menu .boton-burger svg").click(function() {
        $(".overlay").addClass("active")
        $(".sidenav").addClass("open")
        $("body").css("overflow", "hidden");

    });
    $(".overlay").click(function() {
        console.log("hola")
        if ($(".sidenav").hasClass("open")) {
            $(".sidenav").removeClass("open")
            $(".menu .boton-burger").removeClass("opened")



        }
        $(".overlay").removeClass("active")
        $("body").css("overflow", "visible");
    });

    $(".input-search-top").on("keyup", function() {
        $("form .hidden-texto").val($(this).val())
        $(".input-search-header").val($(this).val())
    });
    $(".input-search-header").on("keyup", function() {
        $("form .hidden-texto").val($(this).val())
        $(".input-search-top").val($(this).val())
    });






    /*     var map = L.map('map').setView([41.405143642716084, 2.149759037596462], 13);

        L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth_dark/{z}/{x}/{y}{r}.png', {
            attribution: 'El isi',
            maxZoom: 18,
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: 'your.mapbox.access.token'
        }).addTo(map); */

});

// $(".region-tipo .ubicacion").ready(function() {
//     var ubi = $(".ubi-flea").text();
//     var ubi = ubi.split(",");
//     var map = L.map('map').setView([ubi[0], ubi[1]], 16);
//     L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth_dark/{z}/{x}/{y}{r}.png', {
//         attribution: 'El isi',
//         maxZoom: 18,
//         id: 'mapbox/streets-v11',
//         tileSize: 512,
//         zoomOffset: -1,
//         accessToken: 'your.mapbox.access.token'
//     }).addTo(map);
//     var marker = L.marker([ubi[0], ubi[1]]).addTo(map);
// });