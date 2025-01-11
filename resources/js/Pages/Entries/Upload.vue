<template>
    <Modal v-slot="{ close }">
        <div class="pt-3 pb-6 text-2xl font-bold">
            <h2>Import CSV</h2>
        </div>

        <div class="mt-6">
            <UploadCsvForm :close="close" />
        </div>
    </Modal>
</template>

<script setup>
import UploadCsvForm from "../Components/UploadCsvForm.vue";
</script>
