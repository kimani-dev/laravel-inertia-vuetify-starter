<script setup lang="ts">
import AppCustomLogo from "@/Components/AppCustomLogo.vue";
import { computed } from "vue";
import { useTheme } from "vuetify";

const theme = useTheme();
const isDark = computed(() => {
    return theme.global.current.value.dark;
});
function changeTheme() {
    const changeThemeTo = isDark.value ? "light" : "dark";
    theme.global.name.value = changeThemeTo;

    localStorage.setItem("theme", changeThemeTo);
}
</script>

<template>
    <v-app-bar>
        <template #prepend>
            <AppCustomLogo />
        </template>
        <div class="d-flex-justify-end ga-2 mr-2">
            <v-btn text="Features" variant="text" color="" />
            <v-btn text="Demo" variant="text" color="" />
            <v-btn text="Pricing" variant="text" color="" />
            <v-icon
                icon="mdi-weather-sunny"
                color=""
                class="mt-1"
                @click="changeTheme"
            />
            <v-btn
                v-use-inertia-link
                text="Get Started"
                variant="elevated"
                class="bg-custom ml-2"
                :href="route('login')"
            />
        </div>
    </v-app-bar>
</template>
