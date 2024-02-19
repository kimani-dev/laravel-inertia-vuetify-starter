<script setup>
import { ref } from "vue";

const drawer = ref(true);

function logout() {
    router.post(route("logout"));
}
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
