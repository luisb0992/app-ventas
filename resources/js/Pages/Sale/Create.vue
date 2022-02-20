<script setup>
// componentes
import BreezeGuestLayout from "@/Layouts/Guest.vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import Toast from '@/Components/custom/Toast.vue';

// utils
import pathLogos from "@/utils/pathLogos.js";
import { useForm, usePage } from "@inertiajs/inertia-vue3";
import allFormats from "@/Pages/Sale/utils/validFormat.js";
import clearAppErrors from "@/utils/clearAppErrors";
import hasErrors from "@/utils/hasAppErrors.js";
import toast from "@/utils/toastMessage.js";

const { brand } = defineProps({
    brand: {
        type: Object,
        description: "La marca asociada a la venta",
    },
});

// formulario de datos
const form = useForm({
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
const createSale = () => {
    form.post(route("sales.saveWithBrand", brand.id), {
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
        },
        onError: () => {
            clearAppErrors();
        },
    });
};

// toast.show = true;
// console.log(toast);
/**
 * Recortar un string
 *
 * @param {string} value
 * @param {number} longitud
 */
const substr = (value, longitud = 10) => {
    return value.substr(0, longitud) + "...";
};

/**
 * Calcular el tamaño de un archivo en mb
 *
 * @param {number} value
 */
const calculateSizeInMB = (value) => {
    return (value / 1024 / 1024).toFixed(2);
};

/**
 * Devuelve un string sin la palabra "image/"
 *
 * @param {string} value
 */
const replaceWordImage = (value) => {
    return value.replace("image/", "");
};

/**
 * Valida que el archivo seleccionado sea
 * uno de los listados en allFormats
 *
 * @param {File} file
 */
const validateFile = (file) => {
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
</script>
<template>
    <BreezeGuestLayout>
        <Head title="Venta" />

        <Toast
            @close-toast="toast.show = false"
            :message="toast.message"
            :bg="toast.bg"
            :show="toast.show"
        />

        <div>
            <div
                class="dark:bg-gray-800 dark:border-gray-700 px-2 py-4 w-full mb-3 mx-auto animate-fade-in-down"
            >
                <div class="inline-flex items-center justify-center">
                    <img
                        class="mb-3 w-24 h-24 rounded-full shadow-lg mr-4"
                        :src="pathLogos + brand.logo"
                        alt="Logo Marca"
                    />
                    <h3
                        class="mb-1 text-gray-900 dark:text-white lg:text-lg xl:text-lg font-medium text-center hover:text-blue-sales-1"
                    >
                        {{ brand.name }}
                    </h3>
                </div>
            </div>
            <BreezeValidationErrors
                class="mb-4 bg-gray-50 border border-gray-200 rounded-lg py-6 px-4"
            />
            <form @submit.prevent="createSale">
                <div class="relative z-0 mb-6 w-full group">
                    <input
                        autofocus
                        type="text"
                        v-model.trim="form.service"
                        id="servicio"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                        required
                    />
                    <label
                        for="servicio"
                        class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                    >
                        Servicio
                    </label>
                </div>
                <div class="relative z-0 mb-6 w-full group">
                    <input
                        type="number"
                        v-model.number="form.count"
                        step="1"
                        min="1"
                        id="cantidad"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                        required
                    />
                    <label
                        for="cantidad"
                        class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                    >
                        Cantidad
                    </label>
                </div>
                <div class="relative z-0 mb-6 w-full group">
                    <input
                        type="number"
                        v-model.number="form.amount"
                        step="0.01"
                        min="0"
                        id="monto"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                        required
                    />
                    <label
                        for="monto"
                        class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                    >
                        Monto
                    </label>
                </div>
                <div class="relative z-0 mb-6 w-full group">
                    <input
                        type="text"
                        v-model.trim="form.client"
                        id="cliente"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" "
                        required
                    />
                    <label
                        for="cliente"
                        class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                    >
                        Cliente
                    </label>
                </div>
                <div class="relative z-0 mb-56 w-full">
                    <div class="absolute w-[340px]">
                        <label class="inline-block mb-2 text-gray-500">
                            Comprobante
                        </label>
                        <div class="block py-2.5 w-full bg-gray-50">
                            <label
                                class="flex flex-col h-32 border-4 border-blue-200 hover:bg-gray-100 hover:border-gray-300"
                            >
                                <div
                                    class="flex flex-col items-center justify-center"
                                    :class="form.voucher ? 'mt-4' : 'mt-10'"
                                >
                                    <p
                                        class="text-base tracking-wider text-gray-600 group-hover:text-gray-600"
                                    >
                                        <span
                                            v-if="!form.voucher"
                                            class="inline-flex items-center gap-2"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="w-8 h-8 text-gray-400 group-hover:text-gray-600"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
                                                />
                                            </svg>
                                            <span> Subir archivo </span>
                                        </span>
                                        <span v-else class="font-bold">
                                            <div class="inline-flex">
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    class="h-6 w-6"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M13 7l5 5m0 0l-5 5m5-5H6"
                                                    />
                                                </svg>
                                                {{
                                                    substr(
                                                        form.voucher.name,
                                                        15
                                                    )
                                                }}
                                            </div>
                                            <br />
                                            <div class="inline-flex">
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    class="h-6 w-6"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M13 7l5 5m0 0l-5 5m5-5H6"
                                                    />
                                                </svg>
                                                {{
                                                    calculateSizeInMB(
                                                        form.voucher.size
                                                    )
                                                }}
                                                MB
                                            </div>
                                            <br />
                                            <div class="inline-flex">
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    class="h-6 w-6"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M13 7l5 5m0 0l-5 5m5-5H6"
                                                    />
                                                </svg>
                                                {{
                                                    replaceWordImage(
                                                        form.voucher.type
                                                    )
                                                }}
                                            </div>
                                        </span>
                                    </p>
                                </div>
                                <input
                                    type="file"
                                    class="opacity-0"
                                    @input="
                                        form.voucher = $event.target.files[0]
                                    "
                                    @change="validateFile(form.voucher)"
                                />
                            </label>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-center mt-4">
                    <button
                        type="submit"
                        class="text-white bg-blue-sales-1 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-lg w-full sm:w-auto px-7 py-3.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    >
                        Enviar
                    </button>
                </div>
            </form>
        </div>
    </BreezeGuestLayout>
</template>
