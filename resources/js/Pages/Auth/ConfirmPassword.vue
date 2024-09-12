<script setup lang="ts">
import { Ref, ref } from "vue";
import { Head, useForm } from "@inertiajs/vue3";
import AuthenticationCard from "@/Components/AuthenticationCard.vue";
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue";

const form = useForm({
    password: "",
});

const passwordInput: Ref<HTMLInputElement | null> = ref(null);

function submit() {
    form.post(route("password.confirm"), {
        onFinish: () => {
            form.reset();
            passwordInput?.value?.focus();
        },
    });
}
</script>

<template>
    <Head title="Secure Area" />

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <div class="mb-4 text-subtitle-2">
            This is a secure area of the application. Please confirm your
            password before continuing.
        </div>

        <v-form @submit.prevent="submit">
            <v-text-field
                label="Password"
                :error-messages="form.errors.password"
                v-model="form.password"
                type="password"
                ref="passwordInput"
            />
            <v-btn type="submit" :loading="form.processing" />
        </v-form>
    </AuthenticationCard>
</template>
