<template>
    <div class="rounded-md shadow-md bg-white mb-4">
        <div class="flex group items-center mb-4 px-4 py-2 cursor-pointer">
            <div class="flex-grow">
                <div class="font-bold">
                    {{ entry.label }}
                </div>
                <div class="text-xs text-gray-500">
                    {{ entry.friendly_date }}
                </div>
            </div>

            <div class="space-x-3 hidden group-hover:block mr-20">
                <button
                    @click="editMode = !editMode"
                    class="text-blue-700 font-semibold underline"
                >
                    EDIT
                </button>
                <button
                    class="text-blue-700 font-semibold underline"
                    @click="confirmDelete"
                >
                    DELETE
                </button>
            </div>

            <div class="text-lg font-bold">
                <Amount :value="entry.amount" />
            </div>
        </div>

        <div v-show="editMode" class="bg-white rounded-md px-4 pb-8">
            <div class="border mb-6 border-gray-300 -mx-4"></div>
            <EntryForm
                @cancel="editMode = false"
                @submit="editMode = false"
                :entry="entry"
            />
        </div>
    </div>
</template>

<script setup>
import { router } from "@inertiajs/vue3";
import Amount from "./Amount.vue";
import EntryForm from "../components/EntryForm.vue";
import { ref } from "vue";

const props = defineProps(["entry"]);

const editMode = ref(false);

function confirmDelete() {
    if (window.confirm("Are you sure?")) {
        router.visit(`/entries/${props.entry.id}`, {
            method: "DELETE",
        });
    }
}
</script>
