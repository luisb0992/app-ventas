<script setup>
// import { ref } from "vue";
import BreezeNavLink from "@/Components/NavLink.vue";
import BreezeResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
// import { Link } from "@inertiajs/inertia-vue3";

import Sidebar from "@/Components/custom/Sidebar.vue";
import Header from "@/Components/custom/Header.vue";

// const showingNavigationDropdown = ref(false);
</script>

<template>
    <div class="flex h-screen bg-gray-200 font-roboto">
        <Sidebar />

        <div class="flex-1 flex flex-col overflow-hidden">
            <Header />

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                <div class="container mx-auto px-6 py-8">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>
