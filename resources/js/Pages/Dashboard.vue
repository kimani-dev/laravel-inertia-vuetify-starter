<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { computed } from "vue";

const greeting = computed(() => {
    const date = new Date();
    const hours = date.getHours();
    if (hours < 12) return "Good Morning";
    if (hours < 18) return "Good Afternoon";
    return "Good Evening";
});
</script>

<template>
    <AppLayout title="Dashboard">
        <v-container fluid>
            <v-row>
                <v-col>
                    <h1 class="text-h5">{{ `${greeting}, ${$page.props.auth.user.name}` }}</h1>
                </v-col>
            </v-row>
        </v-container>
    </AppLayout>
</template>
