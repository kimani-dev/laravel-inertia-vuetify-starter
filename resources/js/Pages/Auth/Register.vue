<script setup>
import { ref } from "vue";
import { Head, useForm } from "@inertiajs/vue3";

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
    <Head title="Register" />

    <v-container fluid class="bg-background pa-0 ma-0" style="height: 100vh">
        <v-row class="fill-height" justify="center" no-gutters>
            <v-col cols="12" md="7" align-self="center">
                <v-card width="500" class="mx-auto">
                    <v-card-title>
                        <div class="d-flex justify-space-between">
                            <div>
                                <h1 class="text-h5 text-primary">Sign Up</h1>
                                <p class="text-subtitle-1">
                                    Enter Credentials To Continue
                                </p>
                            </div>
                            <v-chip
                                color="primary"
                                variant="elevated"
                                class="my-auto pa-4"
                            >
                                <div class="d-flex">
                                    <v-icon icon="mdi-laravel" size="25" />
                                    <p class="text-subtitle-2 ml-2">MY APP</p>
                                </div>
                            </v-chip>
                        </div>
                    </v-card-title>
                    <v-card-text class="mt-2">
                        <v-btn
                            block
                            variant="outlined"
                            prepend-icon="mdi-google"
                        >
                            Sign In With Google
                        </v-btn>
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
                                <v-divider thickness="2" />
                            </v-col>
                        </v-row>
                        <p class="text-subtitle-2 text-center mt-2">
                            Sign In With Email Address
                        </p>
                        <!-- <p v-if="status" class="text-subtitle-2 text-success">
                            {{ status }}
                        </p> -->
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
                                    $page.props.jetstream
                                        .hasTermsAndPrivacyPolicyFeature
                                "
                            >
                                <template #label>
                                    <p>
                                        I agree to the
                                        <a
                                            target="_blank"
                                            :href="route('terms.show')"
                                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                            >Terms of Service</a
                                        >
                                        and
                                        <a
                                            target="_blank"
                                            :href="route('policy.show')"
                                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                            >Privacy Policy</a
                                        >
                                    </p>
                                </template>
                            </v-checkbox>
                            <v-btn
                                class="mt-3"
                                type="submit"
                                block
                                :loading="form.processing"
                                >Sign Up</v-btn
                            >
                            <v-btn
                                v-use-inertia-link
                                block
                                :href="route('login')"
                                variant="text"
                                class="mt-2"
                                >Already Registered?</v-btn
                            >
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col
                cols="12"
                md="5"
                class="d-flex flex-column justify-space-between bg-grey-lighten-3"
            >
                <v-img
                    src="/assets/illustrations/onboarding.svg"
                    width="300"
                    class="mx-auto"
                />
                <v-carousel
                    :show-arrows="false"
                    hide-delimiter-background
                    height="200"
                    color="primary"
                    cycle
                    interval="2000"
                >
                    <v-carousel-item v-for="n in 3">
                        <div class="pa-3">
                            <p class="text-h5">
                                Welcome to Laravel Vuetify Starter Kit
                            </p>
                            <p class="text-subtitle-2">
                                Lorem ipsum, dolor sit amet consectetur
                                adipisicing elit. Sint provident facilis illo
                                repellendus, neque consequatur dicta omnis ab
                                iure nesciunt similique optio tempora qui
                                aliquid nulla quisquam, deserunt rerum quo.
                            </p>
                        </div>
                    </v-carousel-item>
                </v-carousel>
            </v-col>
        </v-row>
    </v-container>
</template>
