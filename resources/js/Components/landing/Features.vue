<script setup lang="ts">
const features = [
    {
        color: "custom",
        icon: "mdi-lock-outline",
        title: "Complete Authentication",
        text: "Normal and social authentication with role-based permissions system built-in.",
    },
    {
        color: "info",
        icon: "mdi-vuetify",
        title: "Vuetify Integration",
        text: "Beautiful Material Design components with Vue 3 and full customization support.",
    },
    {
        color: "success",
        icon: "mdi-message-outline",
        title: "Smart Notifications",
        text: "Toast notifications, email alerts, and in-app messaging with queue support.",
    },
    {
        color: "warning",
        icon: "mdi-file-chart-outline",
        title: "IndexView Component",
        text: "Reusable data tables with filtering, searching, export, and pagination built-in.",
    },
    {
        color: "error",
        icon: "mdi-heart-outline",
        title: "Queue Management",
        text: "Background job processing with Redis/Database queues pre-configured.",
    },
    {
        color: "primary",
        icon: "mdi-flash",
        title: "Flash Messages",
        text: "Beautiful toast notifications with helper classes and automatic color coding.",
    },
];
</script>

<template>
    <h2 class="text-h3 text-custom text-center mt-10 font-weight-bold">
        Everything you need, out of the box.
    </h2>
    <p class="mt-2 text-h6 font-weight-regular w-50 mx-auto text-center">
        Stop reinventing the wheel. Focus on your unique features while we
        handle the foundation.
    </p>

    <v-container class="mt-5">
        <v-row>
            <v-col v-for="feature in features" cols="4">
                <v-card variant="tonal" class="pa-2">
                    <template #prepend>
                        <v-avatar :class="`bg-${feature.color}`" tile rounded>
                            <v-icon :icon="feature.icon" color="" />
                        </v-avatar>
                    </template>
                    <template #text>
                        <h6 class="text-subtitle-1 font-weight-bold">
                            {{ feature.title }}
                        </h6>
                        <p class="text-subtitle-2">
                            {{ feature.text }}
                        </p>
                    </template>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
