<script setup lang="ts">
import { ref } from "vue";
import { Head, useForm } from "@inertiajs/vue3";
import AppCustomLogo from "@/Components/AppCustomLogo.vue";
import AuthPageLayout from "@/Layouts/AuthPageLayout.vue";

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    terms: false,
});

const showPassword = ref(false);

const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <AuthPageLayout title="Register">
        <v-row justify="center">
            <v-col align-self="center" cols="12" md="8">
                <v-card
                    class="mx-auto"
                    title="Sign Up"
                    subtitle="Enter Credentials To Continue"
                >
                    <template #append>
                        <AppCustomLogo />
                    </template>

                    <!-- social auth -->
                    <template #text>
                        <v-btn
                            v-use-inertia-link
                            block
                            variant="outlined"
                            prepend-icon="mdi-google"
                            text="Sign Up With Google"
                            :href="route('google.login')"
                        />

                        <!-- divider for social auth and email sign up form -->
                        <v-row no-gutters class="mt-3">
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
                                <v-divider thickness="1" />
                            </v-col>
                        </v-row>
                        <p class="text-subtitle-2 text-center mt-2">
                            Sign In With Email Address
                        </p>

                        <!-- auth status e.g pasword reset success -->
                        <!-- <p v-if="status" class="text-subtitle-2 text-success">
                            {{ status }}
                        </p> -->

                        <!-- sign up form -->
                        <v-form class="mt-2" @submit.prevent="submit">
                            <v-text-field
                                label="Full Name"
                                v-model="form.name"
                                :error-messages="form.errors.name"
                            />
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
                            <v-text-field
                                label="Confirm Password"
                                v-model="form.password_confirmation"
                                :error-messages="
                                    form.errors.password_confirmation
                                "
                                :type="showPassword ? 'text' : 'password'"
                                :append-inner-icon="
                                    showPassword ? 'mdi-eye-off' : 'mdi-eye'
                                "
                                @click:append-inner="
                                    showPassword = !showPassword
                                "
                            />
                            <v-checkbox
                                class="mt-n5"
                                :hide-details="!form.errors.terms"
                                v-model="form.terms"
                                :error-messages="form.errors.terms"
                                v-if="
                                    ($page as any).props.jetstream
                                        .hasTermsAndPrivacyPolicyFeature
                                "
                            >
                                <template #label>
                                    <p>
                                        I agree to the
                                        <base-link
                                            :href="route('terms.show')"
                                            v-text="'Terms of Service'"
                                        />
                                        and
                                        <base-link
                                            :href="route('policy.show')"
                                            v-text="'Privacy Policy'"
                                        />
                                    </p>
                                </template>
                            </v-checkbox>

                            <v-btn
                                class="mt-3"
                                type="submit"
                                block
                                :loading="form.processing"
                                text="Sign Up"
                            />
                            <v-btn
                                v-use-inertia-link
                                block
                                :href="route('login')"
                                variant="text"
                                class="mt-2"
                                text="Already Registered? Sign In"
                            />
                        </v-form>
                    </template>
                </v-card>
            </v-col>
        </v-row>
    </AuthPageLayout>
</template>
