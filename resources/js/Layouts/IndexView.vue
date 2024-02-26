<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref } from "vue";
import Swal from "sweetalert2";
import axios from "axios";
import { useForm } from "@inertiajs/vue3";
import { useExport } from "@/Composables/useExport";

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
    routeName: {
        type: String,
        required: true,
    },
    // should receive an object with head and body arrays
    // to be used in the exportPDF function
    exportable: {
        type: Object,
        required: false,
        default: null,
    },
    // rows to use to search and filter
    filterKeys: {
        type: Array,
        required: false,
        default: () => [],
    },
});

const emit = defineEmits(["create", "edit", "delete", "selected"]);

const headersWithoutActions = props.headers.filter(
    (header) => header.value !== "actions"
);

// search and filter
const search = ref("");
const selected = ref([]);

function customFilter(value, query, item) {
    if (query === "") return true;
    if (value === null) return false;

    if (props.filterKeys.length === 0) {
        return JSON.stringify(item.raw)
            .toLowerCase()
            .includes(query.toLowerCase());
    }

    for (const key of props.filterKeys) {
        const itemValue = item.raw[key];
        if (
            itemValue &&
            itemValue.toString().toLowerCase().includes(query.toLowerCase())
        ) {
            return true;
        }
    }

    return false;
}

// editing
const editForm = useForm({});
function selectItemToEdit(item) {
    editForm
        .defaults({
            ...item,
        })
        .reset();
}
function editItem(closeDialog) {
    editForm.put(route(`${props.routeName}.update`, editForm.id), {
        onError: () => {
            Swal.fire("Error!", "Update Failed!", "error");
        },
        onSuccess: () => {
            closeDialog();
            emit("edit");
        },
    });
}

// deletions
function deleteItem(item) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
        showLoaderOnConfirm: true,
        preConfirm: async () => {
            return axios
                .post(route(`${props.routeName}.destroy`, item.id), {
                    _method: "delete",
                })
                .then(() => {
                    emit("delete", item);
                    Swal.fire("Deleted!", "Delete Success!", "success");
                })
                .catch(() => {
                    Swal.fire("Error!", "Delete Failed!", "error");
                });
        },
    });
}

function exportPDF() {
    // check if exportable is passed and has head and body arrays
    if (!props.exportable || !props.exportable.head || !props.exportable.body) {
        console.error(
            "Exportable object is required and should have head and body arrays"
        );
        return;
    }
    // use the exportable object to create the pdf
    const data = props.exportable;
    data.title = props.title;
    useExport(data).savePDF();
}
</script>

<template>
    <AppLayout :title="title">
        <div class="d-flex justify-space-between flex-column flex-md-row">
            <h1 class="text-h5 mt-4">{{ title }}</h1>
            <v-col cols="12" md="4" align-self="center">
                <v-text-field
                    label="Search"
                    prepend-inner-icon="mdi-magnify"
                    density="compact"
                    v-model="search"
                />
            </v-col>
        </div>
        <div class="mt-3" />
        <!-- Create item slot start -->
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
        <!-- Create item slot end -->
        <slot name="prepend" />
        <!-- Data table actions start -->
        <div class="d-flex justify-md-end mt-2">
            <v-menu :close-on-content-click="false">
                <template #activator="{ props }">
                    <v-btn
                        v-bind="props"
                        prepend-icon="mdi-sort"
                        text="Filter"
                        class="mr-2"
                    />
                </template>
                <v-list>
                    <v-list-subheader>Filter Items</v-list-subheader>
                    <v-chip-group filter mandatory="force">
                        <div class="d-flex flex-column w-100">
                            <v-chip active-class="text-primary">All</v-chip>
                            <v-chip>Role</v-chip>
                        </div>
                    </v-chip-group>
                </v-list>
            </v-menu>
            <v-btn
                prepend-icon="mdi-export"
                text="Export"
                :v-if="!!exportable"
                @click="exportPDF"
            />
        </div>
        <!-- Data table actions end -->
        <!-- Data table for items start -->
        <v-data-table
            id="data-table"
            class="elevation-3 mt-3"
            :headers="headers"
            :items="items"
            :search="search"
            :custom-filter="customFilter"
            show-select
            color="primary"
            v-model="selected"
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
                <my-dialog
                    :title="`Edit ${routeName}`"
                    :subtitle="`Edit ${routeName} details`"
                >
                    <template #activator="{ props }">
                        <v-icon
                            v-bind="props"
                            icon="mdi-pencil"
                            color="primary"
                            @click="selectItemToEdit(item)"
                        />
                    </template>
                    <template #content>
                        <slot name="edit-content" :editForm="editForm">
                            <p>
                                Use this slot to add your edit content e.g form
                            </p>
                        </slot>
                    </template>
                    <template #action-button="{ close }">
                        <v-btn
                            :text="`Edit ${routeName}`"
                            variant="elevated"
                            @click="editItem(close)"
                        />
                    </template>
                </my-dialog>
                <v-icon
                    class="ml-2"
                    icon="mdi-delete-outline"
                    color="error"
                    @click="deleteItem(item)"
                />
                <slot name="append-actions" :item="item" />
            </template>
            <!-- Actions slot end -->
        </v-data-table>
        <!-- Data table for items end -->
        <!-- Bottom Slot start -->
        <slot name="bottom" />
        <!-- Bottom Slot end -->
    </AppLayout>
</template>
