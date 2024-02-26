<script setup>
import { ref, computed } from "vue";
import { useTheme, useDisplay } from "vuetify";
import { router, usePage } from "@inertiajs/vue3";
import moment from "moment";

import SideBar from "./SideBar.vue";

//user
const user = ref(usePage().props.auth.user);

// drawer
const { mobile } = useDisplay();
const drawer = ref(!mobile.value);
function toggleDrawer() {
    drawer.value = !drawer.value;
}

// logout
const logout = () => {
    router.post(route("logout"));
};

// theme
const theme = useTheme();
const isDark = computed(() => {
    return theme.global.current.value.dark;
});
function changeTheme() {
    const changeThemeTo = theme.global.current.value.dark ? "light" : "dark";
    theme.global.name.value = changeThemeTo;

    localStorage.setItem("theme", changeThemeTo);
}

// notifications
function markNotificationsAsRead() {
    router.put(route("users.notifications.mark-as-read", user.value), {
        onSuccess: () => {
            router.reload();
        },
    });
}
const tabs = ref("all");
const unreadNotifications = computed(() => {
    return user.value.notifications.filter(
        (notification) => notification.read_at === null
    );
});
</script>

<template>
    <SideBar :drawer="drawer" @closed="drawer = false" />
    <v-app-bar title="Laravel Starter Kit">
        <div class="h-100 w-100 d-flex align-center justify-space-between">
            <div class="d-flex">
                <v-icon icon="mdi-menu" class="my-auto" @click="toggleDrawer" />
                <p class="text-h5 ml-2 text-primary">Laravel</p>
            </div>
            <div class="d-flex">
                <v-icon
                    :icon="
                        isDark ? 'mdi-white-balance-sunny' : 'mdi-weather-night'
                    "
                    size="30"
                    class="my-auto mr-2"
                    color="primary"
                    @click="changeTheme"
                />
                <div class="my-auto mr-4">
                    <v-menu :close-on-content-click="false">
                        <template #activator="{ props }">
                            <v-badge
                                :content="unreadNotifications.length"
                                color="red-lighten-1"
                            >
                                <v-icon
                                    icon="mdi-bell"
                                    color="primary"
                                    size="30"
                                    v-bind="props"
                                />
                            </v-badge>
                        </template>
                        <v-card width="400">
                            <v-card-title>
                                <div class="d-flex justify-space-between">
                                    <p class="text-h6">Notifications</p>
                                    <v-btn
                                        prepend-icon="mdi-check-all"
                                        text="Mark All as Read"
                                        variant="text"
                                        @click="markNotificationsAsRead"
                                    />
                                </div>
                            </v-card-title>
                            <v-tabs
                                density="compact"
                                mandatory="force"
                                v-model="tabs"
                            >
                                <v-tab value="all">All</v-tab>
                                <v-tab value="unread">Unread</v-tab>
                            </v-tabs>
                            <v-window v-model="tabs">
                                <v-window-item value="all">
                                    <v-list
                                        class="pa-2"
                                        v-if="user.notifications.length != 0"
                                    >
                                        <v-list-item
                                            v-for="notification in user.notifications"
                                            :index="notification.id"
                                            :title="notification.data.title"
                                            :subtitle="
                                                notification.data.message
                                            "
                                            :active="
                                                notification.read_at === null
                                            "
                                            active-class="text-primary"
                                        >
                                            <template #append>
                                                <v-icon
                                                    v-if="
                                                        notification.read_at ===
                                                        null
                                                    "
                                                    icon="mdi-circle-small"
                                                    color="primary"
                                                />
                                                <p class="text-caption">
                                                    {{
                                                        moment(
                                                            notification.created_at
                                                        ).fromNow()
                                                    }}
                                                </p>
                                            </template>
                                        </v-list-item>
                                    </v-list>
                                    <div
                                        v-else
                                        class="px-2 py-5 d-flex justify-center"
                                    >
                                        <v-icon
                                            icon="mdi-creation-outline"
                                            color="primary"
                                        />
                                        <p class="my-auto ml-2">
                                            You're all caught up!
                                        </p>
                                    </div>
                                </v-window-item>
                                <v-window-item value="unread">
                                    <v-list
                                        class="pa-2"
                                        v-if="unreadNotifications.length != 0"
                                    >
                                        <v-list-item
                                            v-for="notification in user.notifications.filter(
                                                (notification) =>
                                                    notification.read_at ===
                                                    null
                                            )"
                                            :index="notification.id"
                                            :title="notification.data.title"
                                            :subtitle="
                                                notification.data.message
                                            "
                                        >
                                            <template #append>
                                                <v-icon
                                                    icon="mdi-circle-small"
                                                    color="primary"
                                                />
                                                <p class="text-caption">
                                                    {{
                                                        moment(
                                                            notification.created_at
                                                        ).fromNow()
                                                    }}
                                                </p>
                                            </template>
                                        </v-list-item>
                                    </v-list>
                                    <div
                                        class="px-2 py-5 d-flex justify-center"
                                        v-else
                                    >
                                        <v-icon
                                            icon="mdi-creation-outline"
                                            color="primary"
                                        />
                                        <p class="my-auto ml-2">
                                            You're all caught up!
                                        </p>
                                    </div>
                                </v-window-item>
                            </v-window>
                        </v-card>
                    </v-menu>
                </div>
                <v-menu>
                    <template #activator="{ props }">
                        <v-avatar class="mr-3" v-bind="props" size="45">
                            <v-img :src="user.profile_photo_url" />
                        </v-avatar>
                    </template>
                    <v-card width="400" flat>
                        <v-list>
                            <v-list-item
                                :title="user.name"
                                :subtitle="user.email"
                                :prepend-avatar="user.profile_photo_url"
                            />
                            <v-divider class="mt-3"></v-divider>
                            <v-list-item
                                v-use-inertia-link
                                prepend-icon="mdi-account-circle"
                                title="Profile"
                                :href="route('profile.show')"
                            />
                            <v-list-item
                                v-if="$page.props.jetstream.hasApiFeatures"
                                prepend-icon="mdi-api"
                                v-use-inertia-link
                                title="API Tokens"
                                :href="route('api-tokens.index')"
                            />
                            <v-list-item
                                prepend-icon="mdi-logout"
                                title="Logout"
                                @click="logout"
                            />
                        </v-list>
                    </v-card>
                </v-menu>
            </div>
        </div>
    </v-app-bar>
</template>
