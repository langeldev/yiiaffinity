/**
 * Recibe digitos y los formatea adecuadamente
 * @param {string} x
 * @returns string x,x
 */
function formateo(x)
{
    return Number.parseFloat(x).toFixed(1).replace('.',',');
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
