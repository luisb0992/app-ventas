/**
 * Obtener el path donde se aloja la imagen del logo de la empresa
 *
 * @author Luisbardev <luisbardev@gmail.com> luisbardev.com
 */

import { usePage } from "@inertiajs/inertia-vue3";
import { computed } from "vue";

const pathLogos = computed(() => usePage().props.value.path.brandLogo);

export default pathLogos;
