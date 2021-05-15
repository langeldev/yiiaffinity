var urlImagenes = "https://yiiaffinity.s3.eu-west-3.amazonaws.com/";
var imgDefault = 'default.jpg';

/**
 * Recibe digitos y los formatea adecuadamente
 * @param {string} x
 * @returns string x,x
 */
function formateo(x) {
    return Number.parseFloat(x).toFixed(1).replace('.', ',');
}

$(document).ready(function () {

    $('#al-cielo').click(() => {
        $('body, html').animate({
            scrollTop: '0px'
        }, 600);
    });

    $(window).scroll(() => {
        if ($(this).scrollTop() > 200) {
            $('#al-cielo').slideDown('slow');
        } else {
            $('#al-cielo').slideUp('slow');
        }
    });

    //botones de aceptar o rechazar cookie
    $('#aceptar-cookie').on('click', aceptarCookie);
    $('#rechazar-cookie').on('click', rechazarCookie);

});

/**
 * Construlle la seccion de recomendaciones 
 */

function pedirRecomendacion(userId, url) {
    $.ajax({
        type: 'GET',
        url: url,
        data: {
            genero_id: getCookie('genero' + userId),
            producto_id: getCookie('producto' + userId)
        }
    }).done((data) => {
        construirRecomendacion(data, userId);
    })
}

/**
 * Construye una barra de recomendaciones con imagenes para el usuario logueado
 * @param {object} data 
 * @param {number} userId 
 */
function construirRecomendacion(data, userId){
    $('.fondo').append($(`<section id="recomendar" class="p-4 mb-4">
        <h4>Porque te gustó <b>${getCookie('titulo' + userId)}<b></h4>
        </section>`).hide());

    data.recomendacion.forEach(producto => {
        let div = $('<div>').addClass('text-center');
        let a = $('<a>').attr('href', '/index.php?r=productos/ficha&id=' + producto.id)
                        .append($(`<img class="img-fluid" src=${urlImagenes + (producto.imagen || imgDefault)} alt ="${producto.titulo}">`));
            div.append(a);
            $('#recomendar').append(div);
    });
    $('#recomendar').slideDown('slow');

}

/**
 * Muestra es el modal de las cookies
 */
function comprobarCookie() {
    if (!localStorage.getItem('cookie')) {
        if (!sessionStorage.getItem('cookie-rechazada')) {
            $('#modal').modal({
                backdrop: 'static'
            });
            $('#modal').modal('show');
        }
    }
}

/**
 * Almacena que se aceptan las cookies
 */
function aceptarCookie() {
    localStorage.setItem('cookie', true);
}

/**
 * Almacena furante la sesión
 */
function rechazarCookie() {
    sessionStorage.setItem('cookie-rechazada', true);
}

/**
 * Guarda en las cookies durante 2 días untitulo y el id de su genero principal
 * @param {object} recomendacion 
 * @param {numero} usuario
 */
function almacenarProducto(recomendacion, userId) {
    if (getCookie('genero' + userId) == "" && recomendacion.genero !== -1) {
        for (const key in recomendacion) {
           let nombre = key + userId;
           setCookie(nombre, recomendacion[key], 2);
        }
    }
}

/**
 * Almacena las cookies  en el navegador
 * @param {any} cname 
 * @param {any} cvalue 
 * @param {any} exdays 
 */
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

/**
 * Devuelve la cookie
 * @param {any} cname 
 * @returns string
 */
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
