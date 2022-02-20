/**
 * Limpia los errores de la app mediante la propiedad errors
 *
 * @author Luisbardev <luisbardev@gmail.com> luisbardev.com
 */


import { usePage } from "@inertiajs/inertia-vue3";

const clearAppErrors = (time = 5000) => {
    setTimeout(() => {
        usePage().props.value.errors = {};
    }, time);
};

export default clearAppErrors;