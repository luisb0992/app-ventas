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
    const characters = value.length > longitud ? '...' : '';
    return value.substr(0, longitud) + characters;
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

/**
 * Devuelve un string en formato de fecha dd/mm/yyyy
 *
 * @param {string} value    string a convertir
 * @returns                 string convertido a Date
 */
export const formatDateToDDMMYYYY = (value) => {
    const date = new Date(value);
    return `${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear()}`;
}
