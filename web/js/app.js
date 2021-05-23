
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

});

/**
 * Hace la petcion para cambiar la posicion y cambia
 * la posicion entre los dos objetos
 * @param {object} posicion1
 * @param {object} posicion2
 * @param {string} url
 */
function cambairPoscion(posicion1, posicion2, url)
{
    let subirKey = posicion1.attr('id');
    let bajarKey = posicion2.attr('id');

    $.ajax({
        type: 'POST',
        url: url,
        data: {
            sube_id: subirKey,
            baja_id: bajarKey,
        }
    }).done(function (data) {
        posicion2.insertAfter(posicion1);
        inhabilitar();
    });
}

/**
 * inhabilita los botones al llegar a su limite
 */
function inhabilitar()
{
    $('.subir').attr('disabled', false);
    $('.bajar').attr('disabled', false);
    $('.subir').first().attr('disabled', true);
    $('.bajar').last().attr('disabled', true);
}

function controlSeguir(usuario, seguidor, url)
{
    $.ajax({
        type: 'POST',
        url: url,
        data: {
            usuario_id: usuario,
            seguidor_id: seguidor
        }
    }).done(function (data) {
        $('.perfil-usuario').html(data);
    })
}

/**
 * redirigir el navegador a una nueva página
 */
function ventana()
{
    window.location = "https://www.google.es";
}
