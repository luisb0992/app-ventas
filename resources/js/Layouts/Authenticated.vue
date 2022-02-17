<script setup>
// import { ref } from "vue";
// import BreezeNavLink from "@/Components/NavLink.vue";
// import BreezeResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
// import { Link } from "@inertiajs/inertia-vue3";
// const showingNavigationDropdown = ref(false);

import Sidebar from "@/Components/custom/Sidebar.vue";
import Header from "@/Components/custom/Header.vue";

</script>

<template>
    <div class="flex h-screen bg-gray-200 font-roboto">
        <Sidebar />

        <div class="flex-1 flex flex-col overflow-hidden">
            <Header />

            <!-- content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                <div class="container mx-auto px-6 py-8">
                    <slot />
                </div>
            </main>
            <!-- /content -->

        </div>
    </div>
</template>
