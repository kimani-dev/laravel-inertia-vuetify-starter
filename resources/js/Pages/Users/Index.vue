<script setup>
import { useForm } from "@inertiajs/vue3";
import IndexView from "@/Layouts/IndexView.vue";

//props
const props = defineProps({
    users: {
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
</script>

<template>
    <IndexView title="Users" :headers="headers" :items="users">
        <template #prepend>
            <my-dialog
                title="Create User"
                subtitle="Add a new user to the system"
            >
                <template #activator="{ props }">
                    <v-btn v-bind="props" text="Add User" />
                </template>
                <template #content>
                    <v-text-field
                        label="Name"
                        prepend-inner-icon="mdi-account-outline"
                        v-model="name"
                        :error-messages="form.errors.name"
                    />
                    <v-text-field
                        label="Email"
                        prepend-inner-icon="mdi-email-outline"
                        v-model="email"
                        :error-messages="form.errors.email"
                    />
                    <v-select
                        label="Role"
                        prepend-inner-icon="mdi-shield-account-outline"
                        v-model="role"
                        :items="roles"
                        :error-messages="form.errors.role"
                        item-title="name"
                        item-value="id"
                    />
                </template>
                <template #action-button>
                    <v-btn
                        variant="elevated"
                        text="Save"
                        :loading="form.processing"
                    />
                </template>
            </my-dialog>
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
                v-for="role in item.roles"
                :key="role.id"
                color="primary"
                class="mr-2 text-capitalize"
            >
                {{ role.name }}
            </v-chip>
        </template>
        <!-- Data table slots end -->
    </IndexView>
</template>
