<script setup>
defineProps({
    failed: {
        type: String,
        default: "",
        description: "Indica si algo de la operación falló",
    },
});
</script>
<template>
    <div
        v-if="failed"
    >
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6 mr-3"
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

        <!-- mensaje de error -->
        {{ failed }}
    </div>
</template>
