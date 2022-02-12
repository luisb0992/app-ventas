<script setup>
defineProps({
    appName: {
        type: String,
        default: "3j Corp",
    },
});
</script>
<template>
    <!-- navbar -->
    <div class="relative bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div
                class="flex justify-between items-center py-6 md:justify-start md:space-x-10"
            >
                <div class="flex justify-start items-center lg:w-0 lg:flex-1">
                    <a href="javascript:void()">
                        <span class="sr-only">Inicio</span>
                        <img
                            class="h-8 w-auto sm:h-10"
                            src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg"
                            alt="Logo"
                        />
                    </a>
                    <div>
                        <span
                            class="text-gray-600 ml-2 text-xl font-semibold"
                            >{{ appName }}</span
                        >
                    </div>
                </div>
            </div>
        </div>

        <!-- mobile menu -->
        <div
            class="absolute top-0 inset-x-0 transition transform origin-top-right md:hidden"
        >
            <div class="bg-white">
                <div class="pt-5 pb-6 px-5">
                    <div class="flex items-center justify-start">
                        <div>
                            <img
                                class="h-8 w-auto"
                                src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg"
                                alt="Workflow"
                            />
                        </div>
                        <div>
                            <span
                                class="text-gray-600 ml-2 text-xl font-semibold"
                                >{{ appName }}</span
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /navbar -->

    <!-- body -->
    <div
        class="min-h-[90.5vh] flex flex-col sm:justify-center items-center pt-16 sm:pt-0 bg-[#004a77]"
    >
        <div
            class="w-80 sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
    <!-- /body -->
</template>
