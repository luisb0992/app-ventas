/**
 * Funcionalidades extras, filtros y demás para ser usadas en toda la app
 *
 * @author Luisbardev <luisbardev@gmail.com> luisbardev.com
 */

/**
 * Recortar un string
 *
 * @param {string} value
 * @param {number} longitud
 */
export const substr = (value, longitud = 10) => {
    return value.substr(0, longitud) + "...";
};

/**
 * Calcular el tamaño de un archivo en mb
 *
 * @param {number} value
 */
export const calculateSizeInMB = (value) => {
    return (value / 1024 / 1024).toFixed(2);
};

/**
 * Devuelve un string sin la palabra "image/"
 *
 * @param {string} value
 */
export const replaceWordImage = (value) => {
    return value.replace("image/", "");
};
