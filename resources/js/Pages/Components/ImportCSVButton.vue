<template>
    <ModalLink
        aria-disabled="true"
        href="#import-csv"
        :close-button="false"
        max-width="3xl"
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
    </ModalLink>

    <Modal ref="modalRef" name="import-csv" v-slot="{ close }">
        <div class="pt-3 pb-6 text-2xl font-bold">
            <h2>Import CSV</h2>
        </div>

        <div class="mt-6">
            <UploadCsvForm @close="close" />
        </div>
    </Modal>
</template>

<script setup>
import UploadCsvForm from "./UploadCsvForm.vue";
import { ref } from "vue";
const modalRef = ref(null);
</script>
