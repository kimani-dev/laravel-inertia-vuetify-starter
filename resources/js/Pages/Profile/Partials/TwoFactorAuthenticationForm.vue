<script setup>
import { ref, computed, watch } from "vue";
import { router, useForm, usePage } from "@inertiajs/vue3";
import ActionSection from "@/Components/ActionSection.vue";
import ConfirmsPassword from "@/Components/ConfirmsPassword.vue";
import DangerButton from "@/Components/DangerButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

const props = defineProps({
    requiresConfirmation: Boolean,
});

const page = usePage();
const enabling = ref(false);
const confirming = ref(false);
const disabling = ref(false);
const qrCode = ref(null);
const setupKey = ref(null);
const recoveryCodes = ref([]);

const confirmationForm = useForm({
    code: "",
});

const twoFactorEnabled = computed(
    () => !enabling.value && page.props.auth.user?.two_factor_enabled
);

watch(twoFactorEnabled, () => {
    if (!twoFactorEnabled.value) {
        confirmationForm.reset();
        confirmationForm.clearErrors();
    }
});

const enableTwoFactorAuthentication = () => {
    enabling.value = true;

    router.post(
        route("two-factor.enable"),
        {},
        {
            preserveScroll: true,
            onSuccess: () =>
                Promise.all([
                    showQrCode(),
                    showSetupKey(),
                    showRecoveryCodes(),
                ]),
            onFinish: () => {
                enabling.value = false;
                confirming.value = props.requiresConfirmation;
            },
        }
    );
};

const showQrCode = () => {
    return axios.get(route("two-factor.qr-code")).then((response) => {
        qrCode.value = response.data.svg;
    });
};

const showSetupKey = () => {
    return axios.get(route("two-factor.secret-key")).then((response) => {
        setupKey.value = response.data.secretKey;
    });
};

const showRecoveryCodes = () => {
    return axios.get(route("two-factor.recovery-codes")).then((response) => {
        recoveryCodes.value = response.data;
    });
};

const confirmTwoFactorAuthentication = () => {
    confirmationForm.post(route("two-factor.confirm"), {
        errorBag: "confirmTwoFactorAuthentication",
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            confirming.value = false;
            qrCode.value = null;
            setupKey.value = null;
        },
    });
};

const regenerateRecoveryCodes = () => {
    axios
        .post(route("two-factor.recovery-codes"))
        .then(() => showRecoveryCodes());
};

const disableTwoFactorAuthentication = () => {
    disabling.value = true;

    router.delete(route("two-factor.disable"), {
        preserveScroll: true,
        onSuccess: () => {
            disabling.value = false;
            confirming.value = false;
        },
    });
};
</script>

<template>
    <v-container fluid>
        <v-card>
            <v-card-title>
                <p class="text-h5">Two Factor Authentication</p>
                <p class="text-subtitle-2">
                    Add additional security to your account using two factor
                    authentication.
                </p>
            </v-card-title>
            <v-card-text>
                <p
                    class="text-subtitle-1 font-weight-bold"
                    v-if="twoFactorEnabled && !confirming"
                >
                    You Have Enabled Two Factor Authentication
                </p>
                <p
                    class="text-subtitle-1 font-weight-bold"
                    v-else-if="twoFactorEnabled && confirming"
                >
                    Finish enabling two factor authentication.
                </p>
                <p class="text-subtitle-1 font-weight-bold" v-else>
                    You Have Not Enabled Two Factor Authentication
                </p>
                <p class="text-subtitle-2">
                    When two factor authentication is enabled, you will be
                    prompted for a secure, random token during authentication.
                    You may retrieve this token from your phone's Google
                    Authenticator application.
                </p>

                <!-- Two Factor Enable Start -->
                <div v-if="twoFactorEnabled">
                    <div v-if="qrCode">
                        <div class="mt-4 text-subtitle-2">
                            <p v-if="confirming" class="font-weight-bold">
                                To finish enabling two factor authentication,
                                scan the following QR code using your phone's
                                authenticator application or enter the setup key
                                and provide the generated OTP code.
                            </p>

                            <p v-else>
                                Two factor authentication is now enabled. Scan
                                the following QR code using your phone's
                                authenticator application or enter the setup
                                key.
                            </p>
                        </div>

                        <div
                            class="mt-4 pa-2 d-inline-block bg-white"
                            v-html="qrCode"
                        />

                        <div
                            v-if="setupKey"
                            class="mt-4 max-w-xl text-sm text-gray-600"
                        >
                            <p class="font-semibold">
                                Setup Key: <span v-html="setupKey"></span>
                            </p>
                        </div>

                        <div v-if="confirming" class="mt-4">
                            <v-text-field
                                label="Code"
                                type="text"
                                v-model="confirmationForm.code"
                                @keyup.enter="confirmTwoFactorAuthentication"
                            />
                        </div>
                    </div>

                    <div v-if="recoveryCodes.length > 0 && !confirming">
                        <div class="mt-4 text-subtitle-2">
                            <p class="font-weight-medium">
                                Store these recovery codes in a secure password
                                manager. They can be used to recover access to
                                your account if your two factor authentication
                                device is lost.
                            </p>
                        </div>

                        <v-list density="comfortable">
                            <v-list-item
                                v-for="code in recoveryCodes"
                                :key="code"
                                :title="code"
                                prepend-icon="mdi-circle-small"
                            />
                        </v-list>
                    </div>
                </div>
                <!-- Two Factor Enable End -->
                <!-- Actions start -->
                <div class="mt-5">
                    <div v-if="!twoFactorEnabled">
                        <ConfirmsPassword
                            @confirmed="enableTwoFactorAuthentication"
                        >
                            <v-btn :loading="enabling">Enable</v-btn>
                        </ConfirmsPassword>
                    </div>

                    <div v-else>
                        <ConfirmsPassword
                            @confirmed="confirmTwoFactorAuthentication"
                        >
                            <v-btn v-if="confirming" :loading="enabling"
                                >Confirm</v-btn
                            >
                        </ConfirmsPassword>

                        <ConfirmsPassword @confirmed="regenerateRecoveryCodes">
                            <v-btn
                                v-if="recoveryCodes.length > 0 && !confirming"
                                >Regenerate Recovery Codes</v-btn
                            >
                        </ConfirmsPassword>

                        <ConfirmsPassword @confirmed="showRecoveryCodes">
                            <v-btn
                                v-if="recoveryCodes.length === 0 && !confirming"
                                >Show Recovery Codes</v-btn
                            >
                        </ConfirmsPassword>

                        <ConfirmsPassword
                            @confirmed="disableTwoFactorAuthentication"
                        >
                            <v-btn v-if="confirming" :loading="enabling" class="ml-2"
                                >Cancel</v-btn
                            >
                        </ConfirmsPassword>

                        <ConfirmsPassword
                            @confirmed="disableTwoFactorAuthentication"
                        >
                            <v-btn
                                color="error"
                                class="ml-2"
                                v-if="!confirming"
                                :loading="disabling"
                                >Disable</v-btn
                            >
                        </ConfirmsPassword>
                    </div>
                </div>
                <!-- Actions end -->
            </v-card-text>
        </v-card>
    </v-container>
</template>
