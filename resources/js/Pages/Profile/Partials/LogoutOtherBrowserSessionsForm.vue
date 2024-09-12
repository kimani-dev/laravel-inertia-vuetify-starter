<script setup lang="ts">
import { Ref, ref } from "vue";
import { useForm } from "@inertiajs/vue3";

import Session from "@/types/Session";

defineProps<{
    sessions: Session[];
}>();

const confirmingLogout = ref(false);
const passwordInput: Ref<HTMLInputElement | null> = ref(null);

const form = useForm({
    password: "",
});

function confirmLogout() {
    confirmingLogout.value = true;
    setTimeout(() => passwordInput?.value?.focus(), 250);
}

function logoutOtherBrowserSessions() {
    form.delete(route("other-browser-sessions.destroy"), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput?.value?.focus(),
        onFinish: () => form.reset(),
    });
}

function closeModal() {
    confirmingLogout.value = false;
    form.reset();
}
</script>

<template>
    <v-container>
        <v-card>
            <v-card-title>
                <p class="text-h5">Browser Sessions</p>
                <p class="text-subtitle-2">
                    Manage and log out your active sessions on other browsers
                    and devices.
                </p>
            </v-card-title>
            <v-card-text>
                <p class="text-subtitle-2">
                    If necessary, you may log out of all of your other browser
                    sessions across all of your devices. Some of your recent
                    sessions are listed below; however, this list may not be
                    exhaustive. If you feel your account has been compromised,
                    you should also update your password.
                </p>
                <v-list>
                    <v-list-item
                        v-for="(session, i) in sessions"
                        :key="i"
                        :prepend-icon="
                            session.agent.is_desktop
                                ? 'mdi-monitor'
                                : 'mdi-cellphone'
                        "
                        :title="`${session.agent.platform ?? 'Uknown'} - ${
                            session.agent.browser ?? 'Uknown'
                        }`"
                    >
                        <template #subtitle>
                            <p>
                                {{ session.ip_address }},
                                <span
                                    v-if="session.is_current_device"
                                    class="text-success"
                                >
                                    This Device
                                </span>
                                <span v-else>
                                    Last Active {{ session.last_active }}
                                </span>
                            </p>
                        </template>
                    </v-list-item>
                </v-list>
                <div class="d-flex justify-end">
                    <v-btn @click="confirmLogout">
                        Log Out Other Browser Sessions
                    </v-btn>
                </div>
            </v-card-text>
        </v-card>
    </v-container>

    <v-dialog v-model="confirmingLogout" :persistent="form.processing">
        <v-row justify="center">
            <v-col cols="12" md="6">
                <v-card class="mx-auto" title="Log Out Other Browser Sessions">
                    <v-card-text>
                        <p class="text-subtitle-1">
                            Please enter your password to confirm you would like
                            to log out of your other browser sessions across all
                            of your devices.
                        </p>
                        <v-text-field
                            ref="passwordInput"
                            class="mt-2"
                            label="Password"
                            v-model="form.password"
                            :error-messages="form.errors.password"
                            @keyup.enter="logoutOtherBrowserSessions"
                        />
                        <div class="d-flex justify-space-between">
                            <v-btn
                                @click="closeModal"
                                :disabled="form.processing"
                                >Cancel</v-btn
                            >
                            <v-btn
                                :loading="form.processing"
                                @click="logoutOtherBrowserSessions"
                                >Confirm</v-btn
                            >
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-dialog>
</template>
