<script setup lang="ts">
import { Link } from "@inertiajs/vue3";

defineProps<{
    href: string;
}>();
</script>

<template>
    <Link
        :href="href"
        class="text-decoration-none font-weight-bold text-primary"
    >
        <slot />
    </Link>
</template>
