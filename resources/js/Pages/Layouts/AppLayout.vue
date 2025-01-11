<template>
    <div class="bg-white">
        <Navbar></Navbar>
    </div>

    <header>
        <slot name="header"></slot>
    </header>

    <main class="container mx-auto px-8">
        <UploadsCountBanner :count="uploadsCount" />

        <slot></slot>
    </main>
</template>

<script setup>
import Navbar from "./Shared/Navbar.vue";
import UploadsCountBanner from "../Components/UploadsCountBanner.vue";
import { usePage } from "@inertiajs/vue3";
import { ref } from "vue";

const page = usePage();

const uploadsCount = ref(0);

Echo.private(`user.${page.props.user_id}`).listen(
    "EntriesImportStarted",
    (event) => {
        uploadsCount.value = event.count;
    },
);

Echo.private(`user.${page.props.user_id}`).listen(
    "EntriesImportFinished",
    () => (uploadsCount.value = 0),
);
</script>
