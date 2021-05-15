
/**
 * Recibe digitos y los formatea adecuadamente
 * @param {string} x
 * @returns string x,x
 */
function formateo(x)
{
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
 * Muestra es el modal de las cookies
 */
function comprobarCookie()
{
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
function aceptarCookie()
{
    localStorage.setItem('cookie', true);
}

/**
 * Almacena furante la sesión
 */
function rechazarCookie()
{
    sessionStorage.setItem('cookie-rechazada', true);
}
