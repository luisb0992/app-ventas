<script setup>
// componentes
import { Link } from "@inertiajs/inertia-vue3";

// utils
import { substr, numberFormatES } from "@/utils/functions.js";
import pathLogo from "@/utils/pathLogos.js";
import { Chart, registerables } from "chart.js";
import { DoughnutChart, useDoughnutChart } from "vue-chart-3";
import { computed, reactive } from "vue";
Chart.register(...registerables);

const { brand, totalOtherBrandSales } = defineProps({
    brand: {
        type: Object,
        default: () => {},
        description: "Marca a mostrar junto a su data",
    },
    totalOtherBrandSales: {
        type: Number,
        description: "total de ventas de otras marcas",
    },
});

// import { getCurrentInstance } from 'vue'
// const instance = getCurrentInstance();
// instance?.proxy?.$forceUpdate();

// console.log(instance);
// reactive data
// const dataBrand = reactive({
// allSales: allSales,
// labels: [brand.name, 'Otras marcas'],
// total: brand.sumSales,
// totalOther: computed(() => dataBrand.allSales - dataBrand.total),
// backgroundColor: ["#3e95cd", "#FF9200"],
// });

// calcular el total de otras ventas de otras marcas
// restando el total de ventas de la marca actual
// const totalOther = computed(() => dataBrand.allSales - dataBrand.total);

// computed data doughnut
const chartData = computed(() => ({
    labels: [brand.name, "Otras marcas"],
    datasets: [
        {
            data: [brand.sumSales, totalOtherBrandSales],
            backgroundColor: ["#3e95cd", "#FF9200"],
        },
    ]
}));

// config y data doughnut
const { doughnutChartProps, doughnutChartRef, update } = useDoughnutChart({
    chartData,
    jsx: {
        options: {
            legend: {
                display: false,
            },
            tooltips: {
                callbacks: {
                    label: function (tooltipItem, data) {
                        return numberFormatES(tooltipItem.yLabel);
                    },
                },
            },
        },
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false,
            },
        },
    },
});
</script>
<template>
    <div
        class="bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700 py-8 px-4 w-full mb-3 mx-auto animate-fade-in-down lg:flex"
    >
        <div class="lg:w-[60%] flex flex-col mr-3 mb-4 lg:mb-0">
            <DoughnutChart v-bind="doughnutChartProps" />
        </div>
        <div
            class="flex flex-col items-center lg:items-start justify-center lg:w-[40%]"
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
                <span class="text-blue-sales-1 font-bold text-base py-3">
                    $ {{ numberFormatES(brand.sumSales) }}
                </span>
            </div>
        </div>
    </div>
</template>
