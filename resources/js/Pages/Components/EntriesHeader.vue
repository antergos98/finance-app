<template>
    <div class="mb-12 py-6 bg-gray-800">
        <div class="container mx-auto flex px-8">
            <div class="my-auto text-white flex flex-grow items-center">
                <h1 class="md:block hidden mr-4 text-2xl font-bold">
                    Your Balance
                </h1>

                <div class="flex flex-row grow">
                    <button
                        :disabled="importingEntries"
                        :class="{ 'cursor-not-allowed': importingEntries }"
                        @click="openAddEntryModal"
                        class="flex items-center mr-4 px-3 py-2 bg-blue-700 rounded-md text-white text-xs font-bold uppercase tracking-tight"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="size-6 mr-2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 4.5v15m7.5-7.5h-15"
                            />
                        </svg>
                        Add Entry
                    </button>

                    <button
                        :disabled="importingEntries"
                        :class="{ 'cursor-not-allowed': importingEntries }"
                        @click="openImportEntriesModal"
                        class="flex items-center mr-4 px-3 py-2 bg-blue-700 rounded-md text-white text-xs font-bold uppercase tracking-tight"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="size-6 mr-2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"
                            />
                        </svg>

                        Import CSV
                    </button>
                </div>
            </div>
            <div
                class="my-auto text-right font-bold text-xs uppercase tracking-tight leading-7 text-gray-400"
            >
                Total Balance
                <div class="text-3xl font-normal">
                    <Amount :value="totalBalance" />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import Amount from "./Amount.vue";
import { usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import { visitModal } from "@inertiaui/modal-vue";

const props = defineProps(["totalBalance"]);
const page = usePage();

function openAddEntryModal() {
    visitModal("/entries/create", {
        config: {
            closeButton: false,
            maxWidth: "3xl",
        },
    });
}

function openImportEntriesModal() {
    visitModal("/entries/upload", {
        config: {
            closeButton: false,
            maxWidth: "3xl",
        },
    });
}

const importingEntries = ref(false);

Echo.private(`user.${page.props.user_id}`).listen(
    "EntriesImportStarted",
    (event) => {
        importingEntries.value = true;
    },
);

Echo.private(`user.${page.props.user_id}`).listen(
    "EntriesImportFinished",
    () => (importingEntries.value = false),
);
</script>
