<script setup>
// utils
import { usePage } from "@inertiajs/inertia-vue3";
import pathLogos from "@/utils/pathLogos.js";
import { clearForm } from "@/Pages/Brand/utils/useForm.js";

// props
const { id, form, spinner } = defineProps({
    id: {
        type: Number,
        description: "id de la marca",
    },
    form: {
        type: Object,
        description: "Objeto de configuración para el formulario",
    },
    spinner: {
        type: Object,
        description: "Objeto de configuración para el spinner",
    },
});

/**
 * Cargar los datos al formulario
 */
const loadFormWithData = () => {
    const brands = usePage().props.value.brands;
    const brand = brands.find((brand) => brand.id === id);

    if (brand && typeof brand === "object") {
        // limpiar previamente el formulario
        clearForm();

        // crear el logo de la marca como archivo file
        createFile(brand);
    }
};

/**
 * Crear el logo de la marca como archivo file
 */
const createFile = ({ id, logo, name, email_one, email_two }) => {
    spinner.show = true;
    axios
        .get(route("get.logo", id))
        .then((response) => {
            const data = response.data;
            if (data) {
                const blob = new Blob([data], {
                    type: response.headers["content-type"],
                });
                const file = new File([blob], logo, {
                    type: response.headers["content-type"],
                });
                form.logo = file;

                // cargar el formulario con los datos de la marca
                form.id = id;
                form.name = name;
                form.email_one = email_one;
                form.email_two = email_two;
                form.preview = `${pathLogos.value + logo}`;
                form.update = true;
            }
        })
        .catch((error) => {
            console.log(error);
        })
        .finally(() => {
            spinner.show = false;
        });
};
</script>

<template>
    <button
        :disabled="spinner.show"
        @click="loadFormWithData"
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
        <span class="sm:hidden xl:block"> Editar </span>
    </button>
</template>
