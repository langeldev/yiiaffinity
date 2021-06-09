
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


/**
 * Controla el seguimiento de los usuarios
 *
 * @param {numbre} usuario
 * @param {number} seguidor
 * @param {string} url
 */
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
        if (data.estado == 'siguiendo') {
            var conf = {
                idActual: '#seguir',
                text: 'Eliminar de amigos',
                nuevoId: 'no-seguir',
                accion: dejarSeguir
            }
        } else {
            var conf = {
                idActual: '#no-seguir',
                text: 'Añadir a amigos',
                nuevoId: 'seguir',
                accion: seguir
            }
        }
        cambiarEstado(conf);
    })
}

/**
 * Actualiza un boton
 * @param {object} conf
 */
function cambiarEstado(conf)
{
    var boton = $(conf.idActual);
    boton.off();
    boton.text(conf.text);
    boton.attr('id', conf.nuevoId);
    boton.click(conf.accion);
    boton.blur();
}

/**
 * redirigir el navegador a una nueva página
 */
function ventana()
{
    window.location = "https://www.google.es";
}


/**
 * Intercambia el boton para agregar o quitar de las listas de los usuarios
 *
 * @param {object} boton
 * @param {object} conf
 */
function cambiarBoton(boton, conf)
{
    boton.attr('disabled', true);
    boton.fadeOut('fast', function () {
        boton.html(conf.simbolo);
        boton.removeClass();
        boton.addClass('btn btn-' + conf.color + ' quitar');
        boton.attr('title', conf.titulo);
        boton.fadeIn('fast', function () {
            boton.off();
            boton.click(conf.accion);
            boton.attr('disabled', false);
            boton.blur();
        })

    });
}
