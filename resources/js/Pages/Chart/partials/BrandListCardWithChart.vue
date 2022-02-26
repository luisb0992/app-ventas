<script setup>
// componentes
import { Link } from "@inertiajs/inertia-vue3";

// utils
import { substr, numberFormatES } from "@/utils/functions.js";
import pathLogo from "@/utils/pathLogos.js";
import { DoughnutChart } from "vue-chart-3";
import { Chart, registerables } from "chart.js";
import { computed, onMounted, reactive, ref } from "vue";
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
        class="lg:flex bg-white rounded-lg shadow-lg border border-gray-200 py-4 px-4 w-full mb-8 animate-fade-in-down"
    >
        <div class="lg:w-[60%] flex flex-col mr-3 mb-4 lg:mb-0">
            <DoughnutChart
                :chartData="chartData"
                :options="options"
                ref="doughnutRef"
                class="lg:max-h-40"
            />
        </div>
        <div
            class="flex flex-col items-center lg:items-start justify-center"
        >
            <Link
                :href="route('brands.show', brand.id)"
                class="flex flex-col items-center lg:items-start justify-center lg:justify-start transition duration-150 ease-in-out"
            >
                <img
                    class="w-24 h-24 lg:w-16 lg:h-16 rounded-full shadow-lg lg:mr-4 mb-3 lg:mb-0"
                    :src="pathLogo + brand.logo"
                    alt="Logo Marca"
                />
                <h3
                    class="text-gray-500 font-light sm:hidden xl:block text-xl xl:text-lg text-center hover:text-blue-sales-1"
                >
                    {{ substr(brand.name, 10) }}
                </h3>
            </Link>

            <div>
                <span class="text-blue-sales-1 font-bold text-2xl py-3">
                    $ {{ numberFormatES(brand.sumSales) }}
                </span>
            </div>
        </div>
    </div>
</template>
