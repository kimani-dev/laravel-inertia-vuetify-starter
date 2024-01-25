<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: "",
    password: "",
    password_confirmation: "",
});

const updatePassword = () => {
    form.put(route("user-password.update"), {
        errorBag: "updatePassword",
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset("password", "password_confirmation");
                passwordInput.value.focus();
            }

            if (form.errors.current_password) {
                form.reset("current_password");
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <v-container>
        <v-row>
            <v-col>
                <v-card>
                    <v-card-title>
                        <p class="text-h5">Update Password</p>
                        <p class="text-subtitle-2">
                            Ensure your account is using a long, random password
                            to stay secure.
                        </p>
                    </v-card-title>
                    <v-card-text>
                        <v-form @submit.prevent="updatePassword">
                            <v-text-field
                                label="Current Password"
                                v-model="form.current_password"
                                :error-messages="form.errors.current_password"
                            ></v-text-field>
                            <v-text-field
                                label="New Password"
                                v-model="form.password"
                                :error-messages="form.errors.password"
                            ></v-text-field>
                            <div class="d-flex justify-end">
                                <v-btn type="submit">Save</v-btn>
                            </div>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
