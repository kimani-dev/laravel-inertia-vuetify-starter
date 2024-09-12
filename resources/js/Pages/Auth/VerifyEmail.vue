<script setup lang="ts">
import { computed } from "vue";
import { Head, router, useForm } from "@inertiajs/vue3";
import AuthenticationCard from "@/Components/AuthenticationCard.vue";
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue";

const props = defineProps({
    status: String,
});

const form = useForm({});

const verificationLinkSent = computed(
    () => props.status === "verification-link-sent"
);

function submit() {
    form.post(route("verification.send"));
}
</script>

<template>
    <Head title="Email Verification" />

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <div class="mb-4 text-sm text-gray-600">
            Before continuing, could you verify your email address by clicking
            on the link we just emailed to you? If you didn't receive the email,
            we will gladly send you another.
        </div>

        <div
            v-if="verificationLinkSent"
            class="mb-4 font-medium text-sm text-green-600"
        >
            A new verification link has been sent to the email address you
            provided in your profile settings.
        </div>

        <v-form @submit.prevent="submit">
            <div class="d-flex ga-2">
                <v-btn
                    type="submit"
                    :loading="form.processing"
                    :disabled="form.processing"
                    text="Resend Verification Email"
                />

                <v-btn
                    text="Edit Profile"
                    v-use-inertia-link
                    :href="route('profile.show')"
                />

                <v-btn
                    text="Log Out"
                    v-use-inertia-link
                    @click="router.post(route('logout'))"
                />
            </div>
        </v-form>
    </AuthenticationCard>
</template>
