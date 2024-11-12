<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import DataTable from "@/Components/DataTable.vue";
import ResponseData from "@/types/ResponseData";

defineProps<{
    title: string;
    headers: { title: string; value: string }[];
    items: ResponseData<Record<string, any>[]>;
    routeName: string;
}>();

const emit = defineEmits(["create", "edit", "delete", "selected"]);
</script>

<template>
    <AppLayout :title="title">
        <div class="d-flex justify-space-between flex-column flex-md-row">
            <h1 class="text-h5 mt-4">{{ title }}</h1>
        </div>

        <div class="mt-3" />

        <!-- Create item slot -->
        <slot name="create">
            <my-dialog
                v-if="can(`create ${routeName}`)"
                :title="`Create ${title}`"
                :subtitle="`Add new ${title} to the system`"
            >
                <template #activator="{ props }">
                    <v-btn
                        v-bind="props"
                        prepend-icon="mdi-plus"
                        :text="`Create ${title}`"
                    />
                </template>
                <template #content>
                    <slot name="create-content">
                        <p>Use this slot to add your create content e.g form</p>
                    </slot>
                </template>
                <template #action-button="{ close }">
                    <v-btn
                        :text="`Create ${title}`"
                        variant="elevated"
                        @click="emit('create', close)"
                    />
                </template>
            </my-dialog>
        </slot>

        <slot name="prepend" />

        <!-- Data table for items start -->
        <slot>
            <DataTable
                class="mt-5"
                :title
                :headers="headers"
                :items="items"
                :route-name="routeName"
            >
                <!-- re expose all data table slots -->
                <template v-for="(_, slot) in $slots" #[slot]="scope">
                    <slot :name="slot" v-bind="scope" />
                </template>
            </DataTable>
        </slot>

        <slot name="bottom" />
    </AppLayout>
</template>
