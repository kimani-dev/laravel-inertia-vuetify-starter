<script setup lang="ts">
import { ref } from "vue";
import { Head, useForm } from "@inertiajs/vue3";
import AppCustomLogo from "@/Components/AppCustomLogo.vue";
import AuthPageLayout from "@/Layouts/AuthPageLayout.vue";

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const showPassword = ref(false);

function submit() {
    form.transform((data) => ({
        ...data,
        remember: form.remember ? "on" : "",
    })).post(route("login"), {
        onFinish: () => form.reset("password"),
    });
}
</script>

<template>
    <AuthPageLayout title="Login">
        <v-row justify="center">
            <v-col align-self="center" cols="12" md="8">
                <v-card
                    class="mx-auto"
                    title="Hello, Welcome Back"
                    subtitle="Login To Your Account"
                >
                    <template #append>
                        <AppCustomLogo />
                    </template>

                    <template #text>
                        <!-- sign in with google button -->
                        <v-btn
                            block
                            variant="outlined"
                            prepend-icon="mdi-google"
                            text="Sign In With Google"
                        />

                        <v-row no-gutters class="mt-5">
                            <v-col align-self="center">
                                <v-divider thickness="2" />
                            </v-col>
                            <v-col cols="1">
                                <div
                                    class="rounded-pill bg-primary text-center text-subtitle-2"
                                >
                                    OR
                                </div>
                            </v-col>
                            <v-col align-self="center">
                                <v-divider thickness="2" />
                            </v-col>
                        </v-row>
                        <p class="text-subtitle-2 text-center mt-4">
                            Sign In With Email Address
                        </p>

                        <!-- page status e.g successful password reset -->
                        <p v-if="status" class="text-subtitle-2 text-success">
                            {{ status }}
                        </p>

                        <!-- sign in with email form -->
                        <v-form class="mt-3" @submit.prevent="submit">
                            <v-text-field
                                label="Email Address/Username"
                                v-model="form.email"
                                :error-messages="form.errors.email"
                            />
                            <v-text-field
                                label="Password"
                                v-model="form.password"
                                :error-messages="form.errors.password"
                                :type="showPassword ? 'text' : 'password'"
                                :append-inner-icon="
                                    showPassword ? 'mdi-eye-off' : 'mdi-eye'
                                "
                                @click:append-inner="
                                    showPassword = !showPassword
                                "
                            />
                            <div class="d-flex justify-space-between">
                                <v-checkbox
                                    label="Remember Me?"
                                    hide-details
                                    v-model="form.remember"
                                />
                                <v-btn
                                    v-use-inertia-link
                                    variant="text"
                                    class="my-auto"
                                    text="Forgot Password?"
                                    :href="route('password.request')"
                                />
                            </div>
                            <v-btn
                                class="mt-3"
                                type="submit"
                                block
                                :loading="form.processing"
                                text="Sign In"
                            />
                            <v-btn
                                class="mt-3"
                                v-use-inertia-link
                                block
                                variant="text"
                                :href="route('register')"
                                text="Create Account"
                            />
                        </v-form>
                    </template>
                </v-card>
            </v-col>
        </v-row>
    </AuthPageLayout>
</template>
