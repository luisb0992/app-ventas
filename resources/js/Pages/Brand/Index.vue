<script setup>
// componentes
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import Toast from "@/Components/custom/Toast.vue";
import Form from "@/Pages/Brand/partials/Form.vue";
import Spinner from "@/Components/custom/Spinner.vue";
import Delete from "@/Pages/Brand/partials/Delete.vue";
import Edit from "@/Pages/Brand/partials/Edit.vue";
import { Link } from "@inertiajs/inertia-vue3";

// utils
import { reactive } from "vue";
import { Head } from "@inertiajs/inertia-vue3";
import pathLogos from "@/utils/pathLogos.js";
import { form } from "@/Pages/Brand/utils/useForm.js";
import toast from '@/utils/toastMessage.js';
import { substr } from "@/utils/functions.js";

// listado de props
const { brands } = defineProps({
    brands: {
        type: Array,
        description: "lista de marcas",
    },
});

// configuración entre componentes para el spinner
const spinner = reactive({
    show: false,
});
</script>

<template>
    <Head title="Marcas" />

    <BreezeAuthenticatedLayout>
        <Toast
            @close-toast="toast.show = false"
            :message="toast.message"
            :bg="toast.bg"
            :show="toast.show"
        />
        <div class="bg-white">
            <div class="max-w-full px-4 py-4 sm:px-6 lg:px-6">
                <!-- header marcas -->
                <div class="lg:text-left">
                    <h2
                        class="text-blue-sales-1 font-semibold tracking-wide uppercase border-b-blue-sales-1 border-b-2 pb-3"
                    >
                        Marcas
                    </h2>
                </div>
                <!-- /header marcas -->

                <!-- body marcas -->
                <div class="mt-5">
                    <div class="sm:grid sm:gap-2 sm:grid-cols-2 md:grid-cols-3">
                        <!-- base de formulario -->
                        <div
                            class="col-span-2 mx-auto rounded-lg text-center h-max"
                        >
                            <Spinner class="mb-4" v-show="spinner.show" />
                            <!-- formulario -->
                            <Form :toast="toast" :form="form" :class="spinner.show ? 'opacity-50' : 'opacity-100'"/>
                            <!-- /formulario -->
                        </div>
                        <!-- /base de formulario -->

                        <!-- listado de marcas -->
                        <div class="mt-3 sm:mt-0 overflow-y-auto md:h-[700px]">
                            <div
                                class="rounded-lg border border-gray-200 shadow-md px-6 py-8 w-full lg:w-2/3 mb-3 mx-auto animate-fade-in-down"
                                v-for="brand in brands"
                                :key="brand.id"
                            >
                                <div class="flex flex-col items-center">
                                    <Link
                                        :href="route('brands.show', brand.id)"
                                        class="md:inline-flex items-center border-indigo-400 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out"
                                    >
                                        <img
                                            class="mb-3 w-24 h-24 rounded-full shadow-lg md:mr-4"
                                            :src="pathLogos + brand.logo"
                                            alt="Logo Marca"
                                        />
                                        <h3
                                            class="mb-1 text-gray-900 lg:text-lg xl:text-lg font-medium sm:hidden xl:block text-center hover:text-blue-sales-1"
                                        >
                                            {{ substr(brand.name) }}
                                        </h3>
                                    </Link>
                                    <div class="flex mt-4 space-x-3">
                                        <Edit
                                            :id="brand.id"
                                            :form="form"
                                            :spinner="spinner"
                                        />
                                        <Delete
                                            :id="brand.id"
                                            :toast="toast"
                                            :form="form"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /listado de marcas -->
                    </div>
                </div>
                <!-- /body marcas -->
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
