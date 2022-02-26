<script setup>
// utils
import { BarChart } from "vue-chart-3";
import { Chart, registerables } from "chart.js";
import { onMounted, reactive, ref } from "vue";
Chart.register(...registerables);

const { dataX, dataY } = defineProps({
    dataX: {
        type: Array,
        default: () => ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        description: "Data para el eje X",
    },
    dataY: {
        type: Array,
        default: () => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        description: "Data para el eje Y",
    },
});

// referencia del chart
const barChartRef = ref();

// data reactive chart
const chartData = reactive({
    labels: dataX,
    datasets: [
        {
            data: dataY,
            backgroundColor: [
                "#845ec2",
                "#d65db1",
                "#ff6f91",
                "#ff9671",
                "#ffc75f",
                "#f9f871",
                "#a9d271",
                "#6ab9c6",
                "#3c8dbc",
                "#0969b0",
                "#1a355f",
                "#2e1c44",
            ],
        },
    ],
});

// config - options
const options = ref({
    responsive: true,
    scales: {
        y: {
            beginAtZero: true,
        },
    },
    plugins: {
        zoom: {
            zoom: {
                wheel: {
                    enabled: true,
                },
                pinch: {
                    enabled: true,
                },
                mode: "xy",
            },
        },
        legend: {
            display: false,
        },
    },
});

onMounted(() => barChartRef.value.update());
</script>
<template>
    <div
        class="bg-white rounded-lg shadow-lg border border-gray-200 py-4 px-4 w-full h-full animate-fade-in-down"
    >
        <div class="flex justify-center items-center">
            <BarChart
                :chartData="chartData"
                :options="options"
                ref="barChartRef"
                class="w-full"
            />
        </div>
    </div>
</template>
