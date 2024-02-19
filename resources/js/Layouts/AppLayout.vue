<script setup>
import { ref } from "vue";
import { Head, router } from "@inertiajs/vue3";

import AppBar from "@/Components/AppBar.vue";

defineProps({
    title: String,
});

const loading = ref(false);

// show loading screen only when request takes more than 250ms
let timeout = null;
router.on("start", () => {
    timeout = setTimeout(() => {
        loading.value = true;
    }, 250);
});
router.on("finish", () => {
    clearTimeout(timeout);
    loading.value = false;
});
</script>

<template>
    <div>
        <Head :title="title" />
        <v-container fluid>
            <v-overlay
                :model-value="loading"
                class="align-center justify-center"
            >
                <v-progress-circular indeterminate color="primary" size="70">
                    <v-icon icon="mdi-laravel" />
                </v-progress-circular>
            </v-overlay>
            <v-layout>
                <AppBar />
                <v-main>
                    <v-container fluid>
                        <slot />
                    </v-container>
                </v-main>
            </v-layout>
        </v-container>
    </div>
</template>
