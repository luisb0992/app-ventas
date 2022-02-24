<script setup>
// componentes
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
import Toast from "@/Components/custom/Toast.vue";
import DataTable from "@/Pages/Brand/partials/DataTable.vue";
import BrandListCard from "@/Pages/Brand/partials/BrandListCard.vue";

// utils
import toast from "@/utils/toastMessage.js";
import pathLogo from "@/utils/pathLogos.js";

// props
const { brand } = defineProps({
    brand: {
        type: Object,
        description: "La marca asociada a la venta",
    },
    brands: {
        type: Array,
        description: "lista de marcas",
    },
});

</script>
<template>
    <BreezeAuthenticatedLayout>
        <Head :title="'Marca ' + brand.name" />

        <Toast
            @close-toast="toast.show = false"
            :message="toast.message"
            :bg="toast.bg"
            :show="toast.show"
        />

        <div class="w-full">
            <div
                class="px-4 py-4 animate-fade-in-down bg-white rounded-lg shadow-lg"
            >
                <!-- datos de la marca -->
                <div class="inline-flex items-center justify-start mb-8">
                    <img
                        class="w-24 h-24 rounded-full shadow-lg mr-4"
                        :src="pathLogo + brand.logo"
                        alt="Logo Marca"
                    />
                    <h2 class="text-gray-900 text-3xl font-bold text-center">
                        {{ brand.name }}
                    </h2>
                </div>
                <!-- /datos de la marca -->

                <!-- tabla de datos -->
                <div class="lg:flex">
                    <div class="lg:w-[70%] mb-6 lg:mb-0">
                        <div class="flex flex-col">
                            <div
                                class="overflow-x-auto shadow-md sm:rounded-lg"
                            >
                                <div
                                    class="inline-block min-w-full align-middle"
                                >
                                    <div class="overflow-hidden">
                                        <DataTable
                                            :data="brand.paginateSales"
                                            :brand="brand"
                                            :toast="toast"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /tabla de datos -->

                    <!-- listado de marcas -->
                    <div
                        class="overflow-y-auto lg:h-[700px] lg:w-[30%] lg:px-8"
                    >
                        <BrandListCard :brands="brands" />
                    </div>
                    <!-- /listado de marcas -->
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
