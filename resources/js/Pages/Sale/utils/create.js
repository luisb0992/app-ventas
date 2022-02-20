/**
 * Configuración y creación de ventas mediante una marca
 *
 * @author Luisbardev <luisbardev@gmail.com> luisbardev.com
 */

// utils
import { useForm, usePage } from "@inertiajs/inertia-vue3";
import allFormats from "@/Pages/Sale/utils/validFormat.js";
import clearAppErrors from "@/utils/clearAppErrors";
import hasErrors from "@/utils/hasAppErrors.js";
import toast from "@/utils/toastMessage.js";
import { reactive } from "vue";

// exportar la configuración del mensaje toast
export const toastMessage = toast;

// mostrar o no el loading
export const loading = reactive({
    show: false
});

// formulario de datos
export const form = useForm({
    service: "",
    count: "",
    amount: "",
    client: "",
    voucher: "",
});

// limpiar el formulario
const clearForm = () => {
    form.service = "";
    form.count = "";
    form.amount = "";
    form.client = "";
    form.voucher = "";
};

/**
 * Crea una nueva venta
 */
export const createSale = (id) => {
    form.post(route("sales.saveWithBrand", id), {
        onFinish: () => {
            if (!hasErrors.value) {
                clearForm();
                toast.message = "Venta guardada con éxito";
                toast.bg = "bg-green-600";
                toast.show = true;
                setTimeout(() => {
                    toast.show = false;
                }, 5000);
            }
            clearAppErrors();
            hasErrors.value = false;
            loading.show = false;
        },
        onError: () => {
            clearAppErrors();
            loading.show = false;
        },
        onProgress: () => {
            loading.show = true;
        }
    });
};

/**
 * Valida que el archivo seleccionado sea
 * uno de los listados en allFormats
 *
 * @param {File} file
 */
export const validateFile = (file) => {
    const { type } = file;

    if (!allFormats.includes(type)) {
        form.voucher = "";
        usePage().props.value.errors = {
            comprobante:
                "El archivo seleccionado no es válido, intente con uno de los siguientes formatos: pdf, imagen, doc, txt",
        };
        clearAppErrors();
        return false;
    }

    return true;
};
