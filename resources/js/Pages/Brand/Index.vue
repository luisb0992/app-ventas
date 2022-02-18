<script setup>
// componentes
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import Toast from "@/Components/custom/Toast.vue";
import Confirm from "@/Components/custom/Confirm.vue";
import Form from "@/Pages/Brand/partials/Form.vue";

// utils
import { computed, ref } from "vue";
import { Head, useForm, usePage } from "@inertiajs/inertia-vue3";
import pathLogos from "@/utils/pathLogos.js";

// listado de props
const { brands } = defineProps({
    brands: {
        type: Array,
        description: "lista de marcas",
    },
});

// objeto del formulario global
const form = useForm({
    name: "",
    logo: "",
    email_one: "",
    email_two: "",
    preview: "",
});

const closeErrors = (time = 5000) => {
    setTimeout(() => {
        usePage().props.value.errors = {};
    }, time);
};

// mostrar o no un mensaje
const showToast = ref(false);

// mostrar o no el modal de confirmación
const showConfirm = ref(false);

// mensaje para el toast
const toastMessage = ref("");

const hasErrors = computed(
    () => Object.keys(usePage().props.value.errors).length > 0
);

const confirmDelete = (id) => {
    showConfirm.value = true;
    form.id = id;
};

const deleteBrand = () => {
    form.delete(route("brands.destroy", form.id), {
        onFinish: () => {
            toastMessage.value = "Marca eliminada con éxito";
            showToast.value = true;
            showConfirm.value = false;
            setTimeout(() => {
                showToast.value = false;
            }, 3000);
        },
        onError: () => {
            closeErrors();
        },
    });
};
</script>

<template>
    <Head title="Marcas" />

    <BreezeAuthenticatedLayout>
        <Toast :message="toastMessage" v-show="showToast" />
        <Confirm
            @confirm-modal="deleteBrand"
            @close-confirm-modal="showConfirm = false"
            :show-confirm="showConfirm"
        />
        <div class="py-12 bg-white">
            <div class="max-w-full px-4 sm:px-6 lg:px-6">
                <div class="lg:text-left">
                    <h2
                        class="text-blue-sales-1 font-semibold tracking-wide uppercase border-b-blue-sales-1 border-b-2 pb-3"
                    >
                        Marcas
                    </h2>
                </div>

                <div class="mt-10">
                    <div class="sm:grid sm:gap-2 sm:grid-cols-2 md:grid-cols-3">
                        <!-- base de formulario -->
                        <div
                            class="col-span-2 mx-auto rounded-lg text-center h-max"
                        >
                            <!-- formulario -->
                            <Form :form="form"/>
                            <!-- /formulario -->
                        </div>
                        <!-- /base de formulario -->

                        <!-- listado de marcas -->
                        <div class="mt-3 sm:mt-0 overflow-y-auto md:h-[700px]">
                            <div
                                class="bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700 px-6 py-8 w-full lg:w-2/3 mb-3 mx-auto"
                                v-for="brand in brands"
                                :key="brand.id"
                            >
                                <div class="flex flex-col items-center">
                                    <img
                                        class="mb-3 w-24 h-24 rounded-full shadow-lg"
                                        :src="pathLogos + brand.logo"
                                        alt="Logo brand"
                                    />
                                    <h3
                                        class="mb-1 text-xl font-medium text-gray-900 dark:text-white"
                                    >
                                        {{ brand.name }}
                                    </h3>
                                    <div class="flex mt-4 space-x-3">
                                        <button
                                            type="button"
                                            class="text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center mr-2 mb-2 dark:focus:ring-yellow-900 inline-flex items-center"
                                        >
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
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                                />
                                            </svg>
                                            <span> Editar </span>
                                        </button>
                                        <button
                                            type="button"
                                            class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 inline-flex items-center"
                                            @click="confirmDelete(brand.id)"
                                        >
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
                                                    d="M6 18L18 6M6 6l12 12"
                                                />
                                            </svg>
                                            <span> Eliminar </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /listado de marcas -->
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
