<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

const drawer = ref(true);

function logout() {
    router.post(route("logout"));
}

// time
const time = ref("");

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

setInterval(updateTime, 1000);
</script>

<template>
    <v-navigation-drawer v-model="drawer" name="drawer" permanent>
        <v-list class="pa-2">
            <div class="pa-2 bg-primary rounded-lg d-flex justify-center">
                <div class="d-flex">
                    <v-icon icon="mdi-laravel" class="my-auto" />
                    <p class="text-h6 ml-2">Laravel</p>
                </div>
            </div>
            <div class="mt-1 text-center font-weight-bold">
                <p>
                    <v-icon
                        icon="mdi-clock-outline"
                        size="x-small"
                        class="mt-n1"
                    />
                    {{ time }}
                </p>
            </div>
            <v-list-subheader>Home</v-list-subheader>
            <v-list-item
                v-use-inertia-link
                :href="route('dashboard')"
                :active="route().current('dashboard')"
                title="Dashboard"
                prepend-icon="mdi-view-dashboard-outline"
                class="rounded-lg"
                active-class="text-primary"
            />
            <v-list-item
                v-use-inertia-link
                :href="route('profile.show')"
                :active="route().current('profile.show')"
                title="Profile"
                prepend-icon="mdi-account-outline"
                class="rounded-lg"
                active-class="text-primary"
            />
            <v-list-item
                v-use-inertia-link
                :href="route('users.index')"
                :active="route().current('users.index')"
                title="Users"
                prepend-icon="mdi-account-group-outline"
                class="rounded-lg"
                active-class="text-primary"
            />
            <v-list-subheader>Settings</v-list-subheader>
            <v-list-item
                v-use-inertia-link
                :href="route('roles.index')"
                :active="route().current('roles.index')"
                title="Roles and Permissions"
                prepend-icon="mdi-shield-account-outline"
                class="rounded-lg"
                active-class="text-primary"
            />
            <v-list-item
                v-use-inertia-link
                :href="route('logs.index')"
                :active="route().current('logs.index')"
                title="Access Logs"
                prepend-icon="mdi-history"
                class="rounded-lg"
                active-class="text-primary"
            />
            <v-list-item
                v-use-inertia-link
                :href="route('api-tokens.index')"
                :active="route().current('api-tokens.index')"
                title="API Tokens"
                prepend-icon="mdi-api"
                class="rounded-lg"
                active-class="text-primary"
            />
            <v-list-item
                title="Logout"
                prepend-icon="mdi-logout"
                class="rounded-lg"
                active-class="text-primary"
                @click="logout"
            />
        </v-list>
    </v-navigation-drawer>
</template>
