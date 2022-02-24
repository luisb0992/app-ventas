<script setup>
// componentes
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
import BrandListCardWithChart from "@/Pages/Chart/partials/BrandListCardWithChart.vue";

// utils
import { numberFormatES } from "@/utils/functions.js";
import { Chart, registerables } from "chart.js";
import { DoughnutChart, useDoughnutChart } from "vue-chart-3";
import { computed, reactive } from "vue";
Chart.register(...registerables);

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

//clases para activar o inactivar botones
const classes = {
    active: "py-2.5 px-5 mr-2 mb-2 text-sm font-medium rounded-full border focus:z-10 focus:ring-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-blue-300",
    inactive:
        "py-2.5 px-5 mr-2 mb-2 text-sm font-medium rounded-full border focus:z-10 focus:ring-2 text-gray-900 bg-white border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700",
};

// reactive data
const dataBrand = reactive({
    brands: brands,
    labels: brands.map((brand) => brand.name),
    totalSales: brands.map((brand) => brand.sumSales),
    sumAllSales: sumAllSales,
    backgroundColor: [
        "#3e95cd",
        "#FF9200",
        "#8e5ea2",
        "#3cba9f",
        "#c45850",
        "#97B0C4",
        "#123E6B",
        "#FFB400",
        "#28B328",
    ],
});

// computed data doughnut
const chartData = computed(() => ({
    labels: dataBrand.labels,
    datasets: [
        {
            data: dataBrand.totalSales,
            backgroundColor: dataBrand.backgroundColor,
        },
    ],
}));

// config y data doughnut
const { doughnutChartProps } = useDoughnutChart({
    chartData,
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false,
            },
        },
    },
});

/**
 * Filtra los datos según sea su tipo
 * Ya sea por dia, mes o año
 *
 * @param {HTMLBaseElement} event - el elemento que dispara el evento
 * @param {Number} type -           el tipo de filtro a ejecutar
 */
const setData = async (event, type) => {
    // desactivar todos los botones
    document
        .querySelectorAll("#btns button")
        .forEach((btn) => (btn.className = classes.inactive));

    // activar el botón presionado
    event.target.className = classes.active;

    try {
        // yearly data
        const data = await axios.get(route("brands.data.date", type));

        // setear los datos principales
        dataBrand.totalSales = await data.data.map((brand) => brand.sumSales);

        // setear el monto total de ventas
        dataBrand.sumAllSales = await data.data.reduce(
            (total, brand) => total + brand.sumSales,
            0
        );

        // Actualizar el componente de marcas
        dataBrand.brands = data.data;
        // console.log(dataBrand.sumAllSales);
        // console.log(dataBrand.totalSales);
        // console.log(brands);
        // console.log(dataBrand.brands);

    } catch (error) {
        console.log(error);
    }
};
</script>
<template>
    <BreezeAuthenticatedLayout>
        <Head title="Graficos" />

        <div class="w-full">
            <div
                class="px-4 py-4 animate-fade-in-down bg-white rounded-lg shadow-lg"
            >
                <div class="lg:flex">
                    <!-- gráfico general -->
                    <div
                        class="lg:w-[70%] mb-6 lg:mb-0 flex flex-col items-center justify-center w-full"
                    >
                        <div class="flex flex-col">
                            <DoughnutChart v-bind="doughnutChartProps" />
                            <p
                                class="text-blue-sales-1 font-bold text-2xl text-center py-3"
                            >
                                $ {{ numberFormatES(dataBrand.sumAllSales) }}
                            </p>
                        </div>

                        <div
                            class="flex justify-center items-center mt-5"
                            id="btns"
                        >
                            <button
                                @click="setData($event, 1)"
                                type="button"
                                id="btn-1"
                                class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700"
                            >
                                Anual
                            </button>
                            <button
                                @click="setData($event, 2)"
                                type="button"
                                id="btn-2"
                                class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700"
                            >
                                Mensual
                            </button>
                            <button
                                @click="setData($event, 3)"
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
                        class="overflow-y-auto lg:h-[700px] lg:w-[30%] lg:px-8"
                    >
                        <BrandListCardWithChart
                            v-for="brand in dataBrand.brands"
                            :key="brand.id"
                            :brand="brand"
                            :totalOtherBrandSales="dataBrand.sumAllSales - brand.sumSales"
                        />
                    </div>
                    <!-- /listado de marcas -->
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
