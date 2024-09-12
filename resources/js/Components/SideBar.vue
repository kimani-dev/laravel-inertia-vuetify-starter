<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import { useDisplay } from "vuetify";
import moment from "moment";
import AppCustomLogo from "./AppCustomLogo.vue";

const props = defineProps({
    drawer: {
        type: Boolean,
        required: false,
    },
});

const { mobile } = useDisplay();

function logout() {
    router.post(route("logout"));
}

// time
const time = ref(moment().format("HH:mm:ss A"));

function updateTime() {
    const date = new Date();
    let hours = date.getHours();
    let minutes = date.getMinutes();
    let seconds = date.getSeconds();
    const ampm = hours >= 12 ? "PM" : "AM";

    // Prepend zero if necessary
    hours = hours < 10 ? "0" + hours : hours;
    minutes = minutes < 10 ? "0" + minutes : minutes;
    seconds = seconds < 10 ? "0" + seconds : seconds;

    time.value = `${hours}:${minutes}:${seconds} ${ampm}`;
}

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

setInterval(updateTime, 1000);
</script>

<template>
    <v-navigation-drawer
        :model-value="drawer"
        name="drawer"
        :permanent="!mobile"
        @update:model-value="($event) => !$event && $emit('closed')"
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
                <v-list-item
                    v-for="child in link.children"
                    v-use-inertia-link
                    :key="child.title"
                    :href="route(child.route)"
                    :active="route().current(child.route)"
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
