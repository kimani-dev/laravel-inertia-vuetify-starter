<script setup lang="ts">
import { watchEffect } from "vue";
import { ref } from "vue";

const props = defineProps<{
    title: string;
    subtitle?: string;
    showDialog?: boolean;
}>();

const emit = defineEmits(["closed"]);

const dialog = ref(false);
function closeDialog() {
    dialog.value = false;
}

watchEffect(() => {
    dialog.value = props.showDialog;
});
</script>

<template>
    <v-dialog v-model="dialog" transition="dialog-bottom-transition" persistent>
        <template #activator="{ props }">
            <slot name="activator" :props="props">
                <v-btn v-bind="props" text="Open Dialog" />
            </slot>
        </template>
        <template #default>
            <v-card
                :width="$vuetify.display.mobile ? '100%' : '50%'"
                class="mx-auto"
                :title="title"
                :subtitle="subtitle"
            >
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
