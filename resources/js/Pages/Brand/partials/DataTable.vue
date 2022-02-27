<script setup>
// componentes
import Pagination from "@/Components/custom/Pagination.vue";
import Confirm from "@/Components/custom/Confirm.vue";

// utils
import { substr, formatDateToDDMMYYYY } from "@/utils/functions.js";
import { computed, reactive, ref } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";

// path para los archivos storage
const pathVoucher = computed(() => usePage().props.value.path.saleVoucher);

// props recibidas
const { data, brand, toast } = defineProps({
    data: {
        type: Array,
        default: () => [],
    },
    brand: {
        type: Object,
        default: () => {},
    },
    toast: {
        type: Object,
        default: () => {},
    },
});

// reactives para la la ventana de confirmación
const confirm = reactive({
    show: false,
    confirm: "Si, verificar",
    info: "¿Está seguro de verificar esta venta?",
    description: "Esta acción no se puede deshacer",
    loading: false,
});

// reactive para las ventas
const sales = reactive({
    data,
});

// reactive para el paginador
const pagination = reactive({
    links: sales.data.links,
    perPage: sales.data.per_page,
    total: sales.data.total,
    currentPage: sales.data.current_page,
});

// ref
const idSales = ref(null);

// ---------------------------------------------------------------
// -------------------- funciones --------------------------------
// ---------------------------------------------------------------

/**
 * abre el modal de confirmación y "setea" el id de la venta seleccionada
 *
 * @param {Number} id - id de la venta
 */
const showConfirm = (id) => {
    idSales.value = id;
    confirm.show = true;
};

/**
 * Marca una venta como verificada
 */
const verifySale = async () => {
    try {

        confirm.loading = true;

        // verificar la venta
        // y actualiza el listado de ventas
        const res = await axios.put(
            route("sales.verify", { sale: idSales.value, brand: brand.id }),
            {
                currentPage: pagination.currentPage,
            }
        );

        // actualizar el listado de ventas
        sales.data = res.data;

        // modal de confirmación
        confirm.show = false;
        confirm.loading = false;

        // toast
        toast.message = "Venta verificada con éxito";
        toast.bg = "bg-green-600";
        toast.show = true;
        setTimeout(() => {
            toast.show = false;
        }, 5000);
    } catch (error) {
        confirm.show = false;
        confirm.loading = false;
        console.log(error);
    }
};
</script>
<template>
    <!-- modal de confirmación -->
    <Confirm
        @confirm-modal="verifySale"
        @close-confirm-modal="confirm.show = false"
        :show-confirm="confirm.show"
        :confirm-message="confirm.confirm"
        :info-message="confirm.info"
        :description-message="confirm.description"
        :loading="confirm.loading"
    />
    <!-- /modal de confirmación -->

    <!-- tabla de datos -->
    <div>
        <table
            class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700"
        >
            <thead class="bg-gray-100 dark:bg-gray-700 text-center">
                <tr>
                    <th
                        scope="col"
                        class="py-3 px-6 text-xs font-medium tracking-wider text-gray-700 uppercase dark:text-gray-400"
                    >
                        Servicio
                    </th>
                    <th
                        scope="col"
                        class="py-3 px-6 text-xs font-medium tracking-wider text-gray-700 uppercase dark:text-gray-400"
                    >
                        Cantidad
                    </th>
                    <th
                        scope="col"
                        class="py-3 px-6 text-xs font-medium tracking-wider text-gray-700 uppercase dark:text-gray-400"
                    >
                        Monto
                    </th>
                    <th
                        scope="col"
                        class="py-3 px-6 text-xs font-medium tracking-wider text-gray-700 uppercase dark:text-gray-400"
                    >
                        Comprobante
                    </th>
                    <th
                        scope="col"
                        class="py-3 px-6 text-xs font-medium tracking-wider text-gray-700 uppercase dark:text-gray-400"
                    >
                        Status
                    </th>
                    <th scope="col" class="p-4">
                        <span class="sr-only"> Verificación </span>
                    </th>
                </tr>
            </thead>
            <tbody
                class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700 text-center"
            >
                <tr>
                    <td colspan="6" v-if="!sales.data.data.length">
                        <div class="text-center py-3">
                            <h2
                                class="text-gray-900 text-base font-semibold text-center"
                            >
                                No hay ventas
                            </h2>
                        </div>
                    </td>
                </tr>
                <tr
                    class="hover:bg-gray-100 dark:hover:bg-gray-700"
                    v-for="sale in sales.data.data"
                    :key="sale.id"
                >
                    <td
                        class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"
                    >
                        {{ sale.service }}
                    </td>
                    <td
                        class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white"
                    >
                        {{ sale.count }}
                    </td>
                    <td
                        class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"
                    >
                        {{ sale.usd_amount }}
                    </td>
                    <td
                        class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"
                    >
                        <span
                            v-if="sale.voucher"
                            class="text-blue-400 flex justify-center"
                        >
                            <a
                                :href="pathVoucher + sale.voucher"
                                download
                                target="_blank"
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
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"
                                    />
                                </svg>
                            </a>
                        </span>
                        <span v-else class="text-red-400 flex justify-center">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </span>
                    </td>
                    <td
                        class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"
                    >
                        <span v-if="sale.isVerified" class="text-green-400">
                            Activo -
                            {{ formatDateToDDMMYYYY(sale.verified_at) }}
                        </span>
                        <span v-else class="text-red-400"> Pendiente </span>
                    </td>
                    <td
                        class="py-4 px-6 text-sm font-medium text-right whitespace-nowrap"
                    >
                        <button
                            :disabled="sale.isVerified"
                            :class="
                                sale.isVerified
                                    ? 'bg-gray-200 text-gray-900'
                                    : 'bg-gray-200 hover:text-blue-800 hover:bg-gray-300 text-blue-600'
                            "
                            @click="showConfirm(sale.id)"
                            class="rounded-lg px-4 py-2"
                        >
                            <span v-if="!sale.isVerified">Verificación</span>
                            <span v-else> Verificado </span>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <Pagination
            class="mt-4 flex justify-center"
            :links="pagination.links"
            :per-page="pagination.perPage"
            :total="pagination.total"
            :current-page="pagination.currentPage"
            @change-current-page="pagination.currentPage = $event"
        />
    </div>
</template>
