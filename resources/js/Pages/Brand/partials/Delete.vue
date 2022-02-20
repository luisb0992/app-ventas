<script setup>
// utlis
import { ref } from "vue";
import { clearForm } from "@/Pages/Brand/utils/useForm.js";
import clearAppErrors from "@/utils/clearAppErrors.js";

// componentes
import Confirm from "@/Components/custom/Confirm.vue";

// props
const { id, toast, form } = defineProps({
    id: {
        type: Number,
        description: "id de la marca",
    },
    toast: {
        type: Object,
        description: "Objeto de configuración para el toast",
    },
    form: {
        type: Object,
        description: "Objeto de configuración para el formulario",
    },
});

// mostrar o no el modal de confirmación
const showConfirm = ref(false);

// abrir el modal de confirmación
const confirmDelete = (id) => {
    showConfirm.value = true;
};

// eliminar la marca
const deleteBrand = () => {
    form.delete(route("brands.destroy", id), {
        onFinish: () => {
            // ocultar el modal
            showConfirm.value = false;

            // mensaje para el toast
            toast.message = "Marca eliminada con éxito";

            // color de fondo del toast
            toast.bg = "bg-green-600";

            // mostrar el toast
            toast.show = true;

            // limpiar el formulario
            clearForm();

            setTimeout(() => {
                toast.show = false;
            }, 5000);
        },
        onError: () => {
            // ocultar el modal
            showConfirm.value = false;

            // limpiar errores
            clearAppErrors();
        },
    });
};

// cerrar el toast
const closeToast = () => {
    toast.show = false;
};
</script>

<template>
    <Confirm
        @confirm-modal="deleteBrand"
        @close-confirm-modal="showConfirm = false"
        :show-confirm="showConfirm"
    />
    <button
        type="button"
        class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 inline-flex items-center"
        @click="confirmDelete(id)"
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
        <span class="sm:hidden xl:block"> Eliminar </span>
    </button>
</template>
