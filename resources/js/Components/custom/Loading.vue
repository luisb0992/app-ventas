<script setup>
defineProps({
    bg: {
        type: String,
        default: "bg-blue-sales-1",
        description: "color de fondo",
    },
    width: {
        type: String,
        default: "w-20",
        description: "ancho del componente",
    },
    height: {
        type: String,
        default: "h-20",
        description: "alto del componente",
    },
});
</script>
<template>
    <div class="text-center">
        <div class="lds-ripple" :class="width+' '+height">
            <div :class="bg"></div>
            <div :class="bg"></div>
        </div>
    </div>
</template>

<style scoped>
.lds-ripple {
    display: inline-block;
    position: relative;
}
.lds-ripple div {
    position: absolute;
    border: 4px solid;
    opacity: 1;
    border-radius: 50%;
    animation: lds-ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
}
.lds-ripple div:nth-child(2) {
    animation-delay: -0.5s;
}
@keyframes lds-ripple {
    0% {
        top: 36px;
        left: 36px;
        width: 0;
        height: 0;
        opacity: 1;
    }
    100% {
        top: 0px;
        left: 0px;
        width: 72px;
        height: 72px;
        opacity: 0;
    }
}
</style>
