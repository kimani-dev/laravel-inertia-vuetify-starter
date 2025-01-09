<script setup lang="ts">
import { ref } from "vue";
import { Head, useForm } from "@inertiajs/vue3";
import AppCustomLogo from "@/Components/AppCustomLogo.vue";

defineProps<{
    title: string;
}>();

const carouselItems = [
    {
        title: "Seamless Authentication",
        subtitle: "Email and Social Login Made Easy",
        description:
            "Enjoy secure and effortless authentication with support for email and popular social platforms.",
        children: [
            "Email-based authentication with password recovery.",
            "Social login support (Google, Facebook, and more).",
            "Robust security with token-based authentication.",
        ],
    },
    {
        title: "Beautifully Crafted with Vuetify",
        subtitle: "Material Design at Its Best",
        description:
            "Build stunning, responsive, and user-friendly interfaces powered by Vuetify, the ultimate Material Design framework.",
        children: [
            "Pre-built Material Design components for fast development.",
            "Fully responsive layouts for all devices.",
            "Customizable themes to match your branding.",
        ],
    },
    {
        title: "Cutting-Edge Technologies",
        subtitle: "Powered by the Latest Stack",
        description:
            "Leverage the newest Laravel, Vue, Vuetify, and Inertia to deliver modern, scalable web applications.",
        children: [
            "Built with Laravel 11 for secure and scalable backends.",
            "Vue 3 and Inertia.js for seamless front-end and back-end integration.",
            "Vuetify for modern Material Design interfaces.",
        ],
    },
];
</script>

<template>
    <Head :title />

    <v-container fluid class="bg-background pa-0 ma-0" style="height: 100vh">
        <v-row class="fill-height" justify="center" no-gutters>
            <v-col cols="12" md="7" align-self="center">
                <slot />
            </v-col>

            <!--  welcome image and carousel -->
            <v-col
                cols="12"
                md="5"
                class="d-flex flex-column justify-center bg-background elevation-1"
            >
                <div>
                    <v-img
                        src="/assets/illustrations/login.svg"
                        width="400"
                        class="mx-auto"
                    />
                </div>
                <v-carousel
                    class="mt-10"
                    :show-arrows="false"
                    hide-delimiter-background
                    color="primary"
                    cycle
                    interval="4000"
                    height="300"
                >
                    <v-carousel-item
                        v-for="item in carouselItems"
                        :key="item.title"
                    >
                        <v-card
                            flat
                            color="transparent"
                            :title="item.title"
                            :subtitle="item.subtitle"
                        >
                            <template #text>
                                <v-list-item
                                    v-for="child in item.children"
                                    :key="child"
                                    :title="child"
                                    prepend-icon="mdi-check-circle"
                                />
                            </template>
                        </v-card>
                    </v-carousel-item>
                </v-carousel>
            </v-col>
        </v-row>
    </v-container>
</template>
