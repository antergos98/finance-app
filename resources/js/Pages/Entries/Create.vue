<template>
    <Modal v-slot="{ close }">
        <div class="pt-3 pb-6 text-2xl font-bold">
            <h2>Add Balance Entry</h2>
        </div>

        <div class="mt-6">
            <EntryForm :close="close" />
        </div>
    </Modal>
</template>

<script setup>
import EntryForm from "../components/EntryForm.vue";
</script>
