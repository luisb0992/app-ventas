<script setup>
import { Head, useForm } from "@inertiajs/inertia-vue3";
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeLabel from "@/Components/Label.vue";
import Toast from "@/Components/custom/Toast.vue";
import { ref } from "vue";

const { brands } = defineProps({
    brands: {
        type: Array,
        description: "lista de marcas",
    },
});

// brands.push(
//     {
//         id: 1,
//         name: "Nike",
//         email_one: "chele@gmail.com",
//         email_two: "chele2@gmail.com",
//         logo: "https://cdn.pixabay.com/photo/2022/02/12/13/29/desert-7008952_960_720.jpg",
//     },
//     {
//         id: 2,
//         name: "Adidas",
//         email_one: "chele@gmail.com",
//         email_two: "chele2@gmail.com",
//         logo: "https://cdn.pixabay.com/photo/2015/04/23/22/00/tree-736885_960_720.jpg",
//     },
//     {
//         id: 3,
//         name: "Puma",
//         email_one: "chele@gmail.com",
//         email_two: "chele2@gmail.com",
//         logo: "https://cdn.pixabay.com/photo/2015/04/23/22/00/tree-736885_960_720.jpg",
//     }
// );

const isSave = ref(false);

const form = useForm({
    name: "",
    logo: "",
    email_one: "",
    email_two: "",
});

const submit = () =>
    form.post(route("brands.store"), {
        onFinish: () => {
            form.reset();
            isSave.value = true;
             setTimeout(() => {
                isSave.value = false;
            }, 3000);
        },
        onError: () => {
            // setTimeout(() => {
            //     usePage().props.value.errors = {};
            // }, 3000);
        },
    });
</script>

<template>
    <Head title="Marcas" />

    <BreezeAuthenticatedLayout>
        <Toast message="Se agrego correctamente" v-show="isSave" />
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
                        <!-- formulario -->
                        <div
                            class="col-span-2 bg-blue-sales-1 mx-auto rounded-lg text-center h-max"
                        >
                            <form @submit.prevent="submit">
                                <div class="justify-center px-8 sm:px-12 py-10">
                                    <p
                                        class="text-lg font-bold text-gray-200 mb-10"
                                    >
                                        Agregar marca
                                    </p>

                                    <!-- input file -->
                                    <div
                                        class="max-w-full rounded-xl overflow-hidden hover:bg-[#004a99] cursor-pointer"
                                    >
                                        <div class="md:flex">
                                            <div class="w-full">
                                                <div
                                                    class="relative h-48 rounded-lg bg-gray-50 flex justify-center items-center opacity-50"
                                                >
                                                    <div class="absolute">
                                                        <div
                                                            class="flex flex-col items-center"
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
                                                                    d="M12 4v16m8-8H4"
                                                                />
                                                            </svg>
                                                            <span
                                                                class="block text-gray-600 font-normal mt-2 text-lg"
                                                            >
                                                                Logo
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <input
                                                        type="file"
                                                        class="h-full w-full opacity-0"
                                                        @input="
                                                            form.logo =
                                                                $event.target.files[0]
                                                        "
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /input file -->

                                    <!-- input nombre marca -->
                                    <div class="mt-6">
                                        <BreezeInput
                                            id="brand"
                                            type="text"
                                            class="block py-2.5 px-0 w-full text-gray-100 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600"
                                            v-model="form.name"
                                            required
                                            autofocus
                                            placeholder="Nombre de la marca"
                                        />
                                    </div>
                                    <!-- /input nombre marca -->

                                    <!-- email 1 -->
                                    <div class="mt-6">
                                        <BreezeInput
                                            id="brand"
                                            type="email"
                                            class="block py-2.5 px-0 w-full text-gray-100 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600"
                                            v-model="form.email_one"
                                            required
                                            autofocus
                                            placeholder="Correo electrónico uno"
                                        />
                                    </div>
                                    <!-- /email 1 -->

                                    <!-- email 2 -->
                                    <div class="mt-6">
                                        <BreezeInput
                                            id="brand"
                                            type="email"
                                            class="block py-2.5 px-0 w-full text-gray-100 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600"
                                            v-model="form.email_two"
                                            required
                                            autofocus
                                            placeholder="Correo electrónico dos"
                                        />
                                    </div>
                                    <!-- /email 2 -->

                                    <div class="mt-6">
                                        <button
                                            type="submit"
                                            class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-blue-sales-1 bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-sales-1 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                                        >
                                            Guardar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /formulario -->

                        <!-- listado de marcas -->
                        <div class="mt-3 sm:mt-0 h-max">
                            <div
                                class="bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700 px-6 py-8 w-auto mb-3"
                                v-for="brand in brands"
                                :key="brand.id"
                            >
                                <div class="flex flex-col items-center">
                                    <img
                                        class="mb-3 w-24 h-24 rounded-full shadow-lg"
                                        :src="brand.logo"
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
                                            class="text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:focus:ring-yellow-900 inline-flex items-center"
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
                                            class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 inline-flex items-center"
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
                                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
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
