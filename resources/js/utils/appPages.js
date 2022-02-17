/**
 * Manipulación de las urls de cada pagina principal
 *
 * @author Luisbardev <luisbardev@gmail.com> luisbardev.com
 */
import { ref } from "vue";

const appPages = ref({
    dashboard: "/dashboard",
    users: "/users",
    roles: "/roles",
    permissions: "/permissions",
    brands: "/brands",
    profile: "/profile",
    graphics: "/graphics",
    sales: "/sales",
});

export default appPages;