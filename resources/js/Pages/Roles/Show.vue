<script setup lang="ts">
import { computed } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import Swal from "sweetalert2";

import AppLayout from "@/Layouts/AppLayout.vue";

import Role from "@/types/Role";
import Permission from "@/types/Permission";

const props = defineProps<{
    role: Role;
    permissions: Permission[];
}>();

// group permissions by resource
const groupedPermissions = computed(() =>
    props.permissions.reduce(
        (acc: { [key: string]: Permission[] }, permission) => {
            if (!acc[permission.name.split(" ")[1]]) {
                acc[permission.name.split(" ")[1]] = [];
            }

            acc[permission.name.split(" ")[1]].push(permission);

            return acc;
        },
        {}
    )
);

//form
const form = useForm({
    permissions: props.role.permissions.map((permission) => permission.id),
});

function selectAllGroup(group: string) {
    form.permissions = [
        ...form.permissions,
        ...groupedPermissions.value[group].map((permission) => permission.id),
    ];
}

function savePermissions() {
    form.put(route("roles.update", props.role.id), {
        onError: () => {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Something went wrong!",
            });
        },
        onSuccess: () => {
            router.reload({ only: ["role"] });
            Swal.fire({
                icon: "success",
                title: "Permissions updated successfully",
            });
        },
    });
}
</script>

<template>
    <AppLayout title="Manage Permissions">
        <p class="text-h5 text-capitalize">
            Manage Permissions for {{ role.name }}
        </p>

        <v-btn
            text="Assign Permissions"
            class="mt-3"
            prepend-icon="mdi-shield-plus-outline"
            :disabled="!form.isDirty"
            :loading="form.processing"
            @click="savePermissions"
        />

        <v-container class="mt-3">
            <v-row>
                <v-col
                    cols="12"
                    md="4"
                    v-for="group in Object.keys(groupedPermissions)"
                    :key="group"
                >
                    <v-card>
                        <v-card-title>
                            <p class="text-h5 text-capitalize">{{ group }}</p>
                            <p class="text-caption text-capitalize">
                                Manage {{ group }} permissions for
                                {{ role.name }}
                            </p>
                        </v-card-title>
                        <v-card-text>
                            <v-checkbox
                                v-for="permission in groupedPermissions[group]"
                                :key="permission.id"
                                class="text-capitalize"
                                :label="permission.name"
                                :value="permission.id"
                                v-model="form.permissions"
                                hide-details
                            />

                            <v-btn
                                text="Select All"
                                size="small"
                                @click="selectAllGroup(group)"
                            />
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </AppLayout>
</template>
