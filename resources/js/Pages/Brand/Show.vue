<script setup>
// componentes
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
import Toast from "@/Components/custom/Toast.vue";
import DataTable from "@/Pages/Brand/partials/DataTable.vue";
import BrandListCard from "@/Pages/Brand/partials/BrandListCard.vue";
import BrandingCardWithChartAndFilter from "@/Pages/Chart/partials/BrandingCardWithChartAndFilter.vue";
import BrandCardWithBarChartsAndFilters from "@/Pages/Chart/partials/BrandCardWithBarChartsAndFilters.vue";

// utils
import toast from "@/utils/toastMessage.js";
import pathLogo from "@/utils/pathLogos.js";
import { onMounted, reactive, ref } from "vue";
import { randomKey } from "@/utils/functions";

// props
const { brand, brands, sumAllSales } = defineProps({
    brand: {
        type: Object,
        description: "La marca asociada a la venta",
    },
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
 */
const objBrand = reactive({
    brands,
    brand,
    sumAllSales: sumAllSales,
    dataY: brand.sumSalesByMonth,
    selectedYear: new Date().getFullYear(),
});

/**
 * Función que se ejecuta al iniciar la página
 */
onMounted(() => {
    objBrand.brands = randomKey(brands);
});

// generar un array de años desde el año 2022
const years = ref(Array.from(Array(20), (_, i) => i + 2022));

/**
 * Filtra la suma de las ventas por marca y año seleccionado
 *
 * @param {Number} Year -           año seleccionado
 */
const setFilterBarChartForYear = async (year) => {
    try {
        // data
        const data = await axios.get(
            route("brands.data.dateYear", { brand: brand.id, year })
        );

        // const radomKeyData = await randomKey(data.data);
        objBrand.selectedYear = year;

        // setear los datos
        objBrand.dataY = data.data.sumSalesByMonth;
    } catch (error) {
        console.log(error);
    }
};

/**
 * Filtra los datos según sea su tipo
 * Ya sea por dia, mes o año
 *
 * @param {HTMLBaseElement} event - el elemento que dispara el evento
 * @param {Number} type -           el tipo de filtro a ejecutar
 */
const setFilterChart = async (event, type) => {
    try {
        // data
        const data = await axios.get(route("brands.data.date", type));

        // generar random key para mejorar la reactividad del chart
        // nota: no es necesario hacerlo con todos
        // solo con la marca actual seleccionada
        const radomKeyData = await randomKey(data.data);

        // sumar el monto total de ventas de todas las marcas
        objBrand.sumAllSales = await data.data.reduce(
            (total, brand) => total + brand.sumSales,
            0
        );

        // actualizar los datos de las marca actualmente seleccionada
        objBrand.brand = await data.data.find(
            (brandFind) => brandFind.id === brand.id
        );
    } catch (error) {
        console.log(error);
    }
};
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
                <!-- sub-header marca -->
                <div
                    class="inline-flex items-center justify-start mb-6 pb-6 border-b-2 border-blue-sales-1 w-full"
                >
                    <img
                        class="w-20 h-20 rounded-full shadow-lg mr-4"
                        :src="pathLogo + brand.logo"
                        alt="Logo Marca"
                    />
                    <h2
                        class="text-blue-sales-1 text-3xl text-center font-semibold tracking-wide uppercase"
                    >
                        {{ brand.name }}
                    </h2>
                </div>
                <div class="mb-6 rounded-lg border border-gray-200 w-full p-4">
                    <div class="text-blue-sales-1 text-xl tracking-wide font-light">Link para ventas</div>
                    <a :href="route('sales.createWithBrand', brand.slug)" class="opacity-70 no-underline hover:text-blue-sales-1 hover:border-gray-300">
                        {{ route('sales.createWithBrand', brand.slug) }}
                    </a>
                </div>
                <!-- /sub-header marca -->

                <!-- Gráficos -->
                <div class="mx-auto mb-6">
                    <div class="lg:flex items-stretch gap-4">
                        <div class="lg:w-[70%]">
                            <div class="block bg-white overflow-hidden h-full">
                                <div class="w-full mb-4">
                                    <h3
                                        class="text-blue-sales-1 text-2xl text-left font-semibold tracking-wide flex items-center justify-between"
                                    >
                                        <div class="inline-flex items-center">
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-6 w-6"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"
                                                />
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"
                                                />
                                            </svg>
                                            <span class="ml-1">
                                                Gráfico de ventas
                                            </span>
                                        </div>
                                        <div>
                                            <select
                                                @change="
                                                    setFilterBarChartForYear(
                                                        $event.target.value
                                                    )
                                                "
                                                v-model="objBrand.selectedYear"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                            >
                                                <option
                                                    v-for="(
                                                        year, index
                                                    ) in years"
                                                    :key="index"
                                                    :value="year"
                                                >
                                                    {{ year }}
                                                </option>
                                            </select>
                                        </div>
                                    </h3>
                                </div>
                                <BrandCardWithBarChartsAndFilters
                                    :dataY="objBrand.dataY"
                                    :key="objBrand.selectedYear"
                                />
                            </div>
                        </div>

                        <div class="lg:w-[30%]">
                            <div class="block bg-white overflow-hidden h-full w-full">
                                <BrandingCardWithChartAndFilter
                                    :brand="objBrand.brand"
                                    :key="objBrand.brand.randomKey"
                                    :sum-all-sales="objBrand.sumAllSales"
                                    @set-filter-chart="setFilterChart"
                                    class=""
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Gráficos -->

                <!-- Tabla y marcas -->
                <div class="w-full mb-4">
                    <h3
                        class="text-blue-sales-1 text-2xl text-left font-semibold tracking-wide inline-flex items-center"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                            />
                        </svg>
                        <span class="ml-1">Reporte</span>
                    </h3>
                </div>
                <div class="lg:flex">
                    <!-- tabla de datos -->
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
                <!-- /Tabla y marcas -->
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
