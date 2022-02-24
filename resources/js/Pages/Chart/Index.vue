<script setup>
// componentes
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import BrandListCardWithChart from "@/Pages/Chart/partials/BrandListCardWithChart.vue";
import { Head } from "@inertiajs/inertia-vue3";

// utils
import { DoughnutChart } from "vue-chart-3";
import { onMounted, reactive } from "vue";
import { numberFormatES, randomKey } from "@/utils/functions.js";
import { chartData, chartOptions, setData } from "@/Pages/Chart/utils/index.js";

const { brands, sumAllSales } = defineProps({
    brands: {
        type: Array,
        description: "lista de marcas",
    },
    sumAllSales: {
        type: Number,
        description: "total de todas las ventas de todas las marcas",
    },
});

/**
 * Objeto reactivo que contiene los datos de las marcas y sus ventas
 *
 * @typedef {Object} objBrand
 */
const objBrand = reactive({
    brands: [],
    labels: brands.map((brand) => brand.name),
    totalSales: brands.map((brand) => brand.sumSales),
    sumAllSales: sumAllSales,
});

/**
 * Función que se ejecuta al iniciar la página
 */
onMounted(() => {
    objBrand.brands = randomKey(brands);
});
</script>
<template>
    <BreezeAuthenticatedLayout>
        <Head title="Dashboard" />

        <div class="w-full">
            <div
                class="px-4 py-4 animate-fade-in-down bg-white rounded-lg shadow-lg"
            >
                <!-- sub-header marcas -->
                <div class="lg:text-left mb-5">
                    <h2
                        class="text-blue-sales-1 font-semibold tracking-wide uppercase border-b-blue-sales-1 border-b-2 pb-3"
                    >
                        Dashboard
                    </h2>
                </div>
                <!-- /sub-header marcas -->

                <div class="lg:flex">
                    <!-- gráfico general -->
                    <div
                        class="lg:w-[65%] mb-6 lg:mb-0 flex flex-col items-center justify-center w-full"
                    >
                        <div class="flex flex-col">
                            <DoughnutChart
                                :chartData="chartData(objBrand)"
                                :options="chartOptions"
                            />
                            <p
                                class="text-blue-sales-1 font-bold text-3xl text-center py-3"
                            >
                                $ {{ numberFormatES(objBrand.sumAllSales) }}
                            </p>
                        </div>

                        <div
                            class="flex justify-center items-center mt-5"
                            id="btns"
                        >
                            <button
                                @click="setData($event, 1, objBrand)"
                                type="button"
                                id="btn-1"
                                class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700"
                            >
                                Anual
                            </button>
                            <button
                                @click="setData($event, 2, objBrand)"
                                type="button"
                                id="btn-2"
                                class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700"
                            >
                                Mensual
                            </button>
                            <button
                                @click="setData($event, 3, objBrand)"
                                type="button"
                                id="btn-3"
                                class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700"
                            >
                                Diario
                            </button>
                        </div>
                    </div>
                    <!-- /gráfico general -->

                    <!-- listado de marcas -->
                    <div
                        class="overflow-y-auto lg:h-[700px] lg:w-[35%] lg:px-8 lg:py-5"
                    >
                        <BrandListCardWithChart
                            v-for="brand in objBrand.brands"
                            :key="brand.randomKey"
                            :brand="brand"
                            :sum-all-sales="objBrand.sumAllSales"
                        />
                    </div>
                    <!-- /listado de marcas -->
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
