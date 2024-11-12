<script lang="ts" setup>
import { router, usePage } from "@inertiajs/vue3";
import { Ref, ref, watch } from "vue";
import { useDebounceFn } from "@vueuse/core";

import ResponseData from "@/types/ResponseData";

const props = defineProps<{
    title: string;
    showTitle?: boolean;
    headers: { title: string; value: string }[];
    items: ResponseData<Record<string, any>[]>;
    hasDateRange?: boolean; // if yes, date will be passed as start_date and end_date to your route
    routeName: string;
    routeNameIsFull?: boolean;
    routeParams?: Record<string, any>;
}>();

// headers without action for exposing slots
const headersWithoutActions = props.headers.filter(
    (header) => header.value !== "action"
);

/*
Filters
- Pass filters as props from your controller as "filterOptions" key
- Inertia will automatically share them to the page and we can use them here
   without receiving them as props via the usePage composable
e.g. 
    return Inertia::render('Users/Index', [
        'filterOptions' => [
            'status' => [
                ['label' => 'Active', 'value' => 'active'],
                ['label' => 'Inactive', 'value' => 'inactive'],
            ],
        ],
    ]);
   */
interface FilterOptions {
    [key: string]: { label: string; value: string }[];
}
const page = usePage();
const filterOptions: FilterOptions | undefined = page.props.filterOptions as
    | FilterOptions
    | undefined;
const filters: Ref<Record<string, string>> = ref({});
filters.value = Object.keys(filterOptions ?? {}).reduce((acc, key) => {
    // add filter value from query string if exists
    const url = new URLSearchParams(window.location.search);
    if (url.has(key)) {
        acc[key] = url.get(key) as string;
        return acc;
    }

    acc[key] = "";
    return acc;
}, {} as Record<string, string>);

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
            ...options,
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
</script>

<template>
    <v-card>
        <template #title>
            <div class="d-flex justify-space-between ma-1">
                <h2 class="text-h6" v-if="showTitle">{{ title }}</h2>

                <div class="d-flex ga-2 w-100">
                    <!-- search -->
                    <div class="d-flex w-50">
                        <v-text-field
                            label="Search"
                            prepend-inner-icon="mdi-magnify"
                            v-model="search"
                        />
                    </div>

                    <div class="d-flex justify-end ga-2 w-50">
                        <!-- filtering -->
                        <v-menu
                            v-if="
                                filterOptions &&
                                Object.keys(filterOptions).length
                            "
                        >
                            <template #activator="{ props }">
                                <v-badge
                                    dot
                                    :model-value="
                                        Object.values(filters).some(Boolean)
                                    "
                                    :content="
                                        Object.values(filters).filter(Boolean)
                                            .length
                                    "
                                >
                                    <v-icon
                                        title="Filters"
                                        icon="mdi-filter-variant"
                                        v-bind="props"
                                    />
                                </v-badge>
                            </template>

                            <template #default="{ isActive }">
                                <v-card width="300">
                                    <template #title>
                                        <div
                                            class="d-flex justify-space-between"
                                        >
                                            <p class="text-h6">Filters</p>
                                            <v-icon
                                                icon="mdi-close"
                                                size="small"
                                                @click="isActive.value = false"
                                            />
                                        </div>
                                    </template>

                                    <template #text>
                                        <v-chip-group
                                            v-for="(
                                                options, key
                                            ) in filterOptions"
                                            :key="key"
                                            v-model="filters[key]"
                                            column
                                        >
                                            <div>
                                                <p
                                                    class="text-caption text-uppercase"
                                                >
                                                    {{ key }}
                                                </p>

                                                <div class="mt-2">
                                                    <v-chip
                                                        v-for="option in options"
                                                        :key="option.value"
                                                        :text="option.label"
                                                        :value="option.value"
                                                        filter
                                                    />
                                                </div>
                                            </div>
                                        </v-chip-group>
                                    </template>
                                </v-card>
                            </template>
                        </v-menu>

                        <!-- export -->
                        <v-icon
                            title="Export"
                            icon="mdi-cloud-download"
                            variant="text"
                        />
                    </div>
                </div>
            </div>
        </template>

        <template #text>
            <v-data-table-server
                :headers="headers"
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
            </v-data-table-server>
        </template>
    </v-card>
</template>
