<script setup>
import { nextTick, ref } from "vue";
import { Head, useForm } from "@inertiajs/vue3";

const recovery = ref(false);

const form = useForm({
    code: "",
    recovery_code: "",
});

const recoveryCodeInput = ref(null);
const codeInput = ref(null);

async function toggleRecovery() {
    recovery.value = true;

    await nextTick();

    if (recovery.value) {
        recoveryCodeInput.value.focus();
        form.code = "";
    } else {
        codeInput.value.focus();
        form.recovery_code = "";
    }
}

function submit() {
    form.post(route("two-factor.login"));
}
</script>

<template>
    <Head title="Two-factor Confirmation" />

    <v-container fluid style="height: 100vh">
        <v-row justify="center" class="fill-height">
            <v-col align-self="center" cols="12" md="6">
                <v-card
                    title="Two Factor Challenge"
                    :subtitle="
                        !recovery
                            ? 'Please confirm access to your account by entering the authentication code provided by your authenticator application.'
                            : 'Please confirm access to your account by entering one of your emergency recovery codes.'
                    "
                >
                    <template #text>
                        <v-text-field
                            ref="codeInput"
                            v-if="!recovery"
                            v-model="form.code"
                            label="Code"
                            prepend-inner-icon="mdi-numeric"
                            type="number"
                            :error-messages="form.errors.code"
                        />
                        <v-text-field
                            ref="recoveryCodeInput"
                            v-else
                            v-model="form.recovery_code"
                            label="Recovery Code"
                            prepend-inner-icon="mdi-numeric"
                            type="number"
                            :error-messages="form.errors.recovery_code"
                        />
                    </template>
                    <template #actions>
                        <div class="d-flex w-100">
                            <v-btn
                                v-if="!recovery"
                                text="Use a recovery code instead"
                                variant="text"
                                @click="toggleRecovery"
                            />
                            <v-btn
                                v-else
                                text="Use an authentication code instead"
                                variant="text"
                                @click="toggleRecovery"
                            />
                            <v-spacer />
                            <v-btn
                                variant="elevated"
                                text="Login"
                                @click="submit"
                                :loading="form.processing"
                                :disabled="form.processing"
                            />
                        </div>
                    </template>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
