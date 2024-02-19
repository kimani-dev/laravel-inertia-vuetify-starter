<script setup>
import { ref } from "vue";

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    subtitle: {
        type: String,
        required: false,
    },
});

const dialog = ref(false);
function closeDialog() {
    dialog.value = false;
}
</script>

<template>
    <v-dialog v-model="dialog" transition="dialog-bottom-transition">
        <template #activator="{ props }">
            <slot name="activator" :props="props">
                <v-btn v-bind="props" text="Open Dialog" />
            </slot>
        </template>
        <template #default>
            <v-card width="50%" class="mx-auto">
                <v-card-title>
                    <p class="text-h5 text-capitalize">{{ title }}</p>
                    <p class="text-caption text-capitalize">{{ subtitle }}</p>
                </v-card-title>
                <v-card-text>
                    <slot name="content" />
                </v-card-text>
                <v-card-actions>
                    <div class="d-flex justify-space-between w-100">
                        <v-btn
                            color="primary"
                            variant="outlined"
                            text="Close"
                            @click="closeDialog"
                        />
                        <slot name="action-button" :close="closeDialog">
                            <v-btn @click="closeDialog" text="Submit" />
                        </slot>
                    </div>
                </v-card-actions>
            </v-card>
        </template>
    </v-dialog>
</template>
