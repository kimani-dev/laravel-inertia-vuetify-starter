<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import gsap from "gsap";

defineProps<{
    canLogin: boolean;
    canRegister: boolean;
    laravelVersion: string;
    phpVersion: string;
}>();

const features = [
    {
        title: "Pre-built & Customizable UI with Vuetify",
        subtitle: "Beautiful Design Out of the Box",
        icon: "mdi-vuetify",
        text: "Benefit from a comprehensive library of Vuetify components that adhere to Material Design principles. Effortlessly create a modern and visually appealing user interface for your SaaS application, with extensive customization options to match your brand identity.",
    },
    {
        title: "Robust Authentication & Authorization",
        subtitle: "Secure Your Application with Granular Control",
        icon: "mdi-lock",
        text: "Implement robust user authentication with role-based permissions using our built-in features. Define user roles and assign granular permissions to control access to specific functionalities within your SaaS application, ensuring data security and a seamless user experience.",
    },
    {
        title: "Powerful & Flexible CRUD System",
        subtitle: "Manage CRUD Operations with Ease",
        icon: "mdi-database",
        text: "Skip building custom logic for Create, Read, Update, and Delete (CRUD) operations. Our template provides a powerful and adaptable CRUD layout that streamlines data management within your SaaS application. Simply define the routes and customize creation logic for your specific data models.",
    },
    {
        title: "User Logs & Activity Tracking",
        subtitle: "Monitor User Actions and System Events",
        icon: "mdi-history",
        text: "Comes with a built-in user activity log to track user actions and system events within your SaaS application. Monitor user interactions, system events, and application logs to gain insights into user behavior, troubleshoot issues, and ensure data integrity and security.",
    },
];

// transition with stagger effect
function onEnter(el: any, done: any) {
    gsap.from(el, {
        duration: 1,
        opacity: 0,
        delay: el.dataset.index * 0.15,
        onComplete: done,
    });
}
</script>

<template>
    <Head title="Welcome" />

    <v-parallax
        src="https://cdn.vuetifyjs.com/images/backgrounds/vbanner.jpg"
        gradient="to bottom, rgba(0,0,0,.4), rgba(0,0,0,.7)"
        class="align-center text-white"
        @loaded="console.log('loaded')"
    >
        <!-- Hero text start -->
        <h1 class="text-h3 text-center text-capitalize">
            Welcome to
            <span class="text-primary">the template of your dreams</span>
        </h1>
        <v-col cols="12" md="6" class="mx-auto">
            <p class="text-subtitle-1">
                Skip repetitive development tasks and
                <span class="font-weight-medium"
                    >focus on building your core business logic</span
                >. Our template provides a solid foundation specifically
                designed for
                <span class="font-weight-medium">SaaS applications</span>,
                allowing you to launch your product quicker and with minimal
                effort.
            </p>
        </v-col>
        <!-- Hero text end -->

        <!-- Auth buttons start -->
        <div class="d-flex justify-center mt-4 mr-2">
            <v-btn
                v-if="canLogin"
                variant="outlined"
                size="large"
                :href="route('login')"
                text="Log in"
                prepend-icon="mdi-login"
                class="mr-2"
            />
            <v-btn
                v-if="canRegister"
                variant="outlined"
                size="large"
                :href="route('register')"
                text="Register"
                prepend-icon="mdi-account-plus"
            />
        </div>
        <!-- Auth buttons end -->

        <!-- Features start -->
        <v-row justify="center" class="mt-10">
            <TransitionGroup :css="false" @enter="onEnter" appear>
                <v-col
                    cols="12"
                    md="5"
                    v-for="(feature, index) in features"
                    :key="index"
                    :data-index="index"
                >
                    <v-card
                        :title="feature.title"
                        :subtitle="feature.subtitle"
                        :append-icon="feature.icon"
                        theme="dark"
                        variant="tonal"
                    >
                        <template #text>
                            {{ feature.text }}
                        </template>
                    </v-card>
                </v-col>
            </TransitionGroup>
        </v-row>
        <!-- Features end -->
        <p class="text-center mt-12 text-grey-darken-2 text-capitalize">
            All rights reserved @Ithe wa Kimani 2023 -
            {{ new Date().getFullYear() }}
        </p>
    </v-parallax>
</template>
