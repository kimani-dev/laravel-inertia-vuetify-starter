<script setup>
import { ref } from "vue";
import { Head, router, usePage } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

import AppBar from "@/Components/AppBar.vue";
import { computed } from "vue";
import { watch } from "vue";

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

watch(
    () => usePage().props.flash,
    ({ type, message }) => {
        if (type && message) {
            toast(message, {
                theme: "colored",
                type,
                transition: "slide",
                timer: 3000,
            });
        }
    }
);
</script>

<template>
    <div>
        <Head :title="title" />
        <v-container fluid class="pa-0 pa-md-2">
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
