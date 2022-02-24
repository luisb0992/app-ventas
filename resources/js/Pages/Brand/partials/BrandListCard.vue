<script setup>
// componentes
import { Link} from "@inertiajs/inertia-vue3";

// utils
import { substr } from "@/utils/functions.js";
import pathLogo from "@/utils/pathLogos.js";

defineProps({
    brands: {
        type: Array,
        default: () => [],
        description: "lista de marcas",
    },
});
</script>
<template>
    <div
        class="bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700 py-8 w-full mb-3 mx-auto animate-fade-in-down"
        v-for="brand in brands"
        :key="brand.id"
    >
        <div class="flex justify-center">
            <Link
                :href="route('brands.show', brand.id)"
                class="lg:inline-flex items-center border-indigo-400 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out"
            >
                <img
                    class="w-24 h-24 rounded-full shadow-lg lg:mr-4 mb-3 lg:mb-0"
                    :src="pathLogo + brand.logo"
                    alt="Logo Marca"
                />
                <h3
                    class="text-gray-900 dark:text-white font-medium sm:hidden xl:block text-xl xl:text-lg text-center hover:text-blue-sales-1"
                >
                    {{ substr(brand.name) }}
                </h3>
            </Link>
        </div>
    </div>
</template>
