<script setup lang="ts">
import IndexView from "@/Layouts/IndexView.vue";
import Log from "@/types/Log";
import moment from "moment";

defineProps<{
    logs: Log[];
}>();

const headers = [
    {
        title: "Date and Time",
        value: "created_at",
        sortable: true,
    },
    {
        title: "User",
        value: "user",
    },
    {
        title: "Action",
        value: "action",
    },
    {
        title: "Resource",
        value: "resource",
    },
    {
        title: "IP Address",
        value: "ip_address",
    },
];
</script>

<template>
    <IndexView
        title="Access Logs"
        :headers="headers"
        :items="logs"
        route-name="logs"
    >
        <!-- Data table slots begin -->
        <template #item.created_at="{ item }">
            <p>
                {{ moment(item.created_at).format("Do MMM YYYY, hh:mm A") }}
            </p>
        </template>
        <template #item.user="{ item }">
            <v-list-item
                :prepend-avatar="item.user.profile_photo_url"
                :title="item.user.name"
                :subtitle="item.user.email"
            />
        </template>
        <template #item.action="{ item }">
            <v-chip :color="item.action === 'DELETE' ? 'error' : 'primary'">
                {{ item.action }}
            </v-chip>
        </template>
        <template #item.ip_address="{ item }">
            <code class="bg-grey-lighten-2 pa-2 rounded-xl">{{
                item.ip_address
            }}</code>
        </template>
        <!-- Data table slots end -->
    </IndexView>
</template>
