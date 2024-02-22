<script setup>
import { router, useForm } from "@inertiajs/vue3";

import IndexView from "@/Layouts/IndexView.vue";

const props = defineProps({
    roles: {
        type: Array,
        required: true,
    },
});

const headers = [
    {
        title: "Name",
        value: "name",
    },
    {
        title: "Actions",
        value: "actions",
    },
];

// form
const form = useForm({
    name: "",
});

function createRole(closeModal) {
    form.post(route("roles.store"), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            router.reload({ only: ["roles"] });
            form.reset();
        },
    });
}
</script>

<template>
    <IndexView
        title="Roles"
        :headers="headers"
        :items="roles"
        route-name="roles"
        @create="(close) => createRole(close)"
        @delete="router.reload({ only: ['roles'] })"
    >
        <!-- Create form content slot start -->
        <template #create-content>
            <v-form :disabled="form.processing" @submit.prevent>
                <v-text-field
                    prepend-inner-icon="mdi-shield-account-outline"
                    v-model="form.name"
                    label="Name"
                    :error-messages="form.errors.name"
                />
            </v-form>
        </template>
        <!-- Create form content slot end -->
        <!-- Edit form content start -->
        <template #edit-content="{ editForm }">
            <v-form :disabled="form.processing" @submit.prevent>
                <v-text-field
                    prepend-inner-icon="mdi-shield-account-outline"
                    v-model="editForm.name"
                    label="Name"
                    :error-messages="form.errors.name"
                />
            </v-form>
        </template>
        <!-- Edit form content end -->
        <!-- Data table item slots start -->
        <template #item.name="{ item }">
            <p class="text-capitalize">{{ item.name }}</p>
        </template>
        <!-- Data table item slots end -->
        <!-- Append actions slot start -->
        <template #append-actions="{ item }">
            <v-menu>
                <template #activator="{ props }">
                    <v-icon
                        v-bind="props"
                        icon="mdi-dots-vertical"
                        class="ml-2"
                    />
                </template>
                <v-list>
                    <v-list-item
                        v-use-inertia-link
                        :href="route('roles.show', item)"
                        prepend-icon="mdi-shield-account-outline"
                        title="Manage Permissions"
                    />
                </v-list>
            </v-menu>
        </template>
        <!-- Append actions slot end -->
    </IndexView>
</template>
