<template>
    <div>
        <div class="flex items-center mb-4">
            <span
                class="flex-grow text-gray-500 font-bold text-sm uppercase tracking-tight"
                >{{ title }}</span
            >
            <div class="text-lg font-bold">
                <Amount :value="balance" />
            </div>
        </div>

        <SingleEntry v-for="entry in entries" :key="entry.id" :entry="entry" />
    </div>
</template>

<script setup>
import moment from "moment";
import SingleEntry from "./SingleEntry.vue";
import Amount from "./Amount.vue";
import { computed } from "vue";

const props = defineProps(["entries"]);

const balance = computed(() => {
    return props.entries
        .map((entry) => entry.amount)
        .reduce((a, b) => a + b, 0);
});

const title = computed(() => {
    const date = moment(props.entries[0].date);

    if (date.isSame(moment(), "day")) {
        return "Today";
    } else if (date.isSame(moment().subtract("1", "days"), "day")) {
        return "Yesterday";
    }

    return date.format("ddd, D MMM");
});
</script>
