<script setup>
import IndexView from "@/Layouts/IndexView.vue";
import moment from "moment";

const props = defineProps({
    logs: {
        type: Array,
        required: true,
    },
});

const headers = [
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
    {
        title: "Time",
        value: "created_at",
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
        <template #item.created_at="{ item }">
            <p>
                <v-icon
                    icon="mdi-calendar-outline"
                    class="mr-2"
                    color="primary"
                />{{ moment(item.created_at).format("Do MMM YYYY") }}
            </p>
            <p>
                <v-icon
                    icon="mdi-clock-outline"
                    class="mr-2"
                    color="primary"
                />{{ moment(item.created_at).format("hh:mm A") }}
            </p>
        </template>
        <!-- Data table slots end -->
    </IndexView>
</template>
