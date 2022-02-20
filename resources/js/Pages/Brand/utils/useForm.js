/**
 * Helper useForm para el formulario de marcas
 *
 * @author Luisbardev <luisbardev@gmail.com> luisbardev.com
 */

import { useForm } from "@inertiajs/inertia-vue3";

/**
 * Devuelve el objeto de formulario junto a las propiedades a crear
 */
export const form = useForm({
    id: "",
    name: "",
    logo: "",
    email_one: "",
    email_two: "",
    preview: "",
    update: false,
});

/**
 * Limpia las propiedades del objeto de formulario
 */
export const clearForm = () => {
    form.id = "";
    form.name = "";
    form.logo = "";
    form.email_one = "";
    form.email_two = "";
    form.preview = "";
    form.update = false;
};
