<script setup lang="ts">
import { router, useForm } from "@inertiajs/vue3";

import ResponseData from "@/types/ResponseData";
import User from "@/types/User";
import Role from "@/types/Role";

import IndexView from "@/Layouts/IndexView.vue";

defineProps<{
    users: ResponseData<User[]>;
    roles: Role[];
}>();

const headers = [
    {
        title: "Name",
        value: "name",
    },
    {
        title: "Email",
        value: "email",
    },
    {
        title: "Role",
        value: "roles",
    },
    {
        title: "Actions",
        value: "actions",
    },
];

// form
const form = useForm({
    name: "",
    email: "",
    role: null,
});

function createUser(closeDialog: Function) {
    form.post(route("users.store"), {
        onSuccess: () => {
            form.reset();
            closeDialog();
        },
    });
}

// edit form
const editForm = useForm({
    id: null as number | null,
    name: "",
    email: "",
    role: null as number | null,
});

function selectItemToEdit(user: User) {
    editForm.id = user.id;
    editForm.name = user.name;
    editForm.email = user.email;
    editForm.role = user.roles.length > 0 ? user.roles[0].id : null;
}

function saveChanges(closeDialog: Function) {
    editForm.put(route("users.update", editForm.id), {
        onSuccess: () => {
            closeDialog();
        },
    });
}
</script>

<template>
    <IndexView
        title="Users"
        :headers="headers"
        :items="users"
        route-name="users"
        permission-name="users"
        :override-edit="true"
        @create-button-click="createUser"
        @select-item-to-edit="selectItemToEdit"
        @click-save-changes="saveChanges"
    >
        <!-- Create form slot -->
        <template #create-form>
            <v-form @submit.prevent>
                <v-text-field
                    label="Name"
                    prepend-inner-icon="mdi-account-outline"
                    v-model="form.name"
                    :error-messages="form.errors.name"
                />
                <v-text-field
                    label="Email"
                    prepend-inner-icon="mdi-email-outline"
                    v-model="form.email"
                    :error-messages="form.errors.email"
                />
                <v-select
                    label="Role"
                    prepend-inner-icon="mdi-shield-account-outline"
                    v-model="form.role"
                    :items="roles"
                    :error-messages="form.errors.role"
                    :item-title="
                        (item) =>
                            item.name
                                .split(' ')
                                .map(
                                    (word) =>
                                        word.charAt(0).toUpperCase() +
                                        word.slice(1)
                                )
                                .join(' ')
                    "
                    item-value="id"
                />
            </v-form>
        </template>

        <!-- Edit form slot -->
        <template #edit-form>
            <v-form @submit.prevent>
                <v-text-field
                    label="Name"
                    prepend-inner-icon="mdi-account-outline"
                    v-model="editForm.name"
                    :error-messages="editForm.errors.name"
                />
                <v-text-field
                    label="Email"
                    prepend-inner-icon="mdi-email-outline"
                    v-model="editForm.email"
                    :error-messages="editForm.errors.email"
                />
                <v-select
                    label="Role"
                    prepend-inner-icon="mdi-shield-account-outline"
                    v-model="editForm.role"
                    :items="roles"
                    :error-messages="editForm.errors.role"
                    :item-title="
                        (item) =>
                            item.name
                                .split(' ')
                                .map(
                                    (word) =>
                                        word.charAt(0).toUpperCase() +
                                        word.slice(1)
                                )
                                .join(' ')
                    "
                    item-value="id"
                />
            </v-form>
        </template>

        <!-- Data table slots -->
        <template #item.user="{ item }">
            <v-list-item
                :title="item.name"
                :subtitle="item.email"
                :prepend-avatar="item.profile_photo_url"
            />
        </template>
        <template #item.roles="{ item }">
            <v-chip
                v-if="item.roles.length > 0"
                v-for="role in item.roles"
                :key="role.id"
                color="primary"
                class="mr-2 text-capitalize"
            >
                {{ role.name }}
            </v-chip>
            <v-chip v-else color="error" class="mr-2"> Not Assigned </v-chip>
        </template>
    </IndexView>
</template>
