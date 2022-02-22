<script setup>
// componentes
import BreezeGuestLayout from "@/Layouts/Guest.vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import Toast from "@/Components/custom/Toast.vue";
import Loading from "@/Components/custom/Loading.vue";
import MessageFailed from "@/Components/custom/MessageFailed.vue";

// utils - path para el logo de la marca
import pathLogos from "@/utils/pathLogos.js";

// main de configuración para la creación de una venta
import {
    form,
    validateFile,
    createSale,
    toastMessage as toast,
    loading,
} from "@/Pages/Sale/utils/create.js";

// Funciones varias de utilidad
import {
    calculateSizeInMB,
    substr,
    replaceWordImage,
} from "@/utils/functions.js";

// props
defineProps({
    brand: {
        type: Object,
        description: "La marca asociada a la venta",
    },
    failed: {
        type: String,
        default: "",
        description: "Indica si la creación de la venta falló",
    },
});
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

        <div class="pb-6 w-full">
            <div
                class="flex justify-center px-2 py-4 mb-3 animate-fade-in-down"
            >
                <div class="inline-flex items-center">
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
            <MessageFailed
                class="mb-4 bg-red-600 border border-red-500 text-gray-100 rounded-lg py-6 px-4 inline-flex items-center"
                :failed="failed"
            />
            <form
                @submit.prevent="createSale(brand.id)"
                :class="loading.show ? 'opacity-50' : 'opacity-100'"
            >
                <div class="relative z-0 mb-6 w-full group">
                    <input
                        :disabled="loading.show"
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
                        :disabled="loading.show"
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
                        :disabled="loading.show"
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
                        :disabled="loading.show"
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
                <div class="relative z-0 mb-64 w-full">
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
                                    :disabled="loading.show"
                                    type="file"
                                    class="opacity-0"
                                    @input="
                                        form.voucher = $event.target.files[0]
                                    "
                                    @change="validateFile(form.voucher)"
                                />
                            </label>
                            <p
                                class="text-base tracking-wider text-gray-600 text-center"
                            >
                                <small class="inline-flex"
                                    >Archivos admitidos: imagen, pdf, doc, csv,
                                    xml, txt</small
                                >
                                <small>Max: 10 GB</small>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-center">
                    <button
                        :disabled="loading.show"
                        type="submit"
                        :class="
                            loading.show
                                ? 'bg-gray-800 hover:bg-gray-700'
                                : 'bg-blue-sales-1 hover:bg-blue-900'
                        "
                        class="text-white focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-lg w-full sm:w-auto px-7 py-3.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    >
                        Enviar
                    </button>
                    <Loading
                        class="flex items-center justify-center animate-fade-in-down"
                        v-show="loading.show"
                    />
                </div>
            </form>
        </div>
    </BreezeGuestLayout>
</template>
