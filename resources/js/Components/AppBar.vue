<script setup>
const logout = () => {
    router.post(route("logout"));
};
</script>

<template>
    <v-app-bar title="Laravel Starter Kit">
        <div class="h-100 w-100 d-flex align-center justify-space-between">
            <!-- Menu Links Start -->
            <div>
                <v-chip
                    v-use-inertia-link
                    color="primary"
                    variant="elevated"
                    class="pa-4"
                    :href="route('dashboard')"
                >
                    <div class="d-flex align-center">
                        <v-icon icon="mdi-laravel"></v-icon>
                        <p class="text-subtitle-1 ml-2">MY APP</p>
                    </div>
                </v-chip>
                <v-btn
                    v-use-inertia-link
                    class="ml-2"
                    :href="route('dashboard')"
                    :active="route().current('dashboard')"
                    >Dashboard
                </v-btn>
            </div>
            <!-- Menu Links End -->
            <div>
                <v-badge :content="8" color="red-lighten-1">
                    <v-btn icon="mdi-bell" variant="tonal" class="my-auto" />
                </v-badge>
                <v-menu>
                    <template #activator="{ props }">
                        <v-chip
                            size="large"
                            color="primary"
                            v-bind="props"
                            class="ml-2 my-auto"
                        >
                            <v-icon icon="mdi-cog" size="large" />
                            <v-avatar class="ml-2">
                                <v-img
                                    :src="
                                        $page.props.auth.user.profile_photo_url
                                    "
                                ></v-img>
                            </v-avatar>
                        </v-chip>
                    </template>
                    <v-card width="400" flat>
                        <v-list>
                            <v-list-item
                                :title="$page.props.auth.user.name"
                                :subtitle="$page.props.auth.user.email"
                                :prepend-avatar="
                                    $page.props.auth.user.profile_photo_url
                                "
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
