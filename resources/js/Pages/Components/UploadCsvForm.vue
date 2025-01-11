<script setup>
const props = defineProps(["close"]);
import { useForm, router } from "@inertiajs/vue3";

const form = useForm({
    file: null,
});

const submit = () => {
    router.post("/entries/upload", form, {
        onSuccess: () => props.close(),
    });
};
</script>

<template>
    <form @submit.prevent="submit">
        <div class="w-full">
            <label
                for="label"
                class="block text-sm uppercase font-bold text-gray-600"
                >.CSV File</label
            >
            <div class="mt-2">
                <input
                    @input="form.file = $event.target.files[0]"
                    type="file"
                    accept=".csv"
                    class="w-full rounded-md border-2 p-2 border-gray-300"
                />
            </div>
        </div>

        <div class="mt-12">
            <div @click="close" class="flex justify-end space-x-4">
                <button
                    class="flex items-center px-10 py-4 transition bg-blue-100 text-slate-500 hover:bg-blue-200 hover:shadow-sm rounded-md font-bold uppercase tracking-tight"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    class="flex items-center px-10 py-4 transition bg-blue-600 hover:bg-blue-700 hover:shadow-sm rounded-md text-white font-bold uppercase tracking-tight"
                >
                    Import
                </button>
            </div>
        </div>
    </form>
</template>
