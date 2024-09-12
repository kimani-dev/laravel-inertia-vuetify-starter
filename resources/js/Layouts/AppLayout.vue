<script setup lang="ts">
import { ref, watch } from "vue";
import { Head, router, usePage } from "@inertiajs/vue3";

import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

import AppBar from "@/Components/AppBar.vue";

defineProps<{
    title: string;
}>();

const loading = ref(false);

// show loading screen only when request takes more than 250ms
let timeout: number | null = null;
router.on("start", () => {
    timeout = setTimeout(() => {
        loading.value = true;
    }, 250);
});

router.on("finish", () => {
    if (timeout) clearTimeout(timeout);
    loading.value = false;
});

watch(
    () => (usePage() as any).props.flash,
    ({ type, message }) => {
        if (type && message) {
            toast(message, {
                theme: "colored",
                type,
                transition: "slide",
                delay: 3000,
            });
        }
    }
);
</script>

<template>
    <v-responsive>
        <v-app>
            <!-- loading overlay -->
            <v-overlay
                :model-value="loading"
                class="align-center justify-center"
            >
                <v-progress-circular indeterminate color="primary" size="70">
                    <v-icon icon="mdi-laravel" />
                </v-progress-circular>
            </v-overlay>

            <!-- app bar -->
            <AppBar />

            <!-- page header -->
            <Head :title="title" />

            <!-- main content -->
            <v-main>
                <div class="ma-2">
                    <slot />
                </div>
            </v-main>
        </v-app>
    </v-responsive>
</template>
