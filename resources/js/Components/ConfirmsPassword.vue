<script setup lang="ts">
import { ref, reactive, nextTick, Ref } from "vue";
import axios from "axios";

const emit = defineEmits(["confirmed"]);

withDefaults(
    defineProps<{
        title: string;
        content: string;
        button: string;
    }>(),
    {
        title: "Confirm Password",
        content: "For your security, please confirm your password to continue.",
        button: "Confirm",
    }
);

const confirmingPassword = ref(false);

const form = reactive({
    password: "",
    error: "",
    processing: false,
});

const passwordInput: Ref<HTMLInputElement | null> = ref(null);

const startConfirmingPassword = () => {
    axios.get(route("password.confirmation")).then((response) => {
        if (response.data.confirmed) {
            emit("confirmed");
        } else {
            confirmingPassword.value = true;

            setTimeout(() => passwordInput?.value?.focus(), 250);
        }
    });
};

function confirmPassword() {
    form.processing = true;

    axios
        .post(route("password.confirm"), {
            password: form.password,
        })
        .then(() => {
            form.processing = false;

            closeModal();
            nextTick().then(() => emit("confirmed"));
        })
        .catch((error) => {
            form.processing = false;
            form.error = error.response.data.errors.password[0];
            passwordInput?.value?.focus();
        });
}

function closeModal() {
    confirmingPassword.value = false;
    form.password = "";
    form.error = "";
}
</script>

<template>
    <span>
        <span @click="startConfirmingPassword">
            <slot />
        </span>

        <v-dialog v-model="confirmingPassword" :persistent="form.processing">
            <v-card
                width="500"
                class="mx-auto"
                :title="title"
                subtitle="Confirm password to continue"
            >
                <v-card-title>{{ title }}</v-card-title>
                <v-card-text>
                    {{ content }}
                    <div class="mt-3">
                        <v-text-field
                            ref="passwordInput"
                            label="Password"
                            type="password"
                            :error-messages="form.error"
                            v-model="form.password"
                            @keyup.enter="confirmPassword"
                        />
                        <div class="d-flex justify-space-between">
                            <v-btn
                                @click="closeModal"
                                :disabled="form.processing"
                            >
                                Cancel
                            </v-btn>
                            <v-btn
                                @click="confirmPassword"
                                :loading="form.processing"
                            >
                                {{ button }}
                            </v-btn>
                        </div>
                    </div>
                </v-card-text>
            </v-card>
        </v-dialog>
    </span>
</template>
