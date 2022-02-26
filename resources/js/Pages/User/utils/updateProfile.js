/**
 * Gestión y configuración de actualización de perfil de un usuario
 *
 * @author Luisbardev <luisbardev@gmail.com> luisbardev.com
 */

// utils
import clearAppErrors from "@/utils/clearAppErrors";
import hasErrors from "@/utils/hasAppErrors.js";
import toast from "@/utils/toastMessage.js";
import { ref } from "vue";

export const loading = ref(false);
export const errorUpdateProfile = ref(false);
export const loadingPass = ref(false);
export const errorUpdatePass = ref(false);
export const toastMessage = toast;

/**
 * actualizar el usuario
 *
 * @param {String} type       tipo de actualización
 * @param {FormData} form     formulario de actualización
 */
export const updateUser = (type, form) => {
    if (type === "profile") {
        updateProfile(form);
    } else if (type === "pass") {
        updatePass(form);
    }
};

/**
 * Actualiza los datos del perfíl del usuario menos la contraseña
 *
 * @param {FormData} form       formulario de actualización
 */
const updateProfile = (form) => {
    loading.value = true;
    errorUpdateProfile.value = true;
    errorUpdatePass.value = false;

    const path = route("profile.updateData", form.id);
    form.put(path, {
        onFinish: () => {
            if (!hasErrors.value) {
                toast.message = "Perfil actualizado correctamente";
                toast.bg = "bg-green-600";
                toast.show = true;
                setTimeout(() => {
                    toast.show = false;
                }, 5000);
            }

            loading.value = false;
            clearAppErrors();
        },
        onError: () => {
            loading.value = false;
            clearAppErrors();
        },
        onProgress: () => {
            loading.value = true;
        },
    });
};

/**
 * Actualiza solo la contraseña del usuario
 *
 * @param {FormData} form    formulario de actualización
 */
const updatePass = (form) => {
    loadingPass.value = true;
    errorUpdatePass.value = true;
    errorUpdateProfile.value = false;

    const path = route("profile.updatePass", form.id);
    form.put(path, {
        onFinish: () => {
            if (!hasErrors.value) {
                toast.message = "Clave actualizada correctamente";
                toast.bg = "bg-green-600";
                toast.show = true;
                setTimeout(() => {
                    toast.show = false;
                }, 5000);
            }

            loadingPass.value = false;
            clearAppErrors();
        },
        onError: () => {
            loadingPass.value = false;
            clearAppErrors();
        },
        onProgress: () => {
            loadingPass.value = true;
        },
    });
};
