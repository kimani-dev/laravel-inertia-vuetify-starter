<script setup lang="ts">
import { ref, Ref, shallowRef, watch } from "vue";
import { usePage } from "@inertiajs/vue3";
import { VDateInput } from "vuetify/labs/VDateInput";

const props = defineProps<{
    hasDateRange?: boolean;
}>();

const model = defineModel<{
    filters?: Record<string, string>;
    start_date?: string;
    end_date?: string;
}>();
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

// watch filters
watch(
    filters,
    () => {
        model.value = {
            ...model.value,
            ...filters.value,
        };
    },
    { deep: true }
);

// date range
const dateRange = shallowRef<string | null>(null);
watch(
    dateRange,
    () => {
        if (
            !dateRange.value ||
            !props.hasDateRange ||
            !dateRange.value.includes("-")
        ) {
            return;
        }

        model.value = {
            ...model.value,
            start_date: dateRange.value.split("-")[0],
            end_date: dateRange.value.split("-")[1],
        };
    },
    { deep: true }
);
</script>

<template>
    <v-menu
        v-if="filterOptions && Object.keys(filterOptions).length"
        :close-on-content-click="false"
    >
        <template #activator="{ props }">
            <v-badge
                dot
                :model-value="Object.values(filters).some(Boolean)"
                :content="Object.values(filters).filter(Boolean).length"
            >
                <v-btn text="Filters" variant="outlined" v-bind="props">
                    <template #append>
                        <v-icon icon="mdi-filter-variant" color="primary" />
                    </template>
                </v-btn>
            </v-badge>
        </template>

        <template #default="{ isActive }">
            <v-card width="300">
                <template #title>
                    <div class="d-flex justify-space-between">
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
                        v-for="(options, key) in filterOptions"
                        :key="key"
                        v-model="filters[key]"
                        column
                    >
                        <div>
                            <p class="text-caption text-uppercase">
                                {{ key }}
                            </p>

                            <div class="mt-2">
                                <v-chip
                                    v-for="option in options"
                                    :key="option.value"
                                    :text="option.label"
                                    :value="option.value"
                                    filter
                                    class="text-capitalize"
                                />
                            </div>
                        </div>
                    </v-chip-group>

                    <p
                        v-if="props.hasDateRange"
                        class="mt-2 text-caption text-uppercase"
                    >
                        Date
                    </p>
                    <VDateInput
                        v-if="props.hasDateRange"
                        class="mt-2"
                        label="Select Range"
                        density="compact"
                        variant="outlined"
                        prepend-icon=""
                        prepend-inner-icon="mdi-calendar-outline"
                        multiple="range"
                        v-model="dateRange"
                    />
                </template>
            </v-card>
        </template>
    </v-menu>
</template>
