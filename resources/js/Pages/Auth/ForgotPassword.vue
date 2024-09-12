<script setup>
import { Head, useForm } from "@inertiajs/vue3";

defineProps({
    status: String,
});

const form = useForm({
    email: "",
});

const submit = () => {
    form.post(route("password.email"));
};
</script>

<template>
    <Head title="Forgot Password" />

    <v-container class="bg-background" fluid style="height: 100vh">
        <v-row justify="center" class="fill-height">
            <v-col cols="12" md="6" align-self="center">
                <v-card>
                    <v-card-title>Forgot Password</v-card-title>
                    <v-card-text>
                        <p class="text-subtitle-1">
                            Forgot your password? No problem. Just let us know
                            your email address and we will email you a password
                            reset link that will allow you to choose a new one.
                        </p>
                        <p class="mt-2 subtitle-1 text-success" v-if="status">
                            {{ status }}
                        </p>
                        <v-form class="mt-3" @submit.prevent="submit">
                            <v-text-field
                                label="Email"
                                :error-messages="form.errors.email"
                                v-model="form.email"
                            />
                            <v-btn type="submit" :loading="form.processing"
                                >Email Password Reset Link</v-btn
                            >
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
