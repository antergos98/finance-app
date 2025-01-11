<template>
    <div :class="cssClass">
        <span v-if="prefix">{{ prefix }}</span>
        <span v-html="formattedAmount"></span>
    </div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps(["value", "class"]);

const prefix = computed(() => {
    if (props.value > 0) {
        return "+";
    }

    if (props.value === 0) {
        return "";
    }

    return "-";
});

const formattedAmount = computed(() => {
    let value = new Intl.NumberFormat("en-CA", {
        style: "currency",
        currency: "CAD",
    }).format(Math.abs(props.value));
    const [whole, cents] = value.split(".");

    return `${whole}.<span class="text-sm">${cents}</span>`;
});

const cssClass = computed(() => {
    if (props.value > 0) {
        return "text-green-500";
    }

    return "text-gray-500";
});
</script>
