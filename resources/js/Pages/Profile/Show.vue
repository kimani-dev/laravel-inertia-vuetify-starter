<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import DeleteUserForm from "@/Pages/Profile/Partials/DeleteUserForm.vue";
import LogoutOtherBrowserSessionsForm from "@/Pages/Profile/Partials/LogoutOtherBrowserSessionsForm.vue";
import SectionBorder from "@/Components/SectionBorder.vue";
import TwoFactorAuthenticationForm from "@/Pages/Profile/Partials/TwoFactorAuthenticationForm.vue";
import UpdatePasswordForm from "@/Pages/Profile/Partials/UpdatePasswordForm.vue";
import UpdateProfileInformationForm from "@/Pages/Profile/Partials/UpdateProfileInformationForm.vue";

defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
});
</script>

<template>
    <AppLayout title="Profile">
        <v-container fluid>
            <v-row>
                <v-col>
                    <div class="mt-3">
                        <div
                            v-if="
                                $page.props.jetstream
                                    .canUpdateProfileInformation
                            "
                        >
                            <UpdateProfileInformationForm
                                :user="$page.props.auth.user"
                            />
                        </div>
                    </div>

                    <div v-if="$page.props.jetstream.canUpdatePassword">
                        <UpdatePasswordForm />
                    </div>

                    <div
                        v-if="
                            $page.props.jetstream
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
                        v-if="$page.props.jetstream.hasAccountDeletionFeatures"
                    >
                        <DeleteUserForm />
                    </template>
                </v-col>
            </v-row>
        </v-container>
    </AppLayout>
</template>
