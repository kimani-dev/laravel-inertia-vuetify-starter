<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: "",
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    setTimeout(() => passwordInput.value.focus(), 250);
};

const deleteUser = () => {
    form.delete(route("current-user.destroy"), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.reset();
};
</script>

<template>
    <v-container>
        <v-card>
            <v-card-title>
                <p class="text-h5">Delete Account</p>
                <p class="text-subtitle-2">Permanently Delete Your Account</p>
            </v-card-title>
            <v-card-text>
                <p class="text-subtitle-2">
                    Once your account is deleted, all of its resources and data
                    will be permanently deleted. Before deleting your account,
                    please download any data or information that you wish to
                    retain.
                </p>
                <div class="d-flex justify-end">
                    <v-btn color="error" @click="confirmUserDeletion">
                        Delete Account
                    </v-btn>
                </div>
            </v-card-text>
        </v-card>
    </v-container>

    <v-dialog v-model="confirmingUserDeletion" :persistent="form.processing">
        <v-card class="mx-auto" width="500">
            <v-card-title>Delete Account</v-card-title>
            <v-card-text>
                <p class="text-subtitle-2">
                    Are you sure you want to delete your account? Once your
                    account is deleted, all of its resources and data will be
                    permanently deleted. Please enter your password to confirm
                    you would like to permanently delete your account.
                </p>
                <v-text-field
                    ref="passwordInput"
                    label="Password"
                    class="mt-3"
                    v-model="form.password"
                    :error-messages="form.errors.password"
                    @keyup.enter="deleteUser"
                />
                <div class="d-flex mt-2 justify-space-between">
                    <v-btn :disabled="form.processing" @click="closeModal">
                        Cancel
                    </v-btn>
                    <v-btn :loading="form.processing" @click="deleteUser">
                        Confirm
                    </v-btn>
                </div>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>
