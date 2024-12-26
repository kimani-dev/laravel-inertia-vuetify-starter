<script setup lang="ts">
import { Ref, ref } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import User from "@/types/User";

const props = defineProps<{
    user: User;
}>();

const form = useForm({
    _method: "PUT",
    name: props.user.name,
    email: props.user.email,
    photo: null as File | null,
});

const verificationLinkSent = ref(false);
const photoPreview: any = ref(null);
const photoInput: Ref<HTMLInputElement | null> = ref(null);

const updateProfileInformation = () => {
    if (photoInput.value) {
        form.photo = photoInput?.value?.files?.[0] ?? null;
    }

    form.post(route("user-profile-information.update"), {
        errorBag: "updateProfileInformation",
        preserveScroll: true,
        onSuccess: () => clearPhotoFileInput(),
    });
};

function sendEmailVerification() {
    verificationLinkSent.value = true;
    router.post(route("verification.send"));
}

function selectNewPhoto() {
    photoInput?.value?.click();
}

function updatePhotoPreview() {
    const photo = photoInput?.value?.files?.[0];

    if (!photo) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        photoPreview.value = e?.target?.result;
    };

    reader.readAsDataURL(photo);
}

function deletePhoto() {
    router.delete(route("current-user-photo.destroy"), {
        preserveScroll: true,
        onSuccess: () => {
            photoPreview.value = null;
            clearPhotoFileInput();
        },
    });
}

function clearPhotoFileInput() {
    if (photoInput.value) {
        photoInput.value = null;
    }
}
</script>

<template>
    <v-container fluid class="pa-0 pa-md-2">
        <v-row>
            <v-col>
                <v-card
                    title="Profile Information"
                    subtitle="Update your account's profile information and email
                            address."
                >
                    <v-card-text>
                        <v-form @submit.prevent="updateProfileInformation">
                            <div
                                v-if="
                                    ($page as any).props.jetstream.managesProfilePhotos
                                "
                            >
                                <v-avatar
                                    rounded="50"
                                    size="50"
                                    @click="selectNewPhoto"
                                >
                                    <v-img
                                        :src="
                                            !photoPreview
                                                ? user.profile_photo_url
                                                : photoPreview
                                        "
                                    />
                                </v-avatar>
                                <v-btn
                                    class="ml-2"
                                    v-if="user.profile_photo_path"
                                    @click="deletePhoto"
                                >
                                    Remove Photo
                                </v-btn>
                                <v-file-input
                                    class="d-none"
                                    ref="photoInput"
                                    accept="image/*"
                                    @change="updatePhotoPreview"
                                />
                            </div>
                            <v-text-field
                                class="mt-3"
                                label="Name"
                                v-model="form.name"
                                :error-messages="form.errors.name"
                                prepend-inner-icon="mdi-account-outline"
                            />
                            <v-text-field
                                label="Email"
                                v-model="form.email"
                                :error-messages="form.errors.email"
                                prepend-inner-icon="mdi-email-outline"
                            />
                            <div
                                v-if="
                                    ($page as any).props.jetstream
                                        .hasEmailVerification &&
                                    user.email_verified_at === null
                                "
                            >
                                <p
                                    class="text-error"
                                    v-if="!verificationLinkSent"
                                >
                                    Your email is unverified
                                </p>
                                <p v-else class="text-success">
                                    Verification link sent successfully
                                </p>
                                <v-btn
                                    v-if="!verificationLinkSent"
                                    class="mt-2"
                                    @click.prevent="sendEmailVerification"
                                >
                                    Send Email verification Link
                                </v-btn>
                            </div>
                            <div class="d-flex justify-end">
                                <v-btn type="submit" :loading="form.processing">
                                    Save
                                </v-btn>
                            </div>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
