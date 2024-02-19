<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    headers: {
        type: Array,
        required: true,
    },
    items: {
        type: Array,
        required: true,
    },
});

const emit = defineEmits(["update", "delete"]);

const headersWithoutActions = props.headers.filter(
    (header) => header.value !== "actions"
);
</script>

<template>
    <AppLayout :title="title">
        <h1 class="text-h5">{{ title }}</h1>
        <div class="mt-3"></div>
        <slot name="Prepend" />
        <!-- Data table for items start -->
        <v-data-table
            class="elevation-3 mt-3"
            :headers="headers"
            :items="items"
        >
            <!-- Expose all item slots apart from actions start -->
            <template
                v-for="header in headersWithoutActions"
                #[`item.${header.value}`]="{ item }"
            >
                <slot :name="`item.${header.value}`" :item="item">
                    {{ item[header.value] }}
                </slot>
            </template>
            <!-- Expose all item slots apart from actions end -->
            <!-- Actions slot start -->
            <template #item.actions="{ item }">
                <v-icon
                    icon="mdi-pencil-outline"
                    color="primary"
                    @click="emit('update', item)"
                />
                <v-icon
                    class="ml-2"
                    icon="mdi-delete-outline"
                    color="error"
                    @click="emit('delete', item)"
                />
            </template>
            <!-- Actions slot end -->
        </v-data-table>
        <!-- Data table for items end -->
    </AppLayout>
</template>
