<script setup>

// las props
const { message, bg, icon, show } = defineProps({
    message: {
        type: String,
        default: "El mensaje",
        description: "El mensaje que se mostrará en el toast",
    },
    bg: {
        type: String,
        default: "bg-gray-100",
        description: "El color de fondo del toast",
    },
    icon: {
        type: String,
        default: "check",
        description: "El icono que se mostrará en el toast",
    },
    show: {
        type: Boolean,
        default: false,
        description: "Mostrar o no el toast",
    },
});
</script>
<template>
    <div
        id="toast-container"
        :class="bg"
        class="flex items-center w-full max-w-xs p-4 mb-4 text-gray-100 rounded-lg shadow dark:text-gray-400 dark:bg-gray-800 absolute bottom-5 right-10 animate-fade-in-down"
        role="alert"
        v-show="show"
    >
        <div
            class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-blue-500 bg-gray-200 rounded-lg"
        >
            <span v-if="icon === 'check'">
                <svg
                    class="w-5 h-5"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                        clip-rule="evenodd"
                    ></path>
                </svg>
            </span>
            <span v-else-if="icon === 'warning'">
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
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                    />
                </svg>
            </span>
            <span v-else-if="icon === 'danger'">
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
            </span>
            <span v-else-if="icon === 'info'">
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
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>
            </span>
        </div>
        <div class="ml-3 text-sm font-normal">{{ message }}</div>
        <button
            type="button"
            class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-700 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
            data-collapse-toggle="toast-container"
            aria-label="Close"
            @click="$emit('close-toast')"
        >
            <span class="sr-only">Cerrar</span>
            <svg
                class="w-5 h-5"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    fill-rule="evenodd"
                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                    clip-rule="evenodd"
                ></path>
            </svg>
        </button>
    </div>
</template>
