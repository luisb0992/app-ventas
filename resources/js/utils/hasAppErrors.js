/**
 * Determina si hay mensajes de errores activos en la app
 *
 * @author Luisbardev <luisbardev@gmail.com> luisbardev.com
 */

import { computed } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";

const hasErrors = computed(
    () => Object.keys(usePage().props.value.errors).length > 0
);

export default hasErrors;
