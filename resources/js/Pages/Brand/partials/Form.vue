<script setup>
// utils
import { computed, reactive } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";
import { clearForm } from "@/Pages/Brand/utils/useForm.js";
import clearAppErrors from "@/utils/clearAppErrors.js";

// componentes
import BreezeInput from "@/Components/Input.vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import Loading from '@/Components/custom/Loading.vue';

const { toast, form } = defineProps({
    toast: {
        type: Object,
        description: "Objeto de configuración para el toast",
    },
    form: {
        type: Object,
        description: "Objeto de configuración para el formulario",
    },
});

// mostrar o no el loading
const loading = reactive({
    show: false
});

// evento submit para crear o actualizar una marca
const submitBrand = () => {
    let path = "";
    if (form.update) {
        path = route("brands.updateAll", form.id);
        toast.message = "Marca actualizada con éxito";
    } else {
        path = route("brands.store");
        toast.message = "Marca creada con éxito";
    }

    form.post(path, {
        onFinish: () => {
            if (!hasErrors.value) {
                clearForm();
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
            loading.show = false;
            clearAppErrors();
        },
        onProgress: () => {
            loading.show = true;
        },
    });
};

// validar el archivo seleccionado
const fileIsValidate = (file) => {
    // archivos permitidos
    const validFile = [
        "image/jpeg",
        "image/png",
        "image/jpg",
        "image/bmp",
        "image/svg",
    ];

    // validar si el archivo es una imagen
    const isValid = validFile.includes(file.type);

    if (!isValid) {
        form.logo = "";
        form.preview = "";
        usePage().props.value.errors = {
            preview: "El archivo debe ser una imagen",
        };

        return clearAppErrors();
    }
    return (form.preview = URL.createObjectURL(file));
};

// eliminar logo cargado
const deleteLogo = () => {
    form.logo = "";
    form.preview = "";
};

// errores de validación
const hasErrors = computed(
    () => Object.keys(usePage().props.value.errors).length > 0
);

// cierra el toast
const closeToast = () => {
    toast.show = false;
};
</script>

<template>
    <BreezeValidationErrors
        class="mb-4 bg-gray-50 border border-gray-200 rounded-lg py-6"
    />
    <div class="bg-blue-sales-1">
        <form @submit.prevent="submitBrand" :class="loading.show ? 'opacity-50' : 'opacity-100'">
            <div class="justify-center px-8 sm:px-12 py-10">
                <p class="text-lg font-bold text-gray-200 mb-10">
                    Agregar marca
                </p>

                <!-- input file -->
                <div class="max-w-full rounded-xl overflow-hidden">
                    <div
                        class="md:flex hover:bg-[#004a99] cursor-pointer"
                        v-if="!form.logo"
                    >
                        <div class="w-full">
                            <div
                                class="relative h-48 rounded-lg bg-gray-50 flex justify-center items-center opacity-50"
                            >
                                <div class="absolute">
                                    <div class="flex flex-col items-center">
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
                                    :disabled="loading.show"
                                    type="file"
                                    class="h-full w-full opacity-0"
                                    @input="form.logo = $event.target.files[0]"
                                    @change="fileIsValidate(form.logo)"
                                />
                            </div>
                        </div>
                    </div>
                    <div v-show="form.preview">
                        <img
                            class="w-full h-48 object-cover mb-4"
                            :src="form.preview"
                        />
                        <button
                            :disabled="loading.show"
                            @click="deleteLogo"
                            type="button"
                            class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
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
                            <span>Eliminar</span>
                        </button>
                    </div>
                    <div>
                        <small class="text-gray-100">
                            <span class="font-bold">
                                Archivos soportados:
                            </span>
                            jpg,bmp,png,jpeg,svg,
                            <span class="font-bold"> Max: </span>
                            2048 MB
                            <br />
                            <span class="font-bold">Tamaño recomendado: </span>
                            120x120px
                        </small>
                    </div>
                </div>
                <!-- /input file -->

                <!-- input nombre marca -->
                <div class="mt-6">
                    <BreezeInput
                        :disabled="loading.show"
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
                        :disabled="loading.show"
                        id="brand"
                        type="email"
                        class="block py-2.5 px-0 w-full text-gray-100 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600"
                        v-model="form.email_one"
                        required
                        placeholder="Correo electrónico uno"
                    />
                </div>
                <!-- /email 1 -->

                <!-- email 2 -->
                <div class="mt-6">
                    <BreezeInput
                        :disabled="loading.show"
                        id="brand"
                        type="email"
                        class="block py-2.5 px-0 w-full text-gray-100 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600"
                        v-model="form.email_two"
                        required
                        placeholder="Correo electrónico dos"
                    />
                </div>
                <!-- /email 2 -->

                <div class="mt-6 inline-flex">
                    <button
                        :disabled="loading.show"
                        type="submit"
                        class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium rounded-full border focus:z-10 focus:ring-2 border-gray-200"
                        :class="
                            form.update
                                ? 'bg-yellow-500 text-gray-800 hover:bg-yellow-600 hover:text-gray-900'
                                : 'bg-white text-blue-sales-1 hover:bg-gray-100 hover:text-blue-sales-1'
                        "
                    >
                        <span v-if="form.update">Actualizar</span>
                        <span v-else>Guardar</span>
                    </button>
                    <button
                        :disabled="loading.show"
                        v-if="form.update"
                        @click="clearForm"
                        type="button"
                        class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium rounded-full border focus:z-10 focus:ring-2 border-gray-200 animate-fade-in-down bg-white text-blue-sales-1 hover:bg-gray-100 hover:text-blue-sales-1"
                    >
                        <span>Limpiar</span>
                    </button>
                    <Loading
                        class="animate-fade-in-down text-white -mt-4"
                        bg="bg-white"
                        width="w-8"
                        height="h-8"
                        v-if="loading.show"
                    />
                </div>
            </div>
        </form>
    </div>
</template>
