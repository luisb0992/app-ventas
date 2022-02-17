/**
 * Obetenr eel nombre de la aplicación
 *
 * @author Luisbardev <luisbardev@gmail.com> luisbardev.com
 */

import { ref } from "vue";
const title = document.getElementsByTagName("title")[0].innerHTML;

const appName = ref(title);

export default appName;