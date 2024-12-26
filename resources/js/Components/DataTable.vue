<script lang="ts" setup>
import { Ref, ref, shallowRef, watch } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import { useDebounceFn } from "@vueuse/core";

import DataTableProps from "@/types/DataTableProps";
import DataTableFilter from "./DataTableFilter.vue";
import Swal from "sweetalert2";

const props = defineProps<DataTableProps>();
const emit = defineEmits([
    "select-item-to-edit",
    "click-save-changes",
    "delete",
]);

// headers without action for exposing slots
const headersWithoutActions = props.headers.filter(
    (header) => header.value !== "actions"
);

const filters: Ref<Record<string, string>> = ref({});
watch(
    filters,
    () => {
        fetchItems({ page: 1, itemsPerPage: 10 });
    },
    { deep: true }
);

// Fetch items
const isInitialRender = ref(true);
const loading = ref(false);
const search = ref("");

function fetchItems(options?: any) {
    // to avoid double fetching on initial render
    if (isInitialRender.value) {
        isInitialRender.value = false;
        return;
    }

    if (!options) {
        options = {
            page: 1,
            itemsPerPage: 10,
        };
    }

    router.get(
        route(
            `${props.routeName}${props.routeNameIsFull ? "" : ".index"}`,
            props.routeParams
        ),
        {
            ...{
                ...options,
                itemsPerPage:
                    options.itemsPerPage == -1
                        ? props.items.total
                        : options.itemsPerPage,
            },
            ...filters.value,
        },
        {
            replace: true,
            preserveScroll: true,
            preserveState: true,
            onStart: () => {
                loading.value = true;
            },
            onFinish: () => {
                loading.value = false;
            },
        }
    );
}

// Debounce search
watch(
    search,
    useDebounceFn(() => fetchItems({ search: search.value }), 500)
);

// editing
const editDialog = ref(false);
const editForm = useForm<any>({});
function selectItemToEdit(item: any) {
    if (props.overrideEdit) {
        emit("select-item-to-edit", item);
        editDialog.value = true;
        return;
    }

    for (const key in item) {
        editForm[key] = item[key];
    }

    editForm.reset();
    editDialog.value = true;
}

function saveChanges() {
    if (props.overrideEdit) {
        emit(
            "click-save-changes",
            () => {
                editDialog.value = false;
                fetchItems();
            },
            editForm
        );
        return;
    }

    editForm.post(route(`${props.routeName}.update`, editForm.id), {
        data: {
            _METHOD: "PUT",
        },
        onSuccess: () => {
            editDialog.value = false;
            fetchItems();
        },
    });
}

// deleting
function deleteItem(item: any) {
    if (props.overrideDelete) {
        emit("delete", item);
        return;
    }

    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        reverseButtons: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#6c63ff",
        customClass: {
            confirmButton: "text-white font-weight-bold",
            cancelButton: "text-white font-weight-bold",
        },
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route(`${props.routeName}.destroy`, item.id), {
                onSuccess: () => {
                    fetchItems();
                },
            });
        }
    });
}
</script>

<template>
    <v-card>
        <template #title>
            <v-row class="mt-2">
                <v-col cols="6">
                    <!-- search -->
                    <v-text-field
                        label="Search"
                        prepend-inner-icon="mdi-magnify"
                        clearable
                        v-model="search"
                    />
                </v-col>

                <v-col>
                    <div class="d-flex justify-end ga-2 mt-2">
                        <!-- filtering -->
                        <DataTableFilter v-model="filters" />

                        <!-- export -->
                        <v-btn text="Export" variant="outlined">
                            <template #append>
                                <v-icon
                                    icon="mdi-cloud-download"
                                    color="primary"
                                />
                            </template>
                        </v-btn>
                    </div>
                </v-col>
            </v-row>
        </template>

        <template #text>
            <v-data-table-server
                :headers="hideActions ? headersWithoutActions : headers"
                :items="items.data"
                :items-length="items.total"
                :loading="loading"
                @update:options="fetchItems"
            >
                <!-- expose all slots apart from action -->
                <template
                    v-for="header in headersWithoutActions"
                    #[`item.${header.value}`]="{ item }"
                >
                    <slot :name="`item.${header.value}`" :item="item">
                        {{ item[header.value] }}
                    </slot>
                </template>

                <!-- actions -->
                <template #item.actions="{ item }">
                    <slot name="item.actions" :item="item">
                        <div class="d-flex ga-1">
                            <slot name="edit" :item="item">
                                <v-icon
                                    title="Edit"
                                    icon="mdi-pencil"
                                    @click="selectItemToEdit(item)"
                                />
                            </slot>

                            <slot name="delete" :item="item">
                                <v-icon
                                    title="Delete"
                                    icon="mdi-trash-can"
                                    @click="deleteItem(item)"
                                />
                            </slot>
                        </div>
                    </slot>
                </template>
            </v-data-table-server>
        </template>
    </v-card>

    <!-- edit dialog -->
    <base-dialog
        title="Edit"
        subtitle="Edit item"
        :visible="editDialog"
        action-button-text="Update"
        @close="editDialog = false"
        @action-click="saveChanges"
    >
        <slot name="edit-form" :editForm="editForm" />
    </base-dialog>
</template>
