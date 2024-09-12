<script setup lang="ts">
import { ref } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import Swal from "sweetalert2";

interface Token {
    name: string;
    last_used_ago: string;
    abilities: Array<string>;
}

const props = defineProps<{
    tokens: Token[];
    availablePermissions: string[];
    defaultPermissions: string[];
}>();

const headers = [
    {
        title: "Name",
        key: "name",
    },
    {
        title: "Last Used",
        key: "last_used_ago",
    },
    {
        title: "Actions",
        key: "actions",
    },
];

const createApiTokenForm = useForm({
    name: "",
    permissions: props.defaultPermissions,
});

const updateApiTokenForm = useForm({
    permissions: [],
});

const deleteApiTokenForm = useForm({});

const displayingToken = ref(false);
const managingPermissionsFor = ref(null);

const createApiToken = () => {
    createApiTokenForm.post(route("api-tokens.store"), {
        preserveScroll: true,
        onSuccess: () => {
            displayingToken.value = true;
            createApiTokenForm.reset();
        },
    });
};

function copyToken() {
    navigator.clipboard.writeText(
        (usePage() as any).props.jetstream.flash.token
    );
    Swal.fire({
        title: "Token Copied to Clipboard",
        icon: "success",
        toast: true,
        position: "top",
        showConfirmButton: false,
        timer: 3000,
        customClass: {
            container: ["swal-container"],
        },
    });
}

function manageApiTokenPermissions(token: any) {
    updateApiTokenForm.permissions = token.abilities;
    managingPermissionsFor.value = token;
}

function updateApiToken() {
    updateApiTokenForm.put(
        route("api-tokens.update", managingPermissionsFor.value),
        {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => (managingPermissionsFor.value = null),
        }
    );
}

function deleteApiToken(token: Token) {
    Swal.fire({
        title: "Are you sure?",
        text: "This API token will be permanently deleted.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Delete",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return new Promise((resolve, reject) => {
                deleteApiTokenForm.delete(route("api-tokens.destroy", token), {
                    preserveScroll: true,
                    preserveState: true,
                    onError: () => {
                        reject();
                    },
                    onSuccess: (page) => {
                        resolve(page);
                    },
                });
            });
        },
    });
}
</script>

<template>
    <v-container fluid>
        <v-row>
            <v-col>
                <v-card
                    title="Create API Token"
                    subtitle="API tokens allow third-party services to authenticate with our application on your behalf."
                >
                    <template #text>
                        <v-form @submit.prevent="createApiToken">
                            <v-text-field
                                prepend-inner-icon="mdi-lock"
                                label="Name"
                                v-model="createApiTokenForm.name"
                                :error-messages="createApiTokenForm.errors.name"
                            />
                            <div>
                                <p class="text-subtitle-1">Permissions</p>
                                <v-checkbox
                                    v-for="permission in availablePermissions"
                                    :key="permission"
                                    v-model="createApiTokenForm.permissions"
                                    :label="permission"
                                    :value="permission"
                                    hide-details
                                />
                            </div>
                        </v-form>
                    </template>
                    <template #actions>
                        <div class="d-flex w-100 justify-end">
                            <v-btn
                                text="Create Token"
                                variant="elevated"
                                :loading="createApiTokenForm.processing"
                                @click="createApiToken"
                            />
                        </div>
                    </template>
                </v-card>
                <v-card
                    class="mt-3"
                    title="Manage API tokens"
                    subtitle="You may delete any of your existing tokens if they are no longer needed."
                >
                    <template #text>
                        <v-data-table :headers="headers" :items="tokens">
                            <template #item.last_used_ago="{ item }">
                                {{ item.last_used_ago ?? "Never" }}
                            </template>
                            <template #item.actions="{ item }">
                                <v-icon
                                    icon="mdi-pencil-outline"
                                    color="primary"
                                    @click="manageApiTokenPermissions(item)"
                                />
                                <v-icon
                                    class="ml-2"
                                    color="error"
                                    icon="mdi-trash-can-outline"
                                    @click="deleteApiToken(item)"
                                />
                            </template>
                        </v-data-table>
                    </template>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
    <div>
        <!-- Token Value Dialog -->
        <v-dialog v-model="displayingToken" z-index="1100">
            <v-row justify="center">
                <v-col cols="12" md="6">
                    <v-card title="API token" subtitle="Your API token">
                        <template #text>
                            <p class="text-subtitle-1 mb-3">
                                Please copy your new API token. For your
                                security, it won't be shown again.
                            </p>
                            <code class="bg-grey-lighten-2 pa-2 rounded-lg"
                                >{{
                                    ($page as any).props.jetstream.flash.token
                                }}
                                <v-icon
                                    icon="mdi-content-copy"
                                    @click="copyToken"
                            /></code>
                        </template>
                        <template #actions>
                            <div class="d-flex w-100 justify-end">
                                <v-btn
                                    text="Close"
                                    variant="elevated"
                                    @click="displayingToken = false"
                                />
                            </div>
                        </template>
                    </v-card>
                </v-col>
            </v-row>
        </v-dialog>

        <!-- API Token Permissions Modal -->
        <v-dialog :model-value="managingPermissionsFor != null">
            <v-row justify="center">
                <v-col cols="12" md="6">
                    <v-card
                        title="API Token Permissions"
                        subtitle="Manage permissions for this API token"
                    >
                        <template #text>
                            <v-checkbox
                                v-for="permission in availablePermissions"
                                :key="permission"
                                v-model="updateApiTokenForm.permissions"
                                :label="permission"
                                :value="permission"
                                hide-details
                            />
                        </template>
                        <template #actions>
                            <div class="d-flex w-100 justify-space-between">
                                <v-btn
                                    text="Cancel"
                                    variant="outlined"
                                    @click="managingPermissionsFor = null"
                                />
                                <v-btn
                                    text="Save"
                                    variant="elevated"
                                    :loading="updateApiTokenForm.processing"
                                    @click="updateApiToken"
                                />
                            </div>
                        </template>
                    </v-card>
                </v-col>
            </v-row>
        </v-dialog>
    </div>
</template>

<style>
.swal-container {
    z-index: 1500;
}
</style>
