<script setup>
import { ref } from "vue";
import { Link, router, useForm } from "@inertiajs/vue3";
import ActionMessage from "@/Components/ActionMessage.vue";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

const props = defineProps({
    user: Object,
});

const form = useForm({
    _method: "PUT",
    name: props.user.name,
    email: props.user.email,
    photo: null,
});

const verificationLinkSent = ref(null);
const photoPreview = ref(null);
const photoInput = ref(null);

const updateProfileInformation = () => {
    if (photoInput.value) {
        form.photo = photoInput.value.files[0];
    }

    form.post(route("user-profile-information.update"), {
        errorBag: "updateProfileInformation",
        preserveScroll: true,
        onSuccess: () => clearPhotoFileInput(),
    });
};

const sendEmailVerification = () => {
    verificationLinkSent.value = true;
    router.visit(route("verification.send"));
};

const selectNewPhoto = () => {
    photoInput.value.click();
};

const updatePhotoPreview = () => {
    const photo = photoInput.value.files[0];

    if (!photo) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        photoPreview.value = e.target.result;
    };

    reader.readAsDataURL(photo);
};

const deletePhoto = () => {
    router.delete(route("current-user-photo.destroy"), {
        preserveScroll: true,
        onSuccess: () => {
            photoPreview.value = null;
            clearPhotoFileInput();
        },
    });
};

const clearPhotoFileInput = () => {
    if (photoInput.value?.value) {
        photoInput.value.value = null;
    }
};
</script>

<template>
    <v-container>
        <v-row>
            <v-col>
                <v-card>
                    <v-card-title>
                        <p class="text-h5">Profile Information</p>
                        <p class="text-subtitle-2">
                            Update your account's profile information and email
                            address.
                        </p>
                    </v-card-title>
                    <v-card-text>
                        <v-form @submit="updateProfileInformation">
                            <div
                                v-if="
                                    $page.props.jetstream.managesProfilePhotos
                                "
                            >
                                <v-avatar rounded="0" size="50">
                                    <v-img
                                        :src="
                                            !photoPreview
                                                ? user.profile_photo_url
                                                : photoPreview
                                        "
                                    ></v-img>
                                </v-avatar>
                                <v-btn class="ml-2" @click="selectNewPhoto"
                                    >Select a New Photo</v-btn
                                >
                                <v-btn
                                    class="ml-2"
                                    v-if="user.profile_photo_path"
                                    @click="deletePhoto"
                                    >Remove Photo</v-btn
                                >
                                <v-file-input
                                    class="d-none"
                                    ref="photoInput"
                                    @change="updatePhotoPreview"
                                ></v-file-input>
                            </div>
                            <v-text-field
                                class="mt-3"
                                label="Name"
                                v-model="form.name"
                                :error-messages="form.errors.name"
                            ></v-text-field>
                            <v-text-field
                                label="Email"
                                v-model="form.email"
                                :error-messages="form.errors.email"
                            ></v-text-field>
                            <div
                                v-if="
                                    $page.props.jetstream
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
                                    >Send Email verification Link</v-btn
                                >
                            </div>
                            <div class="d-flex justify-end">
                                <v-btn type="submit" :loading="form.processing"
                                    >Save</v-btn
                                >
                            </div>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
