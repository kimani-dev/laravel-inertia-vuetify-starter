<script setup>
import { computed } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import IndexView from "@/Layouts/IndexView.vue";

//props
const props = defineProps({
    users: {
        type: Array,
        required: true,
    },
    roles: {
        type: Array,
        required: true,
    },
});

const headers = [
    {
        title: "User",
        value: "user",
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

function createUser(closeDialog) {
    form.post(route("users.store"), {
        onSuccess: () => {
            form.reset();
            closeDialog();
            reloadData();
        },
    });
}

function reloadData() {
    router.reload({ only: ["users"] });
}

// exportable data
const exportable = computed(() => ({
    head: ["Name", "Email", "Role"],
    body: props.users.map((user, index) => [
        user.name,
        user.email,
        user.roles.length > 0
            ? user.roles.map((role) => role.name).join(", ")
            : "Not Assigned",
    ]),
}));
</script>

<template>
    <IndexView
        title="Users"
        :headers="headers"
        :items="users"
        route-name="users"
        :exportable="exportable"
        @create="(close) => createUser(close)"
        @edit="reloadData"
        @delete="reloadData"
    >
        <template #create-content>
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
        <template #edit-content="{ editForm }">
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
        <!-- Data table slots begin -->
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
        <!-- Data table slots end -->
        <template #bottom> </template>
    </IndexView>
</template>
