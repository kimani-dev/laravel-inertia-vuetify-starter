<script setup>
import { computed } from "vue";
import { Head, router, useForm } from "@inertiajs/vue3";

const props = defineProps({
    status: String,
});

const form = useForm({});

const submit = () => {
    form.post(route("verification.send"));
};

const logout = () => {
    router.post(route("logout"));
};

const verificationLinkSent = computed(
    () => props.status === "verification-link-sent"
);
</script>

<template>
    <Head title="Email Verification" />

    <v-container style="height: 100vh">
        <v-row justify="center" class="fill-height">
            <v-col align-self="center" cols="12" md="5">
                <v-card
                    title="Verify your email"
                    subtitle="You must verify your email address to continue"
                >
                    <template #text>
                        <p class="text-subtitle-21">
                            Before continuing, could you verify your email
                            address by clicking on the link we just emailed to
                            you? If you didn't receive the email, we will gladly
                            send you another.
                        </p>

                        <div
                            v-if="verificationLinkSent"
                            class="text-success text-subtitle-2 font-weight-medium"
                        >
                            A new verification link has been sent to the email
                            address you provided in your profile settings.
                        </div>
                    </template>

                    <template #actions>
                        <div class="d-flex w-100 justify-space-between">
                            <v-btn
                                text="Resend Verification Email"
                                :loading="form.processing"
                                @click="submit"
                            />
                            <div>
                                <v-btn
                                    variant="elevated"
                                    v-use-inertia-link
                                    text="Edit Profile"
                                    :href="route('profile.show')"
                                />
                                <v-btn
                                    variant="elevated"
                                    text="Log Out"
                                    @click="logout"
                                />
                            </div>
                        </div>
                    </template>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>