<script setup>
// utils
import { ref } from "vue";
import isOpen from "@/utils/isOpen.js";
import appName from "@/utils/appName.js";
import appPages from "@/utils/appPages.js";

// componentes
import { Link, usePage } from "@inertiajs/inertia-vue3";

const activeClass = ref(
    "bg-gray-600 bg-opacity-25 text-gray-100 border-gray-100"
);
const inactiveClass = ref(
    "border-gray-900 text-gray-500 hover:bg-gray-600 hover:bg-opacity-25 hover:text-gray-100"
);

// Definir si la pagina es la activa mediante la url
const inPage = (value) => {
    const page = usePage();
    return page.url.value === value;
};

</script>

<template>
    <div class="flex">
        <!-- Backdrop -->
        <div
            :class="isOpen ? 'block' : 'hidden'"
            @click="isOpen = !isOpen"
            class="fixed inset-0 z-20 transition-opacity bg-[#004a77] opacity-50 lg:hidden"
        ></div>
        <!-- End Backdrop -->

        <!-- content -->
        <div
            :class="
                isOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'
            "
            class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-gray-900 lg:translate-x-0 lg:static lg:inset-0"
        >
            <!-- Nombre principal -->
            <div class="flex items-center justify-center mt-4 border-white border-b-2 pb-1">
                <div class="flex items-center">
                    <svg
                        class="w-12 h-12"
                        viewBox="0 0 512 512"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M364.61 390.213C304.625 450.196 207.37 450.196 147.386 390.213C117.394 360.22 102.398 320.911 102.398 281.6C102.398 242.291 117.394 202.981 147.386 172.989C147.386 230.4 153.6 281.6 230.4 307.2C230.4 256 256 102.4 294.4 76.7999C320 128 334.618 142.997 364.608 172.989C394.601 202.981 409.597 242.291 409.597 281.6C409.597 320.911 394.601 360.22 364.61 390.213Z"
                            fill="#4C51BF"
                            stroke="#4C51BF"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                        <path
                            d="M201.694 387.105C231.686 417.098 280.312 417.098 310.305 387.105C325.301 372.109 332.8 352.456 332.8 332.8C332.8 313.144 325.301 293.491 310.305 278.495C295.309 263.498 288 256 275.2 230.4C256 243.2 243.201 320 243.201 345.6C201.694 345.6 179.2 332.8 179.2 332.8C179.2 352.456 186.698 372.109 201.694 387.105Z"
                            fill="white"
                        />
                    </svg>
                    <span class="mx-2 text-2xl font-semibold text-white">
                        {{ appName }}
                    </span>
                </div>
            </div>
            <!-- /Nombre principal -->

            <!-- links -->
            <nav class="mt-10">
                <p class="flex items-center px-6 py-2 duration-200 text-white">
                    <small>Menú</small>
                </p>
                <Link
                    :href="route('dashboard')"
                    class="flex items-center px-6 py-2 mt-4 duration-200 border-l-4 text-white"
                    :class="[inPage(appPages.dashboard) ? activeClass : inactiveClass]"
                    @click="isOpen = !isOpen"
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
                            d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>
                    <span class="mx-2">Perfil</span>
                </Link>
                <Link
                    :href="route('brands.index')"
                    class="flex items-center px-6 py-2 mt-4 duration-200 border-l-4 text-white"
                    :class="[inPage(appPages.brands) ? activeClass : inactiveClass]"
                    @click="isOpen = !isOpen"
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
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
                        />
                    </svg>
                    <span class="mx-2">Marcas</span>
                </Link>
                <Link
                    :href="route('dashboard')"
                    class="flex items-center px-6 py-2 mt-4 duration-200 border-l-4 text-white"
                    :class="[inPage(appPages.graphics) ? activeClass : inactiveClass]"
                    @click="isOpen = !isOpen"
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
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                        /></svg
                    >
                    <span class="mx-2">Gráficos</span>
                </Link>
                <Link
                    :href="route('dashboard')"
                    class="flex items-center px-6 py-2 mt-4 duration-200 border-l-4 text-white"
                    :class="[inPage(appPages.sales) ? activeClass : inactiveClass]"
                    @click="isOpen = !isOpen"
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
                            d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"
                        />
                    </svg>
                    <span class="mx-2">Ventas</span>
                </Link>
            </nav>
            <!-- /links -->
        </div>
        <!-- /content -->
    </div>
</template>
