<script setup lang="ts">
import AppCustomLogo from "@/Components/AppCustomLogo.vue";
</script>

<template>
    <v-footer class="mt-15">
        <v-container>
            <v-divider class="my-10" />
            <v-row>
                <v-col cols="12" md="3">
                    <AppCustomLogo />
                    <p class="mt-8 text-subtitle-1">
                        The ultimate Laravel + Vue starter kit for modern web
                        applications.
                    </p>
                    <div class="d-flex ga-2 align-center mt-5">
                        <v-icon icon="mdi-twitter" />
                        <v-icon icon="mdi-pinterest" />
                        <v-icon icon="mdi-github" />
                    </div>
                </v-col>
                <v-col cols="12" md="3">
                    <p class="text-subtitle-1 font-weight-bold">Product</p>
                    <p class="text-subtitle-1 mt-4">Features</p>
                    <p class="text-subtitle-1 mt-2">Demo</p>
                    <p class="text-subtitle-1 mt-2">Pricing</p>
                    <p class="text-subtitle-1 mt-2">Changelog</p>
                </v-col>
                <v-col cols="12" md="3">
                    <p class="text-subtitle-1 font-weight-bold">Resources</p>
                    <p class="text-subtitle-1 mt-4">Documentation</p>
                    <p class="text-subtitle-1 mt-2">API Reference</p>
                    <p class="text-subtitle-1 mt-2">Examples</p>
                    <p class="text-subtitle-1 mt-2">Blogs</p>
                </v-col>
                <v-col cols="12" md="3">
                    <p class="text-subtitle-1 font-weight-bold">Support</p>
                    <p class="text-subtitle-1 mt-4">Help Center</p>
                    <p class="text-subtitle-1 mt-2">Community</p>
                    <p class="text-subtitle-1 mt-2">Contact</p>
                    <p class="text-subtitle-1 mt-2">Status</p>
                </v-col>
            </v-row>

            <v-divider class="my-5" />

            <div class="py-4 d-flex justify-space-between align-center">
                &copy; {{ new Date().getFullYear() }} LaraVue Kit. All Rights
                Reserved.

                <div class="d-flex ga-2 align-center">
                    <p class="text-subtitle-1">Privacy Policy</p>
                    <p class="text-subtitle-1">Terms of Service</p>
                    <p class="text-subtitle-1">License</p>
                </div>
            </div>
        </v-container>
    </v-footer>
</template>
