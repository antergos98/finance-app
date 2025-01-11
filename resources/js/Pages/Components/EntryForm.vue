<template>
    <form @submit.prevent="submit">
        <div class="flex flex-row shrink-0 gap-x-3">
            <div class="w-full">
                <label
                    for="label"
                    class="block text-sm uppercase font-bold text-gray-600"
                    >Label</label
                >
                <div class="mt-2">
                    <input
                        v-model="form.label"
                        type="text"
                        class="w-full rounded-md border-2 border-gray-300"
                        autofocus
                        required
                    />
                </div>
            </div>

            <div class="w-full">
                <label
                    for="label"
                    class="block text-sm uppercase font-bold text-gray-600"
                    >Date</label
                >
                <div class="mt-2">
                    <input
                        :value="formattedDate"
                        @input="form.date = $event.target.value"
                        type="datetime-local"
                        class="w-full rounded-md border-2 border-gray-300"
                    />
                </div>
            </div>

            <div class="w-2/3">
                <label
                    for="label"
                    class="block text-sm uppercase font-bold text-gray-600"
                    >Amount</label
                >
                <div class="mt-2 relative">
                    <span
                        class="absolute top-[10px] left-3 font-bold text-gray-400"
                        >$</span
                    >
                    <input
                        v-model="form.amount"
                        type="number"
                        width=""
                        step="0.01"
                        class="w-full rounded-md pl-7 border-2 border-gray-300"
                        required
                    />
                </div>
            </div>
        </div>

        <div class="mt-12">
            <div class="flex justify-end space-x-4">
                <button
                    @click.prevent="
                        close();
                        form.reset();
                    "
                    class="flex items-center px-10 py-4 transition bg-blue-100 text-slate-500 hover:bg-blue-200 hover:shadow-sm rounded-md font-bold uppercase tracking-tight"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    class="flex items-center px-10 py-4 transition bg-blue-600 hover:bg-blue-700 hover:shadow-sm rounded-md text-white font-bold uppercase tracking-tight"
                >
                    Save entry
                </button>
            </div>
        </div>
    </form>
</template>

<script setup>
import { router } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import { computed } from "vue";
import moment from "moment";

const props = defineProps(["entry", "close"]);

const formattedDate = computed(() => {
    if (form.date === undefined) {
        return null;
    }

    return moment(form.date).format("YYYY-MM-DDTHH:mm");
});

const form = useForm({
    label: props.entry?.label,
    date: props.entry?.date,
    amount: props.entry?.amount,
});

function submit() {
    if (typeof props.entry === "object") {
        router.patch(`/entries/${props.entry.id}`, form, {
            onSuccess() {
                props.close();
            },
        });
        return;
    }

    router.post("/entries", form, {
        onSuccess() {
            props.close();
        },
    });
}
</script>
