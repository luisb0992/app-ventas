/**
 * Obtener el path donde se aloja la imagen del logo de la empresa
 *
 * @author Luisbardev <luisbardev@gmail.com> luisbardev.com
 */

import { ref } from "vue";

const pathLogos = ref("");

axios
    .get(route("path.logos"))
    .then((response) => (pathLogos.value = response.data));

export default pathLogos;
