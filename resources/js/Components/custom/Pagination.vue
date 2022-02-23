<template>
    <div v-if="total > perPage">
        <div class="flex flex-wrap">
            <template v-for="(link, p) in links" :key="p">
                <div
                    v-if="link.url === null"
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                    v-html="link.label"
                />
                <Link
                    v-else
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500"
                    :class="{
                        'bg-blue-700 hover:bg-blue-800 text-white': parseInt(link.label) === currentPage
                    }"
                    :href="link.url"
                    v-html="link.label"
                    @click="$emit('change-current-page', p)"
                />
            </template>
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/inertia-vue3";
const { links, perPage, total, currentPage } = defineProps({
    links: {
        type: Array,
        default: () => [],
    },
    perPage: {
        type: Number,
        default: 5,
    },
    total: {
        type: Number,
        default: 0,
    },
    currentPage: {
        type: Number,
        default: 1,
    },
});
</script>
