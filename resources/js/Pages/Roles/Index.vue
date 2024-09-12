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
        <!-- Create form content slot -->
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

        <!-- Edit form content -->
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

        <!-- Data table item slots -->
        <template #item.name="{ item }">
            <base-link :href="route('roles.show', item)">
                <p class="text-capitalize">{{ item.name }}</p>
            </base-link>
        </template>
    </IndexView>
</template>
