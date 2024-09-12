<script setup lang="ts">
import { Head, useForm } from "@inertiajs/vue3";

const props = defineProps<{
    token: string;
    email: string;
}>();

const form = useForm({
    token: props.token,
    email: props.email,
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.post(route("password.update"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <Head title="Reset Password" />

    <v-container fluid style="height: 100vh">
        <v-row justify="center" class="fill-height">
            <v-col cols="12" md="6" align-self="center">
                <v-card
                    title="Reset Password"
                    subtitle="Reset your password to continue"
                >
                    <template #text>
                        <v-form @submit.prevent="submit">
                            <v-text-field
                                label="Email"
                                prepend-inner-icon="mdi-email-outline"
                                v-model="form.email"
                                :error-messages="form.errors.email"
                                type="email"
                            />
                            <v-text-field
                                label="Password"
                                prepend-inner-icon="mdi-lock-outline"
                                v-model="form.password"
                                :error-messages="form.errors.password"
                                type="password"
                            />
                            <v-text-field
                                label="Confirm Password"
                                prepend-inner-icon="mdi-lock-outline"
                                v-model="form.password_confirmation"
                                :error-messages="
                                    form.errors.password_confirmation
                                "
                                type="password"
                            />
                            <div class="d-flex w-100 justify-end">
                                <v-btn
                                    text="Submit"
                                    variant="elevated"
                                    type="submit"
                                    :loading="form.processing"
                                />
                            </div>
                        </v-form>
                    </template>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
