<script setup lang="ts">
import { useDisplay } from "vuetify";

defineProps<{
    title: string;
    subtitle: string;
    visible: boolean;
    width?: string;
    actionButtonText?: string;
    loading?: boolean;
    hideActions?: boolean;
}>();

const emit = defineEmits(["close", "action-click"]);

const { mdAndDown } = useDisplay();
</script>

<template>
    <v-dialog
        :model-value="visible"
        persistent
        scrollable
        transition="dialog-bottom-transition"
    >
        <v-card
            :title="title"
            :subtitle="subtitle"
            rounded="lg"
            :width="mdAndDown ? '100%' : width ?? '70%'"
            class="mx-auto"
        >
            <template #text>
                <div class="ma-md-2">
                    <slot />
                </div>
            </template>
            <template #actions v-if="!hideActions">
                <div class="d-flex w-100 justify-space-between ga-3">
                    <v-btn
                        text="Close"
                        variant="outlined"
                        :disabled="loading"
                        @click="$emit('close')"
                    />
                    <slot name="action-button">
                        <v-btn
                            :text="actionButtonText ?? 'Action'"
                            variant="elevated"
                            :loading="loading"
                            @click="$emit('action-click')"
                        />
                    </slot>
                </div>
            </template>
        </v-card>
    </v-dialog>
</template>
