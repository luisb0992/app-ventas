<script setup>
// componentes
// import BreezeGuestLayout from "@/Layouts/Guest.vue";
// import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import Toast from "@/Components/custom/Toast.vue";
import Loading from "@/Components/custom/Loading.vue";
import MessageFailed from "@/Components/custom/MessageFailed.vue";
import Confirm from "@/Components/custom/Confirm.vue";
import Pagination from "@/Components/custom/Pagination.vue";
import { Link } from "@inertiajs/inertia-vue3";

// utils path para el logo de la marca
// import pathLogos from "@/utils/pathLogos.js";
import { substr, formatDateToDDMMYYYY } from "@/utils/functions.js";

// manipular los mensajes toast
import toast from "@/utils/toastMessage.js";

// utils
import { computed, reactive, ref } from "@vue/runtime-core";
import { usePage } from "@inertiajs/inertia-vue3";

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

// path para los archivos storage
const pathVoucher = computed(() => usePage().props.value.path.saleVoucher);
const pathLogo = computed(() => usePage().props.value.path.brandLogo);

// ref
const idSales = ref(null);

// reactive
const pagination = reactive({
    links: brand.paginateSales.links,
    perPage: brand.paginateSales.per_page,
    total: brand.paginateSales.total,
    currentPage: brand.paginateSales.current_page,
});
const confirm = reactive({
    show: false,
    confirm: "Si, verificar",
    info: "¿Está seguro de verificar esta venta?",
    description: "Esta acción no se puede deshacer",
});

// funciones
const showConfirm = (id) => {
    idSales.value = id;
    confirm.show = true;
};


/**
 * Marca una venta como verificada
 */
const verifySale = async () => {
    try {
        // verificar la venta
        // y actualiza el listado de ventas
        const data = await axios.put(
            route("sales.verify", { sale: idSales.value, brand: brand.id }),
            {
                currentPage: pagination.currentPage,
            }
        );

        // actualizar el listado de ventas
        brand.paginateSales = data.data;

        confirm.show = false;
        toast.message = "Venta verificada con éxito";
        toast.bg = "bg-green-600";
        toast.show = true;
        setTimeout(() => {
            toast.show = false;
        }, 5000);
    } catch (error) {
        confirm.show = false;
        console.log(error);
    }
};
</script>
<template>
    <BreezeAuthenticatedLayout>
        <Head title="Marca" />

        <Toast
            @close-toast="toast.show = false"
            :message="toast.message"
            :bg="toast.bg"
            :show="toast.show"
        />

        <Confirm
            @confirm-modal="verifySale"
            @close-confirm-modal="confirm.show = false"
            :show-confirm="confirm.show"
            :confirm-message="confirm.confirm"
            :info-message="confirm.info"
            :description-message="confirm.description"
        />

        <MessageFailed
            class="mb-4 bg-red-600 border border-red-500 text-gray-100 rounded-lg py-6 px-4 inline-flex items-center"
            :failed="failed"
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
                                        <table
                                            class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700"
                                        >
                                            <thead
                                                class="bg-gray-100 dark:bg-gray-700 text-center"
                                            >
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
                                                        <span class="sr-only">
                                                            Verificación
                                                        </span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody
                                                class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700 text-center"
                                            >
                                                <tr>
                                                    <td
                                                        colspan="6"
                                                        v-if="
                                                            !brand.sales.length
                                                        "
                                                    >
                                                        <div
                                                            class="text-center py-3"
                                                        >
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
                                                    v-for="sale in brand
                                                        .paginateSales.data"
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
                                                                :href="
                                                                    pathVoucher +
                                                                    sale.voucher
                                                                "
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
                                                        <span
                                                            v-else
                                                            class="text-red-400 flex justify-center"
                                                        >
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
                                                        <span
                                                            v-if="
                                                                sale.isVerified
                                                            "
                                                            class="text-green-400"
                                                        >
                                                            Activo -
                                                            {{
                                                                formatDateToDDMMYYYY(
                                                                    sale.verified_at
                                                                )
                                                            }}
                                                        </span>
                                                        <span
                                                            v-else
                                                            class="text-red-400"
                                                        >
                                                            Pendiente
                                                        </span>
                                                    </td>
                                                    <td
                                                        class="py-4 px-6 text-sm font-medium text-right whitespace-nowrap"
                                                    >
                                                        <button
                                                            :disabled="
                                                                sale.isVerified
                                                            "
                                                            :class="
                                                                sale.isVerified
                                                                    ? 'bg-gray-200 text-gray-900'
                                                                    : 'bg-gray-200 hover:text-blue-800 hover:bg-gray-300 text-blue-600'
                                                            "
                                                            @click="
                                                                showConfirm(
                                                                    sale.id
                                                                )
                                                            "
                                                            class="rounded-lg px-4 py-2"
                                                        >
                                                            <span
                                                                v-if="
                                                                    !sale.isVerified
                                                                "
                                                                >Verificación</span
                                                            >
                                                            <span v-else>
                                                                Verificado
                                                            </span>
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
                                            :current-page="
                                                pagination.currentPage
                                            "
                                            @change-current-page="pagination.currentPage = $event"
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
                        <div
                            class="bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700 py-8 w-full mb-3 mx-auto animate-fade-in-down"
                            v-for="brand in brands"
                            :key="brand.id"
                        >
                            <div class="flex justify-center">
                                <Link
                                    :href="route('brands.show', brand.id)"
                                    class="lg:inline-flex items-center border-indigo-400 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out"
                                >
                                    <img
                                        class="w-24 h-24 rounded-full shadow-lg lg:mr-4 mb-3 lg:mb-0"
                                        :src="pathLogo + brand.logo"
                                        alt="Logo Marca"
                                    />
                                    <h3
                                        class="text-gray-900 dark:text-white font-medium sm:hidden xl:block text-xl xl:text-lg text-center hover:text-blue-sales-1"
                                    >
                                        {{ substr(brand.name) }}
                                    </h3>
                                </Link>
                            </div>
                        </div>
                    </div>
                    <!-- /listado de marcas -->
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
