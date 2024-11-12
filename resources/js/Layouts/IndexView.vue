<script setup lang="ts">
import { ref } from "vue";

import DataTableProps from "@/types/DataTableProps";

import AppLayout from "@/Layouts/AppLayout.vue";
import DataTable from "@/Components/DataTable.vue";

interface Props extends DataTableProps {
    title: string;
    resourceName?: string;
    permissionName?: string;
    createActionButtonText?: string;
}
defineProps<Props>();
defineEmits([
    "create-button-click",
    "select-item-to-edit",
    "click-save-changes",
    "delete",
]);

// create
const createDialog = ref(false);
</script>

<template>
    <AppLayout :title="title">
        <div class="d-flex justify-space-between flex-column flex-md-row">
            <h1 class="text-h5 mt-4">{{ title }}</h1>
        </div>

        <div class="mt-3" />

        <!-- Create item slot -->
        <slot name="create">
            <v-btn
                v-if="can(`create ${permissionName}`)"
                class="mb-4"
                prepend-icon="mdi-plus"
                :text="`Create ${resourceName ?? title}`"
                @click="createDialog = true"
            />
        </slot>

        <slot name="prepend" />

        <!-- Data table for items start -->
        <slot>
            <DataTable
                :headers="headers"
                :items="items"
                :route-name="routeName"
                :override-edit
                :override-delete
                :has-date-range
                :route-name-is-full
                :hide-actions
                :route-params
                @select-item-to-edit="
                    ($event: any) => $emit('select-item-to-edit', $event)
                "
                @click-save-changes="
                    ($event: any) => $emit('click-save-changes', $event)
                "
                @delete="($event) => $emit('delete', $event)"
            >
                <!-- re expose all data table slots -->
                <template v-for="(_, slot) in $slots" #[slot]="scope">
                    <slot :name="slot" v-bind="scope" />
                </template>
            </DataTable>
        </slot>

        <slot name="bottom" />
    </AppLayout>

    <!-- create dialog -->
    <base-dialog
        v-if="can(`create ${permissionName}`)"
        :title="`Create ${title}`"
        :subtitle="`Add new ${title} to the system`"
        :visible="createDialog"
        action-button-text="Save"
        @close="createDialog = false"
        @action-click="
            $emit('create-button-click', () => (createDialog = false))
        "
    >
        <slot name="create-form">
            <p>Use this slot to add your create form</p>
        </slot>
    </base-dialog>
</template>
