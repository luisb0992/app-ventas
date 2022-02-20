/**
 * Estado y manipulación del componente toast
 *
 * @author Luisbardev <luisbardev@gmail.com> luisbardev.com
 */

import { reactive } from "vue";

// configuración entre componentes para toast
const toast = reactive({
    show: false,
    message: "",
    bg: "",
});

export default toast;