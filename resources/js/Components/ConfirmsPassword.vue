<script setup>
import { ref, reactive, nextTick } from "vue";

const emit = defineEmits(["confirmed"]);

defineProps({
    title: {
        type: String,
        default: "Confirm Password",
    },
    content: {
        type: String,
        default: "For your security, please confirm your password to continue.",
    },
    button: {
        type: String,
        default: "Confirm",
    },
});

const confirmingPassword = ref(false);

const form = reactive({
    password: "",
    error: "",
    processing: false,
});

const passwordInput = ref(null);

const startConfirmingPassword = () => {
    axios.get(route("password.confirmation")).then((response) => {
        if (response.data.confirmed) {
            emit("confirmed");
        } else {
            confirmingPassword.value = true;

            setTimeout(() => passwordInput.value.focus(), 250);
        }
    });
};

const confirmPassword = () => {
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
            passwordInput.value.focus();
        });
};

const closeModal = () => {
    confirmingPassword.value = false;
    form.password = "";
    form.error = "";
};
</script>

<template>
    <span>
        <span @click="startConfirmingPassword">
            <slot />
        </span>

        <v-dialog v-model="confirmingPassword" :persistent="form.processing">
            <v-card width="500" class="mx-auto">
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
