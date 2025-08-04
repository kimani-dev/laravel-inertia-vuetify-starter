<script setup lang="ts">
import CTA from "@/Components/landing/CTA.vue";
import Demo from "@/Components/landing/Demo.vue";
import Features from "@/Components/landing/Features.vue";
import Footer from "@/Components/landing/Footer.vue";
import Header from "@/Components/landing/Header.vue";
import Hero from "@/Components/landing/Hero.vue";
import Pricing from "@/Components/landing/Pricing.vue";
import SampleCode from "@/Components/landing/SampleCode.vue";
import { Head } from "@inertiajs/vue3";

defineProps<{
    canLogin: boolean;
    canRegister: boolean;
    laravelVersion: string;
    phpVersion: string;
}>();
</script>

<template>
    <Head title="Welcome" />

    <v-layout>
        <v-app>
            <!-- app bar -->
            <Header />

            <v-responsive
                :max-width="$vuetify.display.xlAndUp ? 1300 : '100%'"
                :class="
                    $vuetify.display.xlAndUp
                        ? 'align-centerfill-height mx-auto'
                        : ''
                "
            >
                <v-main>
                    <!-- hero -->
                    <Hero />

                    <!-- features -->
                    <Features />

                    <!-- demo -->
                    <Demo />

                    <!-- sample -->
                    <SampleCode />

                    <!-- pricing -->
                    <Pricing />

                    <!-- CTA -->
                    <CTA />
                </v-main>
            </v-responsive>

            <!-- footer -->
            <Footer />
        </v-app>
    </v-layout>
</template>

<style>
.bg-custom {
    background-image: linear-gradient(to right, #a855f7, #ec4899);
    color: white;
}

.text-custom {
    background-image: linear-gradient(to right, #a855f7, #ec4899);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    color: transparent;
}
</style>
