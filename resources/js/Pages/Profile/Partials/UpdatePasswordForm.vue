<script setup lang="ts">
import { Ref, ref } from "vue";
import { useForm } from "@inertiajs/vue3";

const passwordInput: Ref<HTMLInputElement | null> = ref(null);
const currentPasswordInput: Ref<HTMLInputElement | null> = ref(null);

const form = useForm({
    current_password: "",
    password: "",
    password_confirmation: "",
});

function updatePassword() {
    form.put(route("user-password.update"), {
        errorBag: "updatePassword",
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset("password", "password_confirmation");
                passwordInput?.value?.focus();
            }

            if (form.errors.current_password) {
                form.reset("current_password");
                currentPasswordInput?.value?.focus();
            }
        },
    });
}
</script>

<template>
    <v-container fluid class="pa-0 pa-md-2">
        <v-row>
            <v-col>
                <v-card
                    title="Update Password"
                    subtitle="Ensure your account is using a long, random password
                            to stay secure."
                >
                    <v-card-text>
                        <v-form @submit.prevent="updatePassword">
                            <v-text-field
                                label="Current Password"
                                v-model="form.current_password"
                                :error-messages="form.errors.current_password"
                                prepend-inner-icon="mdi-lock-outline"
                                type="password"
                                ref="currentPasswordInput"
                            />
                            <v-text-field
                                label="New Password"
                                v-model="form.password"
                                :error-messages="form.errors.password"
                                prepend-inner-icon="mdi-lock-outline"
                                type="password"
                                ref="passwordInput"
                            />
                            <v-text-field
                                label="Confirm Password"
                                v-model="form.password_confirmation"
                                :error-messages="
                                    form.errors.password_confirmation
                                "
                                prepend-inner-icon="mdi-lock-outline"
                                type="password"
                            />
                            <div class="d-flex justify-end">
                                <v-btn type="submit" text="Save" />
                            </div>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
