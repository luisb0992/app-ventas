<script setup>
// componentes
import { Link } from "@inertiajs/inertia-vue3";

// utils
import { DoughnutChart } from "vue-chart-3";
import { Chart, registerables } from "chart.js";
import { computed, onMounted, reactive, ref } from "vue";
import { substr, numberFormatES } from "@/utils/functions.js";
import pathLogo from "@/utils/pathLogos.js";
Chart.register(...registerables);

const { brand, sumAllSales } = defineProps({
    brand: {
        type: Object,
        default: () => {},
        description: "Marca a mostrar junto a su data",
    },
    sumAllSales: {
        type: Number,
        description: "Total de ventas de todas las marcas",
    },
});

// referencia del chart
const doughnutRef = ref();

// total de otras marcas restando
// las ventas de la marca actual - sumAllSales
const totalOtherBrandSales = computed(() => sumAllSales - brand.sumSales);

// data reactive chart
const chartData = reactive({
    labels: [brand.name, "Otras marcas"],
    datasets: [
        {
            data: [brand.sumSales, totalOtherBrandSales.value],
            backgroundColor: ["#3e95cd", "#c45850"],
        },
    ],
});

// config - options
const options = ref({
    responsive: true,
    plugins: {
        legend: {
            display: false,
        },
    },
});

onMounted(() => doughnutRef.value.update());
</script>
<template>
    <div
        class="bg-white rounded-lg shadow-lg border border-gray-200 py-4 px-4 w-full animate-fade-in-down h-full flex flex-col items-center justify-center"
    >
        <div class="flex flex-col items-center justify-center mb-5">
            <Link
                :href="route('brands.show', brand.id)"
                class="inline-flex items-center justify-center transition duration-150 ease-in-out"
            >
                <img
                    class="w-16 h-16 rounded-full shadow-lg mr-4"
                    :src="pathLogo + brand.logo"
                    alt="Logo Marca"
                />
                <h3
                    class="text-gray-500 font-light text-lg hover:text-blue-sales-1"
                >
                    {{ substr(brand.name, 10) }}
                </h3>
            </Link>
        </div>
        <div class="flex flex-col justify-center items-center mb-6">
            <DoughnutChart
                :chartData="chartData"
                :options="options"
                ref="doughnutRef"
                class="mb-4 max-h-40"
            />
            <div>
                <span class="text-blue-sales-1 font-bold text-2xl">
                    $ {{ numberFormatES(brand.sumSales) }}
                </span>
            </div>
        </div>
        <div class="flex lg:flex-col xl:flex-row justify-center items-center lg:gap-4 xl:gap-0" id="btns-filter-chart">
            <button
                @click="$emit('set-filter-chart', $event, 1)"
                type="button"
                id="btn-1"
                class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700"
            >
                Anual
            </button>
            <button
                @click="$emit('set-filter-chart', $event, 2)"
                type="button"
                id="btn-2"
                class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700"
            >
                Mensual
            </button>
            <button
                @click="$emit('set-filter-chart', $event, 3)"
                type="button"
                id="btn-3"
                class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700"
            >
                Diario
            </button>
        </div>
    </div>
</template>
