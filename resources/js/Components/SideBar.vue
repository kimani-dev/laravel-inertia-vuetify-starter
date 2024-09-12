<script setup lang="ts">
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import { useDisplay } from "vuetify";
import moment from "moment";

import AppCustomLogo from "./AppCustomLogo.vue";

defineProps<{
    drawer?: boolean;
}>();

const { mobile } = useDisplay();

// time
const time = ref(moment().format("HH:mm:ss A"));
function updateTime() {
    const date = new Date();
    let hours: number | string = date.getHours();
    let minutes: number | string = date.getMinutes();
    let seconds: number | string = date.getSeconds();
    const ampm = hours >= 12 ? "PM" : "AM";

    // Prepend zero if necessary
    hours = hours < 10 ? 0 + hours : hours;
    minutes = minutes < 10 ? "0" + minutes : minutes;
    seconds = seconds < 10 ? "0" + seconds : seconds;

    time.value = `${hours}:${minutes}:${seconds} ${ampm}`;
}
setInterval(updateTime, 1000);

// links
const links = [
    {
        title: "Home",
        children: [
            {
                title: "Dashboard",
                icon: "mdi-view-dashboard-outline",
                route: "dashboard",
            },
            {
                title: "Profile",
                icon: "mdi-account-outline",
                route: "profile.show",
            },
            {
                title: "Users",
                icon: "mdi-account-group-outline",
                route: "users.index",
            },
        ],
    },
    {
        title: "Settings",
        children: [
            {
                title: "Roles and Permissions",
                icon: "mdi-shield-account-outline",
                route: "roles.index",
            },
            {
                title: "Access Logs",
                icon: "mdi-history",
                route: "logs.index",
            },
            {
                title: "API Tokens",
                icon: "mdi-api",
                route: "api-tokens.index",
            },
        ],
    },
];

function baseRouteName(route: string) {
    // remove the last part and return the base route name
    // e.g. roles.index => roles
    return route.split(".").slice(0, -1).join(".");
}

function logout() {
    router.post(route("logout"));
}
</script>

<template>
    <v-navigation-drawer
        :model-value="drawer"
        name="drawer"
        :permanent="!mobile"
        @update:model-value="($event: boolean) => !$event && $emit('closed')"
    >
        <v-list class="pa-2">
            <!-- custom logo -->
            <AppCustomLogo />

            <!-- time -->
            <div class="mt-1 d-flex justify-center align-center">
                <v-icon icon="mdi-clock-outline" />
                <p class="font-weight-bold">
                    {{ time }}
                </p>
            </div>

            <!-- sidebar links -->
            <div v-for="link in links">
                <v-list-subheader>{{ link.title }}</v-list-subheader>
                <!-- @vue-ignore -->
                <v-list-item
                    v-for="child in link.children"
                    v-use-inertia-link
                    :key="child.title"
                    :href="route(child.route)"
                    :active="route().current(`${baseRouteName(child.route)}.*`)"
                    :title="child.title"
                    :prepend-icon="child.icon"
                    class="rounded-lg"
                    active-class="text-primary"
                />
            </div>
        </v-list>

        <template #append>
            <div class="w-100 pa-1">
                <v-btn
                    v-use-inertia-link
                    text="Logout"
                    prepend-icon="mdi-logout"
                    block
                    @click="logout"
                />
            </div>
        </template>
    </v-navigation-drawer>
</template>
