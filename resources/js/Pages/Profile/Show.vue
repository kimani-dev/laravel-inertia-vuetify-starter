<script setup lang="ts">
import { usePage } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import DeleteUserForm from "@/Pages/Profile/Partials/DeleteUserForm.vue";
import LogoutOtherBrowserSessionsForm from "@/Pages/Profile/Partials/LogoutOtherBrowserSessionsForm.vue";
import TwoFactorAuthenticationForm from "@/Pages/Profile/Partials/TwoFactorAuthenticationForm.vue";
import UpdatePasswordForm from "@/Pages/Profile/Partials/UpdatePasswordForm.vue";
import UpdateProfileInformationForm from "@/Pages/Profile/Partials/UpdateProfileInformationForm.vue";

defineProps<{
    confirmsTwoFactorAuthentication: boolean;
    sessions: any[];
}>();

const page: any = usePage();
</script>

<template>
    <AppLayout title="Profile">
        <v-container fluid class="pa-0">
            <v-row>
                <v-col>
                    <div class="mt-3">
                        <div
                            v-if="
                                page.props.jetstream.canUpdateProfileInformation
                            "
                        >
                            <UpdateProfileInformationForm
                                :user="page.props.auth.user"
                            />
                        </div>
                    </div>

                    <div v-if="page.props.jetstream.canUpdatePassword">
                        <UpdatePasswordForm />
                    </div>

                    <div
                        v-if="
                            page.props.jetstream
                                .canManageTwoFactorAuthentication
                        "
                    >
                        <TwoFactorAuthenticationForm
                            :requires-confirmation="
                                confirmsTwoFactorAuthentication
                            "
                        />
                    </div>

                    <LogoutOtherBrowserSessionsForm :sessions="sessions" />

                    <template
                        v-if="page.props.jetstream.hasAccountDeletionFeatures"
                    >
                        <DeleteUserForm />
                    </template>
                </v-col>
            </v-row>
        </v-container>
    </AppLayout>
</template>
