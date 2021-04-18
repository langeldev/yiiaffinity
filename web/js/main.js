
/**
 * Recibe digitos y los formatea adecuadamente 
 * @param {string} x 
 * @returns string x,x
 */
function formateo(x) {
    return Number.parseFloat(x).toFixed(1).replace('.',',');
}
